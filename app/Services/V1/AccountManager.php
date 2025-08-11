<?php

namespace App\Services\V1;

use App\Contracts\V1\ManagesAccount;
use App\Models\Account;

class AccountManager implements ManagesAccount
{
    private Account $account;

    public function setAccount(Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    public function getBalance(): int
    {
        return $this->account->balance;
    }

    public function deposit(int $amount): self
    {
        $this->account->increment('balance', $amount);

        return $this;
    }

    public function withdraw(int $amount): self
    {
        $this->account->balance -= $amount;

        $this->account->save();

        $this->account->refresh();

        return $this;
    }

    public function transfer(ManagesAccount $account, int $amount): self
    {
        $this->withdraw($amount);

        $account->deposit($amount);

        return $this;
    }
}
