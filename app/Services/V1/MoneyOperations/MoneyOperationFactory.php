<?php

namespace App\Services\V1\MoneyOperations;

use App\Contracts\V1\Account\RecoversAccount;
use App\Contracts\V1\MoneyOperations\PerformsMoneyOperation;

/**
 * Factory class to create money operation services.
 */
class MoneyOperationFactory
{
    /**
     * Create a new concrete class that implements PerformsMoneyOperation based on type provided.
     *
     * @param string $type
     * @param RecoversAccount $accountRetriever
     * @return PerformsMoneyOperation
     */
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
