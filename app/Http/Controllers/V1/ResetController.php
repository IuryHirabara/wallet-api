<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Services\V1\Wallet\WalletResetter;

class ResetController extends Controller
{
    /**
     * Reset the wallet API state.
     *
     * @param WalletResetter $resetter
     * @return string
     */
    public function index(WalletResetter $resetter)
    {
        $resetter->reset();

        return 'OK';
    }
}
