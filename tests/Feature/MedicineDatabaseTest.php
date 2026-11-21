<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\ActiveSubstance;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Medicine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MedicineDatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_fetch_medicines_with_relations(): void
    {
        $category = Category::factory()->create(['name' => 'Антибіотики']);
        $manufacturer = Manufacturer::factory()->create(['name' => 'Дарниця']);
        $substance = ActiveSubstance::factory()->create(['name' => 'Амоксицилін']);

        $medicine = Medicine::factory()
            ->for($category)
            ->for($manufacturer)
            ->create(['name' => 'Амоксиклав 625']);

        $medicine->activeSubstances()->attach($substance->id);

        $response = $this->getJson('/medicines');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Амоксиклав 625'])
            ->assertJsonFragment(['name' => 'Антибіотики'])
            ->assertJsonFragment(['name' => 'Дарниця'])
            ->assertJsonFragment(['name' => 'Амоксицилін']);
    }

    public function test_can_create_medicine_with_relations_in_database(): void
    {
        $category = Category::factory()->create();
        $manufacturer = Manufacturer::factory()->create();
        $substances = ActiveSubstance::factory()->count(2)->create();

        $payload = [
            'category_id' => $category->id,
            'manufacturer_id' => $manufacturer->id,
            'name' => 'Цефтріаксон',
            'dosage' => '1000 мг',
            'price' => 185.50,
            'stock_quantity' => 30,
            'is_prescription' => true,
            'active_substances' => $substances->pluck('id')->toArray(),
        ];

        $response = $this->withHeaders(['X-Doctor-License' => 'DOC-UA-2026-016'])
            ->postJson('/medicines', $payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('medicines', [
            'name' => 'Цефтріаксон',
            'category_id' => $category->id,
            'manufacturer_id' => $manufacturer->id,
        ]);

        $medicineId = $response->json('data.id');
        foreach ($substances as $substance) {
            $this->assertDatabaseHas('active_substance_medicine', [
                'medicine_id' => $medicineId,
                'active_substance_id' => $substance->id,
            ]);
        }
    }
}
