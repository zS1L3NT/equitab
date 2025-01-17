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
        'currency',
        'picture',
    ];

    public function getSummaryAttribute() {
        // TODO Summarise the ledger for the current user
        return 'Summary...';
    }
    
    public function getPictureAttribute(): string|null
    {
        return $this->attributes['picture'] ? asset($this->attributes['picture']) : null;
    }

    public function setPictureAttribute(string|UploadedFile $picture): void
    {
        $this->attributes['picture'] = $picture instanceof UploadedFile ? '/' . $picture->storePubliclyAs('images/ledgers/' . $this->id . '.png') : $picture;
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }
}
