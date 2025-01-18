<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ledger>
 */
class LedgerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = fake()->dateTimeBetween('-3 months', 'now');

        return [
            'name' => fake()->words(fake()->numberBetween(3, 5), true),
            'picture' => fake()->boolean() ? fake()->imageUrl(500, 500) : null,
            'currency_code' => Currency::inRandomOrder()->first()->code,
            'created_at' => $date,
            'updated_at' => $date
        ];
    }
}
