<?php

namespace App\Observers;

use App\Events\TransactionCreated;
use App\Events\TransactionDeleted;
use App\Events\TransactionUpdated;
use App\Models\LedgerUser;
use App\Models\Transaction;

class TransactionObserver
{
    public function created(Transaction $transaction): void
    {
        $transaction->updateQuietly(request(['owers']));

        LedgerUser::query()
            ->where(['ledger_id' => $transaction->ledger_id, 'user_id' => $transaction->payer_id])
            ->increment('aggregate', $transaction->cost);

        event(new TransactionCreated($transaction));
    }

    public function updating(Transaction $transaction): void
    {
        LedgerUser::query()
            ->where(['ledger_id' => $transaction->ledger_id, 'user_id' => $transaction->payer_id])
            ->increment('aggregate', $transaction->cost - $transaction->getOriginal()['cost']);
    }

    public function updated(Transaction $transaction): void
    {
        event(new TransactionUpdated($transaction));
    }

    public function deleted(Transaction $transaction): void
    {
        LedgerUser::query()
            ->where(['ledger_id' => $transaction->ledger_id, 'user_id' => $transaction->payer_id])
            ->decrement('aggregate', $transaction->cost - $transaction->getOriginal()['cost']);

        event(new TransactionDeleted($transaction));
    }
}
