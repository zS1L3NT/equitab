<?php

namespace Database\Seeders;

use App\Models\Friendship;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'username' => 'zS1L3NT',
            'phone_number' => '+6588206212',
            'password' => 'P@ssw0rd'
        ]);

        $users = collect([$user]);

        for ($i = 0; $i < 100; $i++) {
            $user = User::factory()->create();

            foreach ($users as $_user) {
                if (fake()->boolean()) {
                    Friendship::query()->create([
                        'user_id' => $user->id,
                        'friend_id' => $_user->id,
                    ]);

                    Friendship::query()->create([
                        'user_id' => $_user->id,
                        'friend_id' => $user->id,
                    ]);
                }
            }

            $users->push($user);
        }
    }
}
