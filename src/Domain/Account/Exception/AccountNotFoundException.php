<?php

declare(strict_types=1);

namespace App\Domain\Account\Exception;

use App\Domain\Exception\DomainException;

final class AccountNotFoundException extends DomainException
{
    public function __construct(string $accountId)
    {
        parent::__construct("Account '{$accountId}' not found");
    }
}
