<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class MedicineAccessTest extends TestCase
{
    public function test_get_medicines_returns_ok_status(): void
    {
        $response = $this->getJson('/medicines');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
            ]);
    }

    public function test_show_nonexistent_medicine_returns_404(): void
    {
        $response = $this->getJson('/medicines/999');

        $response->assertStatus(404)
            ->assertJson([
                'status' => 'error',
            ]);
    }

    public function test_prescription_medicine_without_license_header_is_blocked_by_middleware(): void
    {
        $response = $this->postJson('/medicines', [
            'name' => 'Цефтріаксон',
            'active_substance' => 'Цефтріаксон',
            'dosage' => '1000 мг',
            'price' => 185.50,
            'is_prescription' => true,
        ]);

        $response->assertStatus(403)
            ->assertJson([
                'status' => 'access_denied',
            ]);
    }

    public function test_prescription_medicine_with_valid_license_header_passes_middleware(): void
    {
        $response = $this->withHeaders([
            'X-Doctor-License' => 'DOC-UA-2026-016',
        ])->postJson('/medicines', [
            'name' => 'Цефтріаксон',
            'active_substance' => 'Цефтріаксон',
            'dosage' => '1000 мг',
            'price' => 185.50,
            'is_prescription' => true,
        ]);

        $response->assertStatus(201)
            ->assertHeader('X-Security-Policy', 'Enforced');
    }
}
