<?php

namespace App\Models;

use DDZobov\PivotSoftDeletes\Concerns\HasRelationships as HasSoftRelationships;
use DDZobov\PivotSoftDeletes\Relations\BelongsToManySoft;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Ledger extends Model
{
    /** @use HasFactory<\Database\Factories\LedgerFactory> */
    use HasFactory, HasSoftRelationships;

    protected $fillable = [
        'name',
        'picture',
        'currency_code',
        'users'
    ];

    protected $with = [
        'currency',
        'users',
    ];

    public function getPictureAttribute(): string|null
    {
        return isset($this->attributes['picture']) ? asset($this->attributes['picture']) : null;
    }

    public function setPictureAttribute(UploadedFile|string|null $picture): void
    {
        $this->attributes['picture'] = $picture instanceof UploadedFile ? '/' . $picture->storePubliclyAs('images/ledgers/' . $this->id . '.png') : $picture;
    }

    public function setUsersAttribute(array $users)
    {
        if ($this->id) {
            $this->users()->sync(array_map(fn($u) => $u['id'], $users));
        }
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function users(): BelongsToManySoft
    {
        return $this->belongsToMany(User::class)
            ->withPivot('aggregate')
            ->withSoftDeletes()
            ->withTrashedPivots();
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)
            ->latest('datetime');
    }
}
