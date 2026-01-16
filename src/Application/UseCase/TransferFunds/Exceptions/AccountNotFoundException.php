<?php

declare(strict_types=1);

namespace App\Application\UseCase\TransferFunds\Exceptions;

use RuntimeException;

final class AccountNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Account not found');
    }
}
