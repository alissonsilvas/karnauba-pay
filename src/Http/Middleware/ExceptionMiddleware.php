<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Domain\Account\Exception\AccountNotFoundException;
use App\Domain\Account\Exception\InsufficientFundsException;
use App\Domain\Exception\DomainException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;
use Throwable;

final class ExceptionMiddleware
{
    public function __invoke(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        try {
            return $handler->handle($request);
        } catch (Throwable $exception) {
            return $this->handleException($exception);
        }
    }

    private function handleException(Throwable $exception): ResponseInterface
    {
        return match (true) {
            $exception instanceof AccountNotFoundException =>
            $this->jsonResponse(
                404,
                'ACCOUNT_NOT_FOUND',
                'Account not found'
            ),

            $exception instanceof InsufficientFundsException =>
            $this->jsonResponse(
                422,
                'INSUFFICIENT_FUNDS',
                'Insufficient funds'
            ),

            $exception instanceof DomainException =>
            $this->jsonResponse(
                400,
                'DOMAIN_ERROR',
                $exception->getMessage()
            ),

            default =>
            $this->jsonResponse(
                500,
                'INTERNAL_SERVER_ERROR',
                'Unexpected error'
            ),
        };
    }

    private function jsonResponse(
        int $status,
        string $code,
        string $message,
        array $details = []
    ): ResponseInterface {
        $response = new Response($status);

        $payload = [
            'code' => $code,
            'message' => $message,
        ];

        if (!empty($details)) {
            $payload['details'] = $details;
        }

        $response->getBody()->write(json_encode($payload));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
