<?php

namespace App\Models;

use App\Enums\FriendshipStatus;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

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

    public function friendships(): HasMany
    {
        $sent = $this->hasMany(Friendship::class, 'to_user_id');
        $received = $this->hasMany(Friendship::class, 'from_user_id');
        return $sent->union($received)->latest();
    }
}
