<?php

declare(strict_types=1);

namespace App\Application\UseCase\CreateAccount;

use App\Domain\Account\Account;
use App\Domain\Account\AccountId;
use App\Domain\Account\AccountRepository;

final class CreateAccountUseCase
{
    public function __construct(
        private AccountRepository $repository
    ) {}

    public function execute(CreateAccountInput $input): CreateAccountOutput
    {
        $account = new Account(
            new AccountId($input->accountId),
            $input->initialBalance
        );

        $this->repository->save($account);

        return new CreateAccountOutput(
            $account->id()->value,
            $account->balance()
        );
    }
}
