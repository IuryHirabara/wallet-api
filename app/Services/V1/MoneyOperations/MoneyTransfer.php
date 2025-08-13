<?php

namespace App\Services\V1\MoneyOperations;

use App\Contracts\V1\Account\{ManagesAccount, RecoversAccount};
use App\Contracts\V1\MoneyOperations\PerformsMoneyOperation;
use App\Http\Resources\V1\AccountResource;
use App\Models\Account;
use App\Services\V1\Account\AccountManager;
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

        return [
            'origin' => new AccountResource($this->manager->getAccount()),
            'destination' => new AccountResource($this->toManager->getAccount())
        ];
    }
}
