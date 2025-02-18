<?php

namespace App\Models;

use App\Observers\ProductObserver;
use DDZobov\PivotSoftDeletes\Concerns\HasRelationships as HasSoftRelationships;
use DDZobov\PivotSoftDeletes\Relations\BelongsToManySoft;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Znck\Eloquent\Traits\BelongsToThrough;

#[ObservedBy([ProductObserver::class])]
class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, HasSoftRelationships, BelongsToThrough;

    public $timestamps = false;

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

    public function getTotalCostAttribute()
    {
        return round($this->cost * $this->quantity * 100, 2);
    }

    public function setOwersAttribute(array $owers)
    {
        $owers = collect($owers);

        if ($this->id) {
            $this->owers()->sync($owers->pluck('id')->toArray());

            foreach ($this->owers as $ower) {
                $aggregate = $owers->where('id', $ower->id)->first()['aggregate'];
                $ower->pivot->update(compact('aggregate'));
            }
        }
    }

    public function owers()
    {
        return $this->belongsToMany(User::class, 'product_ower', 'product_id', 'ower_id')
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
