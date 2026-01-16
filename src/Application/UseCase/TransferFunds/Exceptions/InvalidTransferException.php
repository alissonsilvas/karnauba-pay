<?php

declare(strict_types=1);

namespace App\Application\UseCase\TransferFunds\Exceptions;

use RuntimeException;

final class InvalidTransferException extends RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
