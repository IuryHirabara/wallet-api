<?php

namespace App\Contracts\V1\MoneyOperations;

use Illuminate\Support\Collection;

interface PerformsMoneyOperation
{
    public function setManagersFromData(Collection $data);

    public function doMoneyOperation(int $amount);
}
