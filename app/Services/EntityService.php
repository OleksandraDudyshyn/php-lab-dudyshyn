<?php

declare(strict_types=1);

namespace App\Services;

use Exception;

class EntityService
{
    public function calculateOrderTotal(float $price, int $quantity): float
    {
        return round($price * $quantity, 2);
    }

    public function applyDiscount(float $price, float $discount): float
    {
        if ($discount < 0 || $discount > 100) {
            throw new Exception('Неприпустиме значення знижки!');
        }

        return round($price - ($price * ($discount / 100)), 2);
    }
}
