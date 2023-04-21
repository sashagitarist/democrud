<?php

namespace Database\Factories;

use App\Models\Goods;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class GoodsFactory extends Factory
{
    protected $model = Goods::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_name' => $this->faker->sentence(2),
            'product_price' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}
