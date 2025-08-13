<?php

namespace App\Services\V1\MoneyOperations;

use App\Contracts\V1\Account\{ManagesAccount, RecoversAccount};
use App\Contracts\V1\MoneyOperations\PerformsMoneyOperation;
use App\Http\Resources\V1\AccountResource;
use App\Services\V1\Account\AccountManager;
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

        return [
            'origin' => new AccountResource($this->manager->getAccount())
        ];
    }
}
