<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::factory()    
            ->count(3)
            ->has(Category::factory()->count(2), 'children')
            ->create();

        Product::factory()->count(10)->create();

        Customer::factory()->count(5)->has(Order::factory()->count(2)->has(OrderItem::factory()->count(3), 'items'), 'orders')->create();
    }
}
