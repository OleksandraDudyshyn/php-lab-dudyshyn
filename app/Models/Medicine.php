<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'manufacturer_id',
        'name',
        'dosage',
        'price',
        'stock_quantity',
        'is_prescription',
    ];

    protected $casts = [
        'price' => 'float',
        'stock_quantity' => 'integer',
        'is_prescription' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function activeSubstances(): BelongsToMany
    {
        return $this->belongsToMany(ActiveSubstance::class)
            ->withPivot('concentration')
            ->withTimestamps();
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_items')
            ->withPivot(['quantity', 'unit_price'])
            ->withTimestamps();
    }

    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class);
    }
}
