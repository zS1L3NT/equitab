<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Ledger extends Model
{
    /** @use HasFactory<\Database\Factories\LedgerFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'picture',
        'currency_code',
        'user_ids'
    ];

    public function getAggregatesAttribute() {
        return $this->users()
            ->withPivot('aggregate')
            ->get()
            ->map(fn($u) => [$u->username => $u->pivot->aggregate])
            ->collapseWithKeys();
    }

    public function getPictureAttribute(): string|null
    {
        return $this->attributes['picture'] ? asset($this->attributes['picture']) : null;
    }

    public function setPictureAttribute(UploadedFile|string|null $picture): void
    {
        $this->attributes['picture'] = $picture instanceof UploadedFile ? '/' . $picture->storePubliclyAs('images/ledgers/' . $this->id . '.png') : $picture;
    }

    public function setUserIdsAttribute(array $userIds)
    {
        if ($this->id) {
            $this->users()->sync($userIds);
        }
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
