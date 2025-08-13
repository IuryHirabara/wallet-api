<?php

namespace App\Contracts\V1\MoneyOperations;

use Illuminate\Support\Collection;

/**
 * Contract for classes that perform money operations.
 *
 * This interface defines the methods required for performing money operations.
 * It includes methods for setting managers from data received by requests and executing a money operation like deposit, withdrawal, or transfer.
 */
interface PerformsMoneyOperation
{
    public function setManagersFromData(Collection $data);

    public function doMoneyOperation(int $amount);
}
