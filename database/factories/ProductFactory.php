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
    public function definition()
    {
        $categories = ['boots', 'sandals', 'sneakers'];
        return [
            'name' => $this->faker->sentence(),
            'category' => $categories[array_rand($categories)],
            'price' => $this->faker->randomNumber(5)
        ];
    }
}
