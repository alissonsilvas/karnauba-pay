<?php

declare(strict_types=1);

use Slim\App;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Application\UseCase\CreateAccount\CreateAccountUseCase;
use App\Application\UseCase\CreateAccount\CreateAccountInput;
use App\Application\UseCase\TransferFunds\TransferFundsUseCase;
use App\Application\UseCase\TransferFunds\TransferFundsInput;
use App\Application\UseCase\TransferFunds\Exceptions\AccountNotFoundException;
use App\Application\UseCase\TransferFunds\Exceptions\InsufficientFundsException;
use App\Application\UseCase\TransferFunds\Exceptions\InvalidTransferException;
use App\Infrastructure\Persistence\InMemory\InMemoryAccountRepository;

return function (App $app): void {

    $repository = new InMemoryAccountRepository();

    $createAccount = new CreateAccountUseCase($repository);
    $transferFunds = new TransferFundsUseCase($repository);

    /**
     * POST /accounts
     */
    $app->post('/accounts', function (
        ServerRequestInterface $request,
        ResponseInterface $response
    ) use ($createAccount) {

        $data = json_decode((string) $request->getBody(), true);

        $input = new CreateAccountInput(
            $data['account_id'],
            (float) $data['initial_balance']
        );

        $output = $createAccount->execute($input);

        $response->getBody()->write(json_encode($output));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    });

    /**
     * POST /transfers
     */
    $app->post('/transfers', function (
        ServerRequestInterface $request,
        ResponseInterface $response
    ) use ($transferFunds) {

        try {
            $data = json_decode((string) $request->getBody(), true);

            $input = new TransferFundsInput(
                $data['from_account_id'],
                $data['to_account_id'],
                (float) $data['amount']
            );

            $output = $transferFunds->execute($input);

            $response->getBody()->write(json_encode($output));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);

        } catch (InvalidTransferException $e) {
            return error($response, 422, $e->getMessage());

        } catch (AccountNotFoundException $e) {
            return error($response, 404, $e->getMessage());

        } catch (InsufficientFundsException $e) {
            return error($response, 409, $e->getMessage());
        }
    });

    /**
     * GET /home
     */
    $app->get('/home', function ($request, $response) {
        $payload = [
            'status' => 'ok',
            'service' => 'karnauba-pay',
            'timestamp' => time()
        ];

        $response->getBody()->write(json_encode($payload));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    });
};

/**
 * Helper para erro JSON
 */
function error(ResponseInterface $response, int $status, string $message): ResponseInterface
{
    $payload = ['error' => $message];

    $response->getBody()->write(json_encode($payload));

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus($status);
}

