<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Medicine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Medicine>
 */
class MedicineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'manufacturer_id' => Manufacturer::factory(),
            'name' => ucfirst(fake()->words(2, true)),
            'dosage' => fake()->randomElement(['200 мг', '400 мг', '500 мг', '625 мг', '1000 мг']),
            'price' => fake()->randomFloat(2, 45, 950),
            'stock_quantity' => fake()->numberBetween(5, 120),
            'is_prescription' => fake()->boolean(40),
        ];
    }
}
