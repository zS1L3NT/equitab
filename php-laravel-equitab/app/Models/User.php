<?php

namespace App\Models;

use DDZobov\PivotSoftDeletes\Concerns\HasRelationships as HasSoftRelationships;
use DDZobov\PivotSoftDeletes\Relations\BelongsToManySoft;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use Notifiable, HasApiTokens, HasFactory, HasSoftRelationships;

    protected $fillable = [
        'username',
        'phone_number',
        'picture',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'phone_number_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getPictureAttribute(): string|null
    {
        return isset($this->attributes['picture']) ? asset($this->attributes['picture']) : null;
    }

    public function setPictureAttribute(UploadedFile|string|null $picture): void
    {
        $this->attributes['picture'] = $picture instanceof UploadedFile ? '/' . $picture->storePubliclyAs('images/users/' . $this->username . '.png') : $picture;
    }

    public function friends(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id');
    }

    public function outgoing_friends(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friend_requests', 'from_user_id', 'to_user_id');
    }

    public function incoming_friends(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friend_requests', 'to_user_id', 'from_user_id');
    }

    public function ledgers(): BelongsToManySoft
    {
        return $this->belongsToMany(Ledger::class)->withSoftDeletes();
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'ower_id');
    }
}
