<?php

namespace App\Services\V1\MoneyOperations;

use App\Contracts\V1\{PerformsMoneyOperation, RecoversAccount};

class MoneyOperationFactory
{
    public static function create(string $type, RecoversAccount $accountRetriever): PerformsMoneyOperation
    {
        return match ($type) {
            'deposit' => new MoneyDepositor($accountRetriever),
            'withdraw' => new MoneyWithdraw($accountRetriever),
            'transfer' => new MoneyTransfer($accountRetriever),
            default => throw new \InvalidArgumentException('invalid money operation'),
        };
    }
}
