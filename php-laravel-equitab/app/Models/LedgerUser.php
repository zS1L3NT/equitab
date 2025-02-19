<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

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
