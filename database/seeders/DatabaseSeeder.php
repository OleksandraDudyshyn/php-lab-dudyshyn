<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ActiveSubstance;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Prescription;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory()->count(5)->create();
        $manufacturers = Manufacturer::factory()->count(5)->create();
        $substances = ActiveSubstance::factory()->count(10)->create();

        $categories = Category::factory()->count(5)->create();
        $medicines = collect();

        foreach ($categories as $category) {
            $batch = Medicine::factory()
                ->count(6)
                ->for($category)
                ->for($manufacturers->random())
                ->hasAttached($substances->random(2), ['concentration' => '500 мг'])
                ->create();

            $medicines = $medicines->merge($batch);
        }

        foreach ($users->take(3) as $user) {
            $order = Order::factory()->for($user)->create();
            $selected = $medicines->random(2);
            $total = 0.0;

            foreach ($selected as $med) {
                $qty = rand(1, 3);
                $order->medicines()->attach($med->id, [
                    'quantity' => $qty,
                    'unit_price' => $med->price,
                ]);
                $total += $med->price * $qty;
            }

            $order->update(['total_amount' => round($total, 2)]);
            Payment::factory()->for($order)->create(['amount' => round($total, 2)]);
            Prescription::factory()->for($user)->for($medicines->first())->create();
        }
    }
}
