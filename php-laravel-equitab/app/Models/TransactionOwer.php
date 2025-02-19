<?php

namespace App\Models;

use App\Observers\TransactionOwerObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[ObservedBy([TransactionOwerObserver::class])]
class TransactionOwer extends Pivot
{
    public $timestamps = null;

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function ower()
    {
        return $this->belongsTo(User::class, 'ower_id');
    }
}
