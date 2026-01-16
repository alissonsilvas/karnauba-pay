<?php

declare(strict_types=1);

namespace App\Application\UseCase\TransferFunds\Exceptions;

use RuntimeException;

final class InsufficientFundsException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Insufficient funds');
    }
}
