<?php

namespace App\Http\Controllers\V1;

use App\Contracts\V1\Account\RecoversAccount;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreEventRequest;
use App\Services\V1\MoneyOperations\MoneyOperationFactory;
use App\Services\V1\Wallet\WalletManager;
use Illuminate\Http\Response;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class EventController extends Controller
{
    public function __construct(
        private readonly WalletManager $walletManager
    ) {}

    /**
     * Do a money operation based on the event type. To know which types are accepted see the MoneyOperationFactory.
     *
     * @param StoreEventRequest $request
     * @param RecoversAccount $accountRetriever
     * @return Response
     */
    public function store(StoreEventRequest $request, RecoversAccount $accountRetriever)
    {
        $type = $request->validated('type');
        $amount = $request->validated('amount');
        $validated = collect($request->validated());

        $moneyOperation = MoneyOperationFactory::create($type, $accountRetriever);

        try {
            $moneyOperation->setManagersFromData($validated);
        } catch (NotFoundResourceException $e) {
            return response('0', Response::HTTP_NOT_FOUND);
        }

        $data = $this->walletManager->setMoneyOperation($moneyOperation)
            ->doMoneyOperation($amount);

        return response()->json($data, Response::HTTP_CREATED);
    }
}
