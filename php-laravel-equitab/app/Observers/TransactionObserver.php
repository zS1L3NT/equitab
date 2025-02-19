<?php

namespace App\Observers;

use App\Events\TransactionCreated;
use App\Events\TransactionDeleted;
use App\Events\TransactionUpdated;
use App\Models\Transaction;

class TransactionObserver
{
    private function cascadeAggregation(Transaction $transaction, bool $undo = false)
    {
        $ledger_payer = $transaction->ledger->users()->find($transaction->payer_id);
        if (!$undo) {
            $ledger_payer->pivot->increment('aggregate', $transaction->cost);
        } else {
            $ledger_payer->pivot->decrement('aggregate', $transaction->cost);
        }

        foreach ($transaction->owers as $ower) {
            $toaggregate = $ower->pivot;
            $luaggregate = $transaction->ledger->users()->find($ower->id)->pivot;

            if (!$undo) {
                $luaggregate->increment('aggregate', $toaggregate);
            } else {
                $luaggregate->decrement('aggregate', $toaggregate);
            }
        }
    }

    public function created(Transaction $transaction): void
    {
        $transaction->updateQuietly(request(['owers']));

        $this->cascadeAggregation($transaction);

        event(new TransactionCreated($transaction));
    }

    public function updating(Transaction $transaction): void
    {
        $this->cascadeAggregation($transaction, true);
    }

    public function updated(Transaction $transaction): void
    {
        $this->cascadeAggregation($transaction);

        event(new TransactionUpdated($transaction));
    }

    public function deleted(Transaction $transaction): void
    {
        $this->cascadeAggregation($transaction, true);

        event(new TransactionDeleted($transaction));
    }
}
