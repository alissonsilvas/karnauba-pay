<?php

declare(strict_types=1);

namespace App\Application\UseCase\TransferFunds;

use App\Domain\Account\AccountRepository;
use App\Domain\Account\AccountId;
use App\Application\UseCase\TransferFunds\Exceptions\AccountNotFoundException;
use App\Application\UseCase\TransferFunds\Exceptions\InsufficientFundsException;
use App\Application\UseCase\TransferFunds\Exceptions\InvalidTransferException;

final class TransferFundsUseCase
{
    public function __construct(
        private AccountRepository $repository
    ) {}

    public function execute(TransferFundsInput $input): TransferFundsOutput
{
    if ($input->amount <= 0) {
        throw new InvalidTransferException('Transfer amount must be greater than zero');
    }

    if ($input->fromAccountId === $input->toAccountId) {
        throw new InvalidTransferException('Cannot transfer to the same account');
    }

    $fromAccountId = new AccountId($input->fromAccountId);
    $toAccountId   = new AccountId($input->toAccountId);

    $from = $this->repository->findById($fromAccountId);
    $to   = $this->repository->findById($toAccountId);

    if (!$from || !$to) {
        throw new AccountNotFoundException();
    }

    if (!$from->hasBalance($input->amount)) {
        throw new InsufficientFundsException();
    }

    $from->debit($input->amount);
    $to->credit($input->amount);

    $this->repository->save($from);
    $this->repository->save($to);

    return new TransferFundsOutput(
        $from->id()->value(),
        $to->id()->value(),
        $input->amount,
        $from->balance(),
        $to->balance()
    );
}

}
