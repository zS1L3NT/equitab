<?php

namespace Database\Seeders;

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
        User::query()->create([
            'username' => 'zS1L3NT',
            'phone_number' => '+6588206212',
            'password' => 'P@ssw0rd'
        ]);
    }
}
