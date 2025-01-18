<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Ledger;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = fake()->dateTimeBetween('-2 months', 'now');

        return [
            'ledger_id' => Ledger::factory(),
            'name' => fake()->words(fake()->numberBetween(5, 10), true),
            'cost' => fake()->numberBetween(100_000, 1_000_000) / 100,
            'location' => fake()->boolean() ? fake()->address() : null,
            'datetime' => $date,
            'category_id' => Category::inRandomOrder()->first()->id,
            'payer_id' => fn ($attributes) => Ledger::find($attributes['ledger_id'])->users()->inRandomOrder()->first()->id,
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
