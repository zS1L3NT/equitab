<?php

namespace App\Observers;

use App\Models\ProductOwer;
use App\Models\TransactionOwer;

class ProductOwerObserver
{
    public function created(ProductOwer $pivot): void
    {
        TransactionOwer::query()
            ->where(['transaction_id' => $pivot->product->transaction_id, 'ower_id' => $pivot->ower_id])
            ->increment('aggregate', $pivot->aggregate);
    }

    public function updating(ProductOwer $pivot): void
    {
        TransactionOwer::query()
            ->where(['transaction_id' => $pivot->product->transaction_id, 'ower_id' => $pivot->ower_id])
            ->increment('aggregate', $pivot->aggregate - $pivot->getOriginal()['aggregate']);
    }

    public function deleted(ProductOwer $pivot): void
    {
        TransactionOwer::query()
            ->where(['transaction_id' => $pivot->product->transaction_id, 'ower_id' => $pivot->ower_id])
            ->decrement('aggregate', $pivot->aggregate);
    }
}
