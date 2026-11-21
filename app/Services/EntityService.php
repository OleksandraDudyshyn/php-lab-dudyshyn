<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\LoggerInterface;
use App\Models\AbstractEntity;
use Exception;

class EntityService
{
    public function __construct(private LoggerInterface $logger) {}

    public function processEntity(AbstractEntity $entity): string
    {
        $details = $entity->getDetails();
        $this->logger->log("Оброблено сутність: {$details}");

        return $details;
    }

    public function calculateOrderTotal(float $price, int $quantity): float
    {
        $total = round($price * $quantity, 2);
        $this->logger->log("Розраховано суму замовлення: {$total} грн ({$quantity} шт. по {$price} грн)");

        return $total;
    }

    public function applyDiscount(float $price, float $discount): float
    {
        if ($discount < 0 || $discount > 100) {
            $this->logger->log("Помилка знижки: передано {$discount}%");
            throw new Exception('Неприпустиме значення знижки!');
        }

        $result = round($price - ($price * ($discount / 100)), 2);
        $this->logger->log("Застосовано знижку {$discount}% до {$price} грн -> {$result} грн");

        return $result;
    }
}
