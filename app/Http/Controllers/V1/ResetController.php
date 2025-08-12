<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Services\V1\Wallet\WalletResetter;

class ResetController extends Controller
{
    public function index(WalletResetter $resetter)
    {
        $resetter->reset();

        return 'OK';
    }
}
