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
            $user->friends()->attach($users->random($count));
        }
    }
}
