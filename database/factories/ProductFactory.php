<?php

namespace Database\Factories;

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
            'name' => fake()->sentence(3),
            'img' => fake()->imageUrl(640, 480, 'games', true),
            'description' => fake()->paragraph(),
            'price' => fake()->randomElement([0.00, 199.00, 249.00, 299.00, 349.00, 449.00, 3999.00]),
            'rating' => fake()->randomFloat(2, 0, 5),
        ];
    }
}