<?php

namespace App\Models;

use App\Observers\LedgerUserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[ObservedBy([LedgerUserObserver::class])]
class LedgerUser extends Pivot
{
    public $timestamps = null;

    protected $casts = [
        'aggregate' => 'float',
    ];

    public function ledger()
    {
        return $this->belongsTo(Ledger::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
