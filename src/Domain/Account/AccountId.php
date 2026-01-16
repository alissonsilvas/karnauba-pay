<?php

declare(strict_types=1);

namespace App\Domain\Account;

final readonly class AccountId
{
    public function __construct(public string $value) {}
}
