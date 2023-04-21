<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Goods;
use App\Models\Order;
use Database\Factories\OrderGoodsFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Goods::factory(1000)->create();
        Order::factory(1000)->create();
        OrderGoodsFactory::new()->count(1000)->create();
    }
}
