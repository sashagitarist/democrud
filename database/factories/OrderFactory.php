<?php

namespace Database\Factories;

use App\Models\Goods;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $orderAmount = 0;

        // Create a random number of goods for this order
        $goods = Goods::inRandomOrder()->limit(rand(1, 5))->get();

        // Calculate the total order amount
        foreach ($goods as $good) {
            $orderAmount += $good->product_price;
        }

        return [
            'order_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->safeEmail,
            'address' => $this->faker->address,
            'location' => $this->faker->latitude . ',' . $this->faker->longitude,
            'order_amount' => $orderAmount,
        ];
    }
}
