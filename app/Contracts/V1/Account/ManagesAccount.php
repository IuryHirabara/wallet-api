<?php

namespace App\Contracts\V1\Account;

use App\Models\Account;

/**
 * Contract for classes that manage wallet accounts.
 *
 * This interface defines the methods required for managing a wallet account.
 * It includes methods for retrieving, setting, depositing, withdrawing, and transferring funds between accounts.
 */
interface ManagesAccount
{
    public function getAccount(): Account;

    public function setAccount(Account $account): self;

    public function deposit(int $amount): self;

    public function withdraw(int $amount): self;

    public function transfer(ManagesAccount $account, int $amount): self;
}
