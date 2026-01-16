<?php

declare(strict_types=1);

namespace App\Domain\Account\Exception;

use App\Domain\Exception\DomainException;

final class InsufficientFundsException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Insufficient funds');
    }
}
