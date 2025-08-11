<?php

namespace App\Http\Controllers\V1;

use App\Contracts\V1\{ManagesAccount, RecoversAccount};
use App\Http\Controllers\Controller;
use Illuminate\Http\{Request, Response};

class BalanceController extends Controller
{
    public function show(Request $request, RecoversAccount $retriever, ManagesAccount $manager)
    {
        $account = $retriever->findById($request->query('account_id'));

        if (!$account) {
            return response('0', Response::HTTP_NOT_FOUND);
        }

        return $manager->setAccount($account)->getBalance();
    }
}
