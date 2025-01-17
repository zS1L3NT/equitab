<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::query()->create([
            'name' => 'Food',
            'picture' => fake()->imageUrl(500, 500, 'food'),
        ]);

        Category::query()->create([
            'name' => 'Transport',
            'picture' => fake()->imageUrl(500, 500, 'transport'),
        ]);

        Category::query()->create([
            'name' => 'Accomodation',
            'picture' => fake()->imageUrl(500, 500, 'accomodation'),
        ]);
    }
}
