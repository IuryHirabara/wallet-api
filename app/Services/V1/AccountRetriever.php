<?php

namespace App\Services\V1;

use App\Contracts\V1\RecoversAccount;
use App\Models\Account;

class AccountRetriever implements RecoversAccount
{
    public function findById(string $id): ?Account
    {
        return Account::where('id', $id)->first();
    }
}
