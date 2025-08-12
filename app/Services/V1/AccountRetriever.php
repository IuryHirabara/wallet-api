<?php

namespace App\Services\V1;

use App\Contracts\V1\RecoversAccount;
use App\Models\Account;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class AccountRetriever implements RecoversAccount
{
    public function findById(string $id): ?Account
    {
        return Account::where('id', $id)->first();
    }

    public function findByIdOrFail(string $id): Account
    {
        $account = $this->findById($id);

        if (!$account) {
            throw new NotFoundResourceException("Account with id '$id' not found.");
        }

        return $account;
    }
}
