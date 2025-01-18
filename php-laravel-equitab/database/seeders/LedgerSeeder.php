<?php

namespace Database\Seeders;

use App\Models\Ledger;
use App\Models\User;
use Illuminate\Database\Seeder;

class LedgerSeeder extends Seeder
{
    private const LEDGERS = 100;
    private const LEDGER_USERS_MIN = 3;
    private const LEDGER_USERS_MAX = 10;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        Ledger::factory()->count(static::LEDGERS)->create();

        foreach (Ledger::all() as $ledger) {
            $count = fake()->numberBetween(static::LEDGER_USERS_MIN, static::LEDGER_USERS_MAX);
            $ledger->users()->attach($users->random($count));
        }
    }
}
