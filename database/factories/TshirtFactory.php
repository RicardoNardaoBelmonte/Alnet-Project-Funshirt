<?php

namespace Database\Factories;

use App\Models\TshirtImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TshirtImage>
 */
class TshirtFactory extends Factory
{
    protected $model = TshirtImage::class;

    public function definition(): array
    {
        return [
            'customer_id' => null,
            'category_id' => null,
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'image_url' => 'https://via.placeholder.com/400',
        ];
    }
}