<?php

declare(strict_types=1);

namespace App\Core;

use App\Models\AbstractEntity;
use App\Models\Medicine;
use App\Models\User;
use InvalidArgumentException;

class EntityFactory
{
    public static function createEntity(string $type, array $data): AbstractEntity
    {
        return match ($type) {
            'medicine' => new Medicine(
                (string) $data['id'],
                (string) $data['createdAt'],
                (string) $data['name'],
                (string) $data['activeSubstance'],
                (float) $data['price'],
                (int) $data['stockQuantity']
            ),
            'user' => new User(
                (string) $data['id'],
                (string) $data['createdAt'],
                (string) $data['name'],
                (string) $data['email'],
                (string) $data['role']
            ),
            default => throw new InvalidArgumentException("Невідомий тип сутності: {$type}"),
        };
    }
}
