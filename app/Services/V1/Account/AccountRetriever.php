<?php

namespace App\Services\V1\Account;

use App\Contracts\V1\Account\RecoversAccount;
use App\Models\Account;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

/**
 * Service for retrieving wallet accounts.
 */
class AccountRetriever implements RecoversAccount
{
    /**
     * Find an account by its ID.
     *
     * @param string $id
     * @return Account|null
     */
    public function findById(string $id): ?Account
    {
        return Account::where('id', $id)->first();
    }

    /**
     * Find an account by its ID or fail.
     *
     * @param string $id
     * @return Account
     * @throws NotFoundResourceException
     */
    public function findByIdOrFail(string $id): Account
    {
        $account = $this->findById($id);

        if (!$account) {
            throw new NotFoundResourceException("Account with id '$id' not found.");
        }

        return $account;
    }
}
