<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    private const USERS = 25;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'username' => 'zS1L3NT',
            'phone_number' => '+6588206212',
            'password' => 'P@ssw0rd'
        ]);

        User::factory()->count(static::USERS)->create();
    }
}
