<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'order_number' => fake()->unique()->regexify('ORD-2026-[0-9]{4}'),
            'total_amount' => fake()->randomFloat(2, 100, 3000),
            'status' => fake()->randomElement(['pending', 'paid', 'completed']),
        ];
    }
}
