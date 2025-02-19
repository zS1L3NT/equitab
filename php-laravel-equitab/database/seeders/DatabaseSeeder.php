<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            FriendshipSeeder::class,
            CurrencySeeder::class,
            CategorySeeder::class,
            // LedgerSeeder::class,
            // TransactionSeeder::class,
            // ProductSeeder::class,
        ]);
    }
}
