<?php

namespace App\Models;

use App\Enums\FriendshipStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $username
 * @property string $phone_number
 * @property Carbon|null $phone_number_verified_at
 * @property string|null $picture_path
 * @property string $password
 *
 * @property Collection<User> $friends
 */
class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasFactory;

    protected $fillable = [
        'username',
        'phone_number',
        'picture_path',
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

    public function getPicturePathAttribute(): string|null
    {
        return $this->attributes['picture_path'] ? asset($this->attributes['picture_path']) : null;
    }

    public function setPictureFileAttribute(string|UploadedFile $picture): void
    {
        $this->attributes['picture_path'] = $picture instanceof UploadedFile ? '/' . $picture->storePubliclyAs('images/users/' . $this->username . '.png') : $picture;
    }

    public function friendships(): HasMany
    {
        $sent = $this->hasMany(Friendship::class, 'to_user_id');
        $received = $this->hasMany(Friendship::class, 'from_user_id');
        return $sent->union($received)->latest();
    }

    public function getFriendsAttribute()
    {
        return $this
            ->friendships()
            ->where('accepted', true)
            ->get()
            ->map(fn($f) => $f->other($this));
    }
}
