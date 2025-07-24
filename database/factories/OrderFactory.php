<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\Customer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'status' => $this->faker->randomElement(['pending', 'shipped', 'delivered', 'cancelled']),
            'total_price' => $this->faker->randomFloat(2, 5, 1000),
        ];
    }
}
