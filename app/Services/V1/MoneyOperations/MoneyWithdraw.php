<?php

namespace App\Services\V1\MoneyOperations;

use App\Contracts\V1\{ManagesAccount, PerformsMoneyOperation, RecoversAccount};
use App\Services\V1\AccountManager;
use Illuminate\Support\Collection;

class MoneyWithdraw implements PerformsMoneyOperation
{
    private ManagesAccount $manager;

    public function __construct(
        private RecoversAccount $accountRetriever
    ) {}

    public function setManagersFromData(Collection $data)
    {
        $account = $this->accountRetriever->findByIdOrFail(
            $data->get('origin')
        );

        $this->manager = new AccountManager();
        $this->manager->setAccount($account);
    }

    public function doMoneyOperation(int $amount)
    {
        $this->manager->withdraw($amount);

        $account = $this->manager->getAccount();

        return [
            'origin' => [
                'id' => (string) $account->id,
                'balance' => $account->balance
            ],
        ];
    }
}
