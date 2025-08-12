<?php

namespace App\Services\V1\MoneyOperations;

use App\Contracts\V1\{ManagesAccount, PerformsMoneyOperation, RecoversAccount};
use App\Models\Account;
use App\Services\V1\AccountManager;
use Illuminate\Support\Collection;

class MoneyTransfer implements PerformsMoneyOperation
{
    private ManagesAccount $manager;

    private ManagesAccount $toManager;

    public function __construct(
        private RecoversAccount $accountRetriever
    ) {}

    public function setManagersFromData(Collection $data)
    {
        $account = $this->accountRetriever->findByIdOrFail(
            $data->get('origin')
        );

        $toAccountId = $data->get('destination');

        $toAccount = $this->accountRetriever->findById($toAccountId);

        if (!$toAccount) {
            $toAccount = Account::create(['id' => $toAccountId, 'balance' => 0]);
            $toAccount = $this->accountRetriever->findByIdOrFail($toAccountId);
        }

        $this->manager = new AccountManager();
        $this->manager->setAccount($account);

        $this->toManager = new AccountManager();
        $this->toManager->setAccount($toAccount);

        return $this;
    }

    public function doMoneyOperation(int $amount)
    {
        $this->manager->transfer($this->toManager, $amount);

        $account = $this->manager->getAccount();
        $toAccount = $this->toManager->getAccount();

        return [
            'origin' => [
                'id' => (string) $account->id,
                'balance' => $account->balance
            ],
            'destination' => [
                'id' => (string) $toAccount->id,
                'balance' => $toAccount->balance,
            ]
        ];
    }
}
