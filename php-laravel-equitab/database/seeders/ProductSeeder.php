<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    private const PRODUCTS_MIN = 2;
    private const PRODUCTS_MAX = 10;
    private const TRANSACTION_OWERS_MIN = 1;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Transaction::all() as $transaction) {
            if (fake()->boolean() && fake()->boolean()) {
                $count = fake()->numberBetween(self::PRODUCTS_MIN, self::PRODUCTS_MAX);

                for ($i = 0; $i < $count; $i++) {
                    Product::factory()->for($transaction)->create();
                }

                $remaining = $transaction->cost - $transaction->products->sum(fn($p) => $p->quantity * $p->cost);
                $transaction->products()->create([
                    'name' => 'equalizer',
                    'index' => $transaction->products->count(),
                    'quantity' => 1,
                    'cost' => $remaining
                ]);

                foreach ($transaction->products as $product) {
                    $count = fake()->numberBetween(static::TRANSACTION_OWERS_MIN, $transaction->owers->count());
                    $product->owers()->attach($transaction->owers->random($count));
                }
            }
        }
    }
}
