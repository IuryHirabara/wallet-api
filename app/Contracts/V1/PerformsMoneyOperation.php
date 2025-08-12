<?php

namespace App\Contracts\V1;

use Illuminate\Support\Collection;

interface PerformsMoneyOperation
{
    public function setManagersFromData(Collection $data);

    public function doMoneyOperation(int $amount);
}
