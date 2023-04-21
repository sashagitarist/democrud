<?php

namespace Database\Factories;

use App\Models\OrderGoods;
use App\Models\Order;
use App\Models\Goods;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderGoodsFactory extends Factory
{
    protected $model = OrderGoods::class;

    public function definition()
    {
        return [
            'order_id' => \App\Models\Order::inRandomOrder()->first()->id,
            'goods_id' => \App\Models\Goods::inRandomOrder()->first()->id,
            'quantity' => $this->faker->numberBetween(1, 10),
        ];
    }
}
