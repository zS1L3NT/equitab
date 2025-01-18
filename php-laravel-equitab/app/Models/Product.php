<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, \Znck\Eloquent\Traits\BelongsToThrough;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'index',
        'quantity',
        'cost',
        'ower_ids'
    ];

    protected $with = [
        'owers',
    ];

    public function setOwerIdsAttribute(array $owerIds)
    {
        if ($this->id) {
            $this->owers()->sync($owerIds);
        }
    }

    public function owers()
    {
        return $this->belongsToMany(User::class, 'product_ower', 'product_id', 'ower_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function ledger()
    {
        return $this->belongsToThrough(Ledger::class, Transaction::class);
    }
}
