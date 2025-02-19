<?php

namespace App\Models;

use App\Observers\TransactionObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([TransactionObserver::class])]
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
        'payer',
        'owers'
    ];

    protected $with = [
        'payer',
        'owers',
        'category',
    ];

    protected $casts = [
        'cost' => 'float',
        'datetime' => 'datetime:c'
    ];

    public function setPayerAttribute(array $payer)
    {
        $this->payer_id = $payer['id'];
    }

    public function setOwersAttribute(array $owers)
    {
        if ($this->id) {
            $this->owers()->sync(collect($owers)->mapWithKeys(fn($o) => [$o['id'] => ['aggregate' => $o['aggregate']]])->toArray());
        }
    }

    public function payer()
    {
        return $this->belongsTo(User::class);
    }

    public function owers()
    {
        return $this->belongsToMany(User::class, TransactionOwer::class, 'transaction_id', 'ower_id')
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
