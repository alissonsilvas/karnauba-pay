<?php

declare(strict_types=1);

namespace App\Application\UseCase\CreateAccount;

final readonly class CreateAccountInput
{
    public function __construct(
        public string $accountId,
        public float $initialBalance
    ) {}
}
