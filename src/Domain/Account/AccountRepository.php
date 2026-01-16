<?php

declare(strict_types=1);

namespace App\Domain\Account;

interface AccountRepository
{
    public function save(Account $account): void;

    public function findById(AccountId $id): ?Account;
}
