<?php

namespace App\Observers;

use App\Events\TransactionCreated;
use App\Events\TransactionDeleted;
use App\Events\TransactionUpdated;
use App\Models\Transaction;

class TransactionObserver
{
    public function created(Transaction $transaction): void
    {
        // TODO Increment all transaction ower aggregates on ledger user aggregates
        event(new TransactionCreated($transaction));
    }

    public function updating(Transaction $transaction): void
    {
        // TODO Decrement all transaction ower aggregates on ledger user aggregates
    }

    public function updated(Transaction $transaction): void
    {
        // TODO Increment all transaction ower aggregates on ledger user aggregates
        event(new TransactionUpdated($transaction));
    }

    public function deleted(Transaction $transaction): void
    {
        // TODO Decrement all transaction ower aggregates on ledger user aggregates
        event(new TransactionDeleted($transaction));
    }
}
