<?php

declare(strict_types=1);

namespace App\Models;

class EntityArray
{
    public static function getCategories(): array
    {
        $categories = [
            'Вітаміни та мінерали',
            'Антибіотики',
            'Знеболювальні засоби',
            'Противірусні препарати',
            'Антисептики',
        ];

        sort($categories);

        return $categories;
    }

    public static function getMedicineItem(): array
    {
        return [
            'id' => 101,
            'name' => 'Амоксиклав 625 мг',
            'activeSubstance' => 'Амоксицилін + Клавуланова кислота',
            'price' => 345.50,
            'stockQuantity' => 42,
            'requiresPrescription' => 'Так (е-Рецепт)',
        ];
    }

    public static function renderHtml(): string
    {
        $categories = self::getCategories();
        $medicine = self::getMedicineItem();

        $html = '<h3>1. Відсортований індексний масив категорій аптеки:</h3><ul>';
        foreach ($categories as $category) {
            $html .= "<li>{$category}</li>";
        }
        $html .= '</ul>';

        $html .= '<h3>2. Асоціативний масив об’єкта класу Medicine:</h3><ul>';
        foreach ($medicine as $key => $value) {
            $html .= "<li><strong>{$key}:</strong> {$value}</li>";
        }
        $html .= '</ul>';

        return $html;
    }
}
