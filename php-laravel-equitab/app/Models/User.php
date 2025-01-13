<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
 * @property Collection<User> $outgoing_friends
 * @property Collection<User> $incoming_friends
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
        'pivot'
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
}
