<?php

namespace Database\Seeders;

use App\Models\Ledger;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    private const TRANSACTIONS_MIN = 5;
    private const TRANSACTIONS_MAX = 10;
    private const PRODUCT_OWERS_MIN = 1;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Ledger::all() as $ledger) {
            $count = fake()->numberBetween(self::TRANSACTIONS_MIN, self::TRANSACTIONS_MAX);
            Transaction::factory()->count($count)->for($ledger)->create();

            foreach ($ledger->transactions as $transaction) {
                $count = fake()->numberBetween(static::PRODUCT_OWERS_MIN, $ledger->users->count());
                $transaction->owers()->attach($ledger->users->random($count));
            }
        }
    }
}
