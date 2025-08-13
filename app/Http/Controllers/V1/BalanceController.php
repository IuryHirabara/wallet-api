<?php

namespace App\Http\Controllers\V1;

use App\Contracts\V1\Account\RecoversAccount;
use App\Http\Controllers\Controller;
use Illuminate\Http\{Request, Response};

class BalanceController extends Controller
{
    /**
     * Display the balance of a specific account.
     *
     * @param Request $request
     * @param RecoversAccount $retriever
     * @return Response
     */
    public function show(Request $request, RecoversAccount $retriever)
    {
        $account = $retriever->findById($request->query('account_id'));

        if (!$account) {
            return response('0', Response::HTTP_NOT_FOUND);
        }

        return $account->balance;
    }
}
