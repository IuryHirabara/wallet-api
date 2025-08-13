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

    /**
     * Set AccountManager of origin and destination accounts based on data received in request. The data should have a 'origin' key and a 'destination' key with the respective account IDs.
     *
     * This method will try to find the accounts by ID and set them in the manager and toManager properties. If not found, it will create a new account for destination. For the origin account it will throw a NotFoundResourceException.
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

    /**
     * Perform the transfer operation between the managed accounts and return the updated account resources.
     *
     * @param int $amount
     * @return array
     */
    public function doMoneyOperation(int $amount)
    {
        $this->manager->transfer($this->toManager, $amount);

        return [
            'origin' => new AccountResource($this->manager->getAccount()),
            'destination' => new AccountResource($this->toManager->getAccount())
        ];
    }
}
