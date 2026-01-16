<?php

declare(strict_types=1);

namespace App\Domain\Account;

final class Account
{
    private float $balance;

    public function __construct(
        private readonly AccountId $id,
        float $initialBalance = 0.0
    ) {
        if ($initialBalance < 0) {
            throw new \InvalidArgumentException('Initial balance cannot be negative');
        }

        $this->balance = $initialBalance;
    }

    public function id(): AccountId
    {
        return $this->id;
    }

    public function balance(): float
    {
        return $this->balance;
    }
}
