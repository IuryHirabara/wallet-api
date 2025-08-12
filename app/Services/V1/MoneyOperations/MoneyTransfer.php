<?php

namespace App\Services\V1\MoneyOperations;

use App\Contracts\V1\{ManagesAccount, PerformsMoneyOperation, RecoversAccount};
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

        $toAccount = $this->accountRetriever->findByIdOrFail(
            $data->get('destination')
        );

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
            'origin' => $this->manager->getAccount(),
            'destination' => $this->toManager->getAccount()
        ];
    }
}
