<?php

namespace App\Services\V1\MoneyOperations;

use App\Contracts\V1\Account\{ManagesAccount, RecoversAccount};
use App\Contracts\V1\MoneyOperations\PerformsMoneyOperation;
use App\Http\Resources\V1\AccountResource;
use App\Services\V1\Account\AccountManager;
use Illuminate\Support\Collection;

/**
 * Service to withdraw money from accounts.
 */
class MoneyWithdraw implements PerformsMoneyOperation
{
    private ManagesAccount $manager;

    public function __construct(
        private RecoversAccount $accountRetriever
    ) {}

    /**
     * Set AccountManager based on account data received in request. The data should have a 'origin' key with the account ID.
     *
     * This method will try to find the account by ID and set it in the manager property. If not found, it will throw a NotFoundResourceException.
     * 
     * @param Collection $data
     * @return void
     * @throws NotFoundResourceException
     */
    public function setManagersFromData(Collection $data)
    {
        $account = $this->accountRetriever->findByIdOrFail(
            $data->get('origin')
        );

        $this->manager = new AccountManager();
        $this->manager->setAccount($account);
    }

    /**
     * Perform the withdraw operation on the account managed by the manager property and return the origin account as a resource.
     *
     * @param int $amount
     * @return array
     */
    public function doMoneyOperation(int $amount)
    {
        $this->manager->withdraw($amount);

        return [
            'origin' => new AccountResource($this->manager->getAccount())
        ];
    }
}
