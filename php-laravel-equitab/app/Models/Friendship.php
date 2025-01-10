<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $from_user_id
 * @property int $to_user_id
 * @property boolean $accepted
 *
 * @property User $from_user
 * @property User $to_user
 */
class Friendship extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'accepted'
    ];

    protected $casts = [
        'accepted' => 'boolean'
    ];

    public function from_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function to_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function other(User $user): User | null
    {
        return $this->from_user_id == $user->id ? $this->to_user : ($this->to_user_id == $user->id ? $this->from_user : null);
    }
}
