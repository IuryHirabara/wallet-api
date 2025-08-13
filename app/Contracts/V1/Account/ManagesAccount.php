<?php

namespace App\Contracts\V1\Account;

use App\Models\Account;

interface ManagesAccount
{
    public function getAccount(): Account;

    public function setAccount(Account $account): self;

    public function deposit(int $amount): self;

    public function withdraw(int $amount): self;

    public function transfer(ManagesAccount $account, int $amount): self;
}
