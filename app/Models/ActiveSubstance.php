<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ActiveSubstance extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'atc_code'];

    public function medicines(): BelongsToMany
    {
        return $this->belongsToMany(Medicine::class)
            ->withPivot('concentration')
            ->withTimestamps();
    }
}
