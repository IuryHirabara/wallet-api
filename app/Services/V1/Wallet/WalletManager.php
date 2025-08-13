<?php

namespace App\Services\V1\Wallet;

use App\Contracts\V1\MoneyOperations\PerformsMoneyOperation;

/**
 * Class to manage wallet operations.
 */
class WalletManager
{
    private PerformsMoneyOperation $moneyOperation;

    public function doMoneyOperation(int $amount)
    {
        return $this->moneyOperation->doMoneyOperation($amount);
    }

    public function setMoneyOperation(PerformsMoneyOperation $moneyOperation): self
    {
        $this->moneyOperation = $moneyOperation;

        return $this;
    }
}
