<?php

namespace App\Services\V1\Wallet;

use App\Contracts\V1\MoneyOperations\PerformsMoneyOperation;
use Illuminate\Validation\ValidationException;

/**
 * Class to manage wallet operations.
 */
class WalletManager
{
    private PerformsMoneyOperation $moneyOperation;

    /**
     * @throws ValidationException if the amount is not positive.
     */
    public function doMoneyOperation(int $amount)
    {
        if (!$this->isPositive($amount)) {
            throw ValidationException::withMessages(['amount must be positive']);
        }

        return $this->moneyOperation->doMoneyOperation($amount);
    }

    private function isPositive(int $amount): bool
    {
        return $amount > 0;
    }

    public function setMoneyOperation(PerformsMoneyOperation $moneyOperation): self
    {
        $this->moneyOperation = $moneyOperation;

        return $this;
    }
}
