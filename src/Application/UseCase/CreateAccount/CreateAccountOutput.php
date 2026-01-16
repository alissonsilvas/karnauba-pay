<?php

declare(strict_types=1);

namespace App\Application\UseCase\CreateAccount;

final readonly class CreateAccountOutput
{
    public function __construct(
        public string $accountId,
        public float $balance
    ) {}
}
