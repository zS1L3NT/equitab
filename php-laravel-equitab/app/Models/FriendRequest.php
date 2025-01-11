<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $from_user_id
 * @property int $to_user_id
 *
 * @property User $from_user
 * @property User $to_user
 */
class FriendRequest extends Model
{
    public const UPDATED_AT = null;


    protected $fillable = [
        'from_user_id',
        'to_user_id',
    ];

    public function from_user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function to_user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
