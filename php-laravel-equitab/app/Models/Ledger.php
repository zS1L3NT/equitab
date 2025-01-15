<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    /** @use HasFactory<\Database\Factories\LedgerFactory> */
    use HasFactory;

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function transactions() {
        return $this->hasMany(related: Transaction::class);
    }
}
