<?php

namespace App\Services\V1\MoneyOperations;

use App\Contracts\V1\Account\{ManagesAccount, RecoversAccount};
use App\Contracts\V1\MoneyOperations\PerformsMoneyOperation;
use App\Http\Resources\V1\AccountResource;
use App\Models\Account;
use App\Services\V1\Account\AccountManager;
use Illuminate\Support\Collection;

/**
 * Service for depositing money into accounts.
 */
class MoneyDepositor implements PerformsMoneyOperation
{
    private ManagesAccount $manager;

    public function __construct(
        private RecoversAccount $accountRetriever
    ) {}

    /**
     * Set AccountManager based on account data received in request. The data should have a 'destination' key with the account ID.
     *
     * This method will try to find the account by ID and set it in the manager property, if not found it will create a new account with a zero balance.
     *
     * @param Collection $data
     * @return void
     * @throws NotFoundResourceException
     */
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

    /**
     * Perform the deposit operation on the account managed by the manager property and return the destination account as a resource.
     *
     * @param int $amount
     * @return array
     */
    public function doMoneyOperation(int $amount)
    {
        $this->manager->deposit($amount);

        return [
            'destination' => new AccountResource($this->manager->getAccount()),
        ];
    }
}
