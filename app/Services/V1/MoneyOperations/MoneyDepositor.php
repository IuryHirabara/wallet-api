<?php

namespace App\Services\V1\MoneyOperations;

use App\Contracts\V1\{ManagesAccount, PerformsMoneyOperation, RecoversAccount};
use App\Models\Account;
use App\Services\V1\AccountManager;
use Illuminate\Support\Collection;

class MoneyDepositor implements PerformsMoneyOperation
{
    private ManagesAccount $manager;

    public function __construct(
        private RecoversAccount $accountRetriever
    ) {}

    public function setManagersFromData(Collection $data)
    {
        $accountId = $data->get('destination');

        $account = $this->accountRetriever->findById(
            $accountId
        );

        if (!$account) {
            $account = Account::create(['id' => $accountId, 'balance' => 0]);
            $account = $this->accountRetriever->findByIdOrFail($accountId);
        }

        $this->manager = new AccountManager();
        $this->manager->setAccount($account);
    }

    public function doMoneyOperation(int $amount)
    {
        $this->manager->deposit($amount);

        return [
            'destination' => $this->manager->getAccount(),
        ];
    }
}
