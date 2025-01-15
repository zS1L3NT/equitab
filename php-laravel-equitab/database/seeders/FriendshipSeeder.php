<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class FriendshipSeeder extends Seeder
{
    private const USER_FRIENDS_MIN = 1;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $count = fake()->numberBetween(static::USER_FRIENDS_MIN, $users->count());

            foreach ($users->random($count) as $friend) {
                if ($user->id == $friend->id) continue;
                if ($user->friends()->where('friend_id', $friend->id)->exists()) continue;

                $user->friends()->attach($friend);
                $friend->friends()->attach($user);
            }
        }
    }
}
