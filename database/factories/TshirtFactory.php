<?php

namespace Database\Factories;

use App\Models\Tshirt;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tshirt>
 */
class TshirtFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => null,
            'category' => null,
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'image_url' => 'https://via.placeholder.com/400',
            'price' => $this->faker->randomFloat(2, 15, 50),
            'sales_count' => 0,
        ];
    }
}
