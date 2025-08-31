<?php

namespace App\Services\V1\Account;

use App\Contracts\V1\Account\ManagesAccount;
use App\Models\Account;

/**
 * Service for managing wallet accounts.
 */
class AccountManager implements ManagesAccount
{
    private Account $account;

    public function setAccount(Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    public function getAccount(): Account
    {
        return $this->account;
    }

    /**
     * Deposit money into the account. Amount should be validated before calling this method.
     *
     * @param int $amount
     * @return self
     */
    public function deposit(int $amount): self
    {
        $this->account->increment('balance', $amount);

        return $this;
    }

    /**
     * Withdraw money from the account. Amount should be validated before calling this method.
     *
     * @param int $amount
     * @return self
     */
    public function withdraw(int $amount): self
    {
        $this->account->balance -= $amount;

        $this->account->save();

        $this->account->refresh();

        return $this;
    }

    /**
     * Transfer money from this account to another account. Amount should be validated before calling this method.
     *
     * @param ManagesAccount $account
     * @param int $amount
     * @return self
     */
    public function transfer(ManagesAccount $account, int $amount): self
    {
        if ($amount < 1) {
            throw ValidationException::withMessages(["amount must be greater than 0"]);
        }

        $this->withdraw($amount);

        $account->deposit($amount);

        return $this;
    }
}
