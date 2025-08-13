<?php

namespace App\Contracts\V1\Account;

use App\Models\Account;

interface RecoversAccount
{
    public function findById(string $id): ?Account;

    public function findByIdOrFail(string $id): Account;
}
