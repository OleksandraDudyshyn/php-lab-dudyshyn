<?php

namespace Database\Factories;

use App\Models\ActiveSubstance;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ActiveSubstance>
 */
class ActiveSubstanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->word().' '.fake()->lexify('???');

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'atc_code' => fake()->unique()->regexify('[A-Z][0-9]{2}[A-Z]{2}[0-9]{2}'),
        ];
    }
}
