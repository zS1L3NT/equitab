<?php

namespace App\Models;

use App\Observers\ProductObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Znck\Eloquent\Traits\BelongsToThrough;

#[ObservedBy([ProductObserver::class])]
class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, BelongsToThrough;

    public $timestamps = null;

    protected $fillable = [
        'name',
        'index',
        'quantity',
        'cost',
        'owers'
    ];

    protected $touches = [
        'transaction'
    ];

    protected $with = [
        'owers',
    ];

    protected $casts = [
        'cost' => 'float',
    ];

    public function getTotalCostAttribute()
    {
        return round($this->cost * $this->quantity * 100, 2);
    }

    public function setOwersAttribute(array $owers)
    {
        if ($this->id) {
            $this->owers()->sync(collect($owers)->mapWithKeys(fn($o) => [$o['id'] => ['aggregate' => $o['aggregate']]])->toArray());
        }
    }

    public function owers()
    {
        return $this->belongsToMany(User::class, ProductOwer::class, 'product_id', 'ower_id')
            ->withPivot('aggregate');
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
