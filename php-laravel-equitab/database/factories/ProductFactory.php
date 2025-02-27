<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_id' => Transaction::factory(),
            'name' => fake()->words(fake()->numberBetween(2, 4), true),
            'index' => fn($attributes) => Transaction::find($attributes['transaction_id'])->products()->count(),
            'quantity' => fake()->numberBetween(1, 3),
            'cost' => fake()->numberBetween(1, 1000) / 100
        ];
    }
}
