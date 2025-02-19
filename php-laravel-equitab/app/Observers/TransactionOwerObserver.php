<?php

namespace App\Observers;

use App\Models\LedgerUser;
use App\Models\TransactionOwer;

class TransactionOwerObserver
{
    public function created(TransactionOwer $pivot): void
    {
        LedgerUser::query()
            ->where(['ledger_id' => $pivot->transaction->ledger_id, 'user_id' => $pivot->ower_id])
            ->increment('aggregate', $pivot->aggregate);
    }

    public function updating(TransactionOwer $pivot): void
    {
        LedgerUser::query()
            ->where(['ledger_id' => $pivot->transaction->ledger_id, 'user_id' => $pivot->ower_id])
            ->increment('aggregate', $pivot->aggregate - $pivot->getOriginal()['aggregate']);
    }

    public function deleted(TransactionOwer $pivot): void
    {
        LedgerUser::query()
            ->where(['ledger_id' => $pivot->transaction->ledger_id, 'user_id' => $pivot->ower_id])
            ->decrement('aggregate', $pivot->aggregate);
    }
}
