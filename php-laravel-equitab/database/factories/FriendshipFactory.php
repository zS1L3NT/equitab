<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Friendship>
 */
class FriendshipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = fake()->dateTimeBetween('-1 years', 'now');

        return [
            'from_user_id' => User::factory(),
            'to_user_id' => User::factory(),
            'accepted' => fake()->boolean(),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
