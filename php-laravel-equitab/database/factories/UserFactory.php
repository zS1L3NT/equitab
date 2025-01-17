<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static::$password = static::$password ?? bcrypt('P@ssw0rd');
        $date = fake()->dateTimeBetween('-1 years', 'now');

        return [
            'username' => $this->faker->userName(),
            'phone_number' => '+65' . fake()->numberBetween(8, 9) . fake()->numberBetween(1000000, 9999999),
            'phone_number_verified_at' => fake()->boolean() ? fake()->dateTimeBetween($date, 'now') : null,
            'picture' => fake()->boolean() ? fake()->imageUrl(500, 500) : null,
            'password' => static::$password,
            'created_at' => $date,
            'updated_at' => $date
        ];
    }
}
