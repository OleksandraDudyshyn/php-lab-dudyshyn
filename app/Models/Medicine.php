<?php

declare(strict_types=1);

namespace App\Models;

use App\Interfaces\ExportableInterface;
use App\Traits\JsonExportTrait;

class Medicine extends AbstractEntity implements ExportableInterface
{
    use JsonExportTrait;

    public function __construct(
        string $id,
        string $createdAt,
        protected string $name,
        protected string $activeSubstance,
        protected float $price,
        protected int $stockQuantity
    ) {
        parent::__construct($id, $createdAt);
    }

    public function getDetails(): string
    {
        return "Препарат #{$this->id}: {$this->name} ({$this->activeSubstance}), ціна: {$this->price} грн, залишок: {$this->stockQuantity} шт. (додано {$this->createdAt})";
    }
}
