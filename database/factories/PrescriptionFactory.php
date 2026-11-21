<?php

namespace Database\Factories;

use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Prescription>
 */
class PrescriptionFactory extends Factory
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
            'medicine_id' => Medicine::factory(),
            'prescription_code' => fake()->unique()->regexify('RX-[0-9]{4}-[0-9]{4}'),
            'doctor_name' => 'Др. '.fake()->name(),
            'issue_date' => now()->subDays(2)->toDateString(),
            'expiry_date' => now()->addDays(28)->toDateString(),
            'status' => 'active',
        ];
    }
}
