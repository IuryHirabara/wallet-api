<?php

namespace App\Contracts\V1\Account;

use App\Models\Account;

/**
 * Contract for classes that recover wallet accounts.
 *
 * This interface defines the methods required for recovering a wallet account.
 * It includes methods for finding accounts by ID, either returning null or throwing an exception if not found.
 */
interface RecoversAccount
{
    public function findById(string $id): ?Account;

    public function findByIdOrFail(string $id): Account;
}
