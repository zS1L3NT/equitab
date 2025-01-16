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
        'picture_path',
    ];

    public function getDescriptionAttribute() {
        // TODO Summarise the ledger for the current user
        return 'Summary...';
    }
    
    public function getPicturePathAttribute(): string|null
    {
        return $this->attributes['picture_path'] ? asset($this->attributes['picture_path']) : null;
    }

    public function setPictureFileAttribute(string|UploadedFile $picture): void
    {
        $this->attributes['picture_path'] = $picture instanceof UploadedFile ? '/' . $picture->storePubliclyAs('images/ledgers/' . $this->id . '.png') : $picture;
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function transactions() {
        return $this->hasMany(related: Transaction::class);
    }
}
