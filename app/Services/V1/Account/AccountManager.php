<?php

namespace App\Services\V1\Account;

use App\Contracts\V1\Account\ManagesAccount;
use App\Models\Account;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
     * @throws ValidationException if the amount is greater than the balance.
     */
    public function withdraw(int $amount): self
    {
        DB::transaction(function () use ($amount) {
            $account = DB::table('accounts')->where('id', $this->account->id)
                ->lockForUpdate()->first();

            if ($account->balance < $amount) {
                $message = "insufficient funds in account ID '{$this->account->id}'";
                throw ValidationException::withMessages([$message]);
            }

            DB::table('accounts')->where('id', $this->account->id)
                ->update(['balance' => $account->balance - $amount]);
        });

        $this->account->refresh();

        return $this;
    }

    /**
     * Transfer money from this account to another account. Amount should be validated before calling this method.
     *
     * @param ManagesAccount $account
     * @param int $amount
     * @return self
     * @throws ValidationException if the amount is less than 1
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
