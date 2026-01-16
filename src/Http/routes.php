<?php

declare(strict_types=1);

use Slim\App;
use App\Application\UseCase\CreateAccount\CreateAccountUseCase;
use App\Application\UseCase\CreateAccount\CreateAccountInput;
use App\Infrastructure\Persistence\InMemory\InMemoryAccountRepository;

return function (App $app): void {

    $repository = new InMemoryAccountRepository();
    $createAccount = new CreateAccountUseCase($repository);

    $app->post('/accounts', function ($request, $response) use ($createAccount) {
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
