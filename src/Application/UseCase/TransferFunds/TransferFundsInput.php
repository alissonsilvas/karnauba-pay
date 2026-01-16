<?php

declare(strict_types=1);

namespace App\Application\UseCase\TransferFunds;

final readonly class TransferFundsInput
{
    public function __construct(
        public string $fromAccountId,
        public string $toAccountId,
        public float $amount
    ) {}
}
