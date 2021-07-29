<?php

namespace App\Observers;

use App\Models\Transaction;

class TransactionObserver
{
    /**
     * @param Transaction $transaction
     */
    public function created(Transaction $transaction)
    {
        $balance = $transaction->account->balance
            + $transaction->value;
        $transaction->account->update(['balance' => $balance]);
    }
}
