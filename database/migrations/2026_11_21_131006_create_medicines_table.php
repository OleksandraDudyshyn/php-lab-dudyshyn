<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('manufacturer_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('dosage', 100);
            $table->decimal('price', 10, 2);
            $table->unsignedInteger('stock_quantity')->default(0);
            $table->boolean('is_prescription')->default(false);
            $table->timestamps();

            $table->index(['is_prescription', 'price']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
