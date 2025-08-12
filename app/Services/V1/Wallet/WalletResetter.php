<?php

namespace App\Services\V1\Wallet;

use App\Models\Account;

class WalletResetter
{
    public function reset()
    {
        return Account::query()->delete();
    }
}
