<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'cost',
        'location',
        'datetime',
        'category_id',
        'payer_id',
        'ower_ids'
    ];

    protected $with = [
        'payer',
        'owers',
        'category',
    ];

    protected $casts = [
        'datetime' => 'datetime:c'
    ];

    public function setOwerIdsAttribute(array $owerIds) {
        if ($this->id) {
            $this->owers()->sync($owerIds);
        }
    }

    public function payer() {
        return $this->belongsTo(User::class);
    }

    public function owers() {
        return $this->belongsToMany(User::class, 'transaction_ower', 'transaction_id', 'ower_id');
    }

    public function ledger() {
        return $this->belongsTo(Ledger::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function products() {
        return $this->hasMany(Product::class)->orderBy('index');
    }
}
