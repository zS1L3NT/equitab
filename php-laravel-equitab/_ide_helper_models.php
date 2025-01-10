<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $from_user_id
 * @property int $to_user_id
 * @property boolean $accepted
 * @property User $from_user
 * @property User $to_user
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\FriendshipFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Friendship newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Friendship newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Friendship query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Friendship whereAccepted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Friendship whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Friendship whereFromUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Friendship whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Friendship whereToUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Friendship whereUpdatedAt($value)
 */
	class Friendship extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $username
 * @property string $phone_number
 * @property Carbon|null $phone_number_verified_at
 * @property string|null $picture_path
 * @property string $password
 * @property Collection<User> $friends
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Friendship> $friendships
 * @property-read int|null $friendships_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-write mixed $picture_file
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhoneNumberVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePicturePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 */
	class User extends \Eloquent {}
}

