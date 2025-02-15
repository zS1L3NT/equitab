<?php

namespace App\Models;

use DDZobov\PivotSoftDeletes\Concerns\HasRelationships as HasSoftRelationships;
use DDZobov\PivotSoftDeletes\Relations\BelongsToManySoft;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Zing\LaravelEloquentRelationships\HasMoreRelationships;
use Zing\LaravelEloquentRelationships\Relations\BelongsToOne;

/**
 * @property \App\Models\User $payer
 */
class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory, HasSoftRelationships, HasMoreRelationships;

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

    public function setPayerAttribute(array $payer)
    {
        if ($this->id) {
            $this->payer()->sync([$payer['id']]);
        }
    }

    public function setOwersAttribute(array $owers)
    {
        if ($this->id) {
            $this->owers()->sync(array_map(fn($o) => $o['id'], $owers));

            foreach ($this->owers as $ower) {
                $aggregate = array_filter($owers, fn($o) => $o['id'] == $ower->id)[0]['aggregate'];
                $ower->pivot->update(compact('aggregate'));
            }
        }
    }

    public function payer(): BelongsToOne
    {
        return $this->belongsToOne(User::class, 'transaction_payer', 'transaction_id', 'payer_id')
            ->withPivot('aggregate');
    }

    public function owers(): BelongsToManySoft
    {
        return $this->belongsToMany(User::class, 'transaction_ower', 'transaction_id', 'ower_id')
            ->withPivot('aggregate')
            ->withSoftDeletes()
            ->withTrashedPivots();
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
