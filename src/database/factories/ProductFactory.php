<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'price' => $this->faker->numberBetween(100, 10000),
            'description' => $this->faker->sentence(),
            'img_url' => $this->faker->imageUrl(640, 480, 'products', true),
            'condition' => $this->faker->randomElement(['good', 'excellent']),
            'user_id' => \App\Models\User::factory(),
            'is_sold' => false,
        ];
    }

    public function sold()
    {
        return $this->state(fn () => [
            'is_sold' => true,
        ]);
    }
}
