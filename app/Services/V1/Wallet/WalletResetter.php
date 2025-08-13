<?php

namespace App\Services\V1\Wallet;

use App\Models\Account;

/**
 * Service responsible for resetting the API state.
 */
class WalletResetter
{
    public function reset()
    {
        return Account::query()->delete();
    }
}
