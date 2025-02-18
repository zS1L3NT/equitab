<?php

namespace App\Models;

use App\Observers\TransactionObserver;
use DDZobov\PivotSoftDeletes\Concerns\HasRelationships as HasSoftRelationships;
use DDZobov\PivotSoftDeletes\Relations\BelongsToManySoft;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([TransactionObserver::class])]
class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory, HasSoftRelationships;

    protected $fillable = [
        'name',
        'cost',
        'location',
        'datetime',
        'category_id',
        'payer',
        'owers'
    ];

    protected $with = [
        'payer',
        'owers',
        'category',
    ];

    protected $casts = [
        'datetime' => 'datetime:c'
    ];

    public function setPayerAttribute(array $payer)
    {
        $this->payer_id = $payer['id'];
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

    public function payer()
    {
        return $this->belongsTo(User::class);
    }

    public function owers(): BelongsToManySoft
    {
        return $this->belongsToMany(User::class, 'transaction_ower', 'transaction_id', 'ower_id')
            ->withPivot('aggregate');
    }

    public function ledger()
    {
        return $this->belongsTo(Ledger::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class)->orderBy('index');
    }
}
