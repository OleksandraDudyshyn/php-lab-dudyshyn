<?php

declare(strict_types=1);

require_once __DIR__.'/vendor/autoload.php';

use App\Models\EntityArray;
use App\Services\DataProcessor;
use App\Services\EntityService;
use Faker\Factory;

$service = new EntityService;
$processor = new DataProcessor;
$faker = Factory::create();

echo '<h1>Лабораторна робота №3 — Варіант 16 (Електронна аптека)</h1>';

// Завдання 1
echo EntityArray::renderHtml();

// Завдання 2
$totalPrice = $service->calculateOrderTotal(345.50, 3);
echo '<h3>3. Користувацька функція зі строгою типізацією:</h3>';
echo "<p>Вартість 3 упаковок по 345.50 грн: <strong>{$totalPrice} грн</strong></p>";

// Завдання 3
$generatedPrices = [];
for ($i = 0; $i < 10; $i++) {
    $generatedPrices[] = $faker->randomFloat(2, 100, 1200);
}

$minThreshold = 500.0;
$expensiveMedicines = array_filter(
    $generatedPrices,
    function (float $price) use ($minThreshold): bool {
        return $price > $minThreshold;
    }
);

echo '<h3>4. Генерація цін (Faker) та фільтрація анонімною функцією (use):</h3>';
echo '<p>Усі згенеровані ціни (10 шт.): '.implode(' грн, ', $generatedPrices).' грн</p>';
echo "<p>Препарати дорожчі за {$minThreshold} грн: <strong>".implode(' грн, ', $expensiveMedicines).' грн</strong></p>';

// Завдання 4
echo '<h3>5. Обробка винятків (try-catch-finally):</h3>';
try {
    echo '<p>Спроба застосувати знижку 150% до суми 1000 грн...</p>';
    $discounted = $service->applyDiscount(1000.0, 150.0);
    echo "<p>Ціна зі знижкою: {$discounted} грн</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'><strong>Помилка:</strong> {$e->getMessage()}</p>";
} finally {
    echo '<p><em>Завершення спроби розрахунку.</em></p>';
}

// Завдання 5 (Варіант 16)
echo '<h3>6. Індивідуальне алгоритмічне завдання (Варіант 16):</h3>';

$arrayInput = [15, 8, 22, 19, 5, 12, 4];
$task1Result = $processor->findGreaterThanRightNeighbor($arrayInput);
echo '<p><strong>Задача 3.2 (№5):</strong> Масив: ['.implode(', ', $arrayInput).']<br>';
echo 'Індекси елементів більших за правого сусіда: '.implode(', ', $task1Result['indices'])." (Кількість: {$task1Result['count']})</p>";

$textInput = 'аптека аналіз сироп парацетамол ліки рецепт';
$task2Result = $processor->findMatchingBoundaryWords($textInput);
echo "<p><strong>Задача 3.3 (№7):</strong> Текст: «{$textInput}»<br>";
echo 'Пари слів (перша літера = остання літера наступного): '.implode('; ', $task2Result).'</p>';

$sentenceInput = 'Електронна система продажу ліків працює цілодобово';
$task3Result = $processor->shuffleMiddleWordsCharacters($sentenceInput);
echo "<p><strong>Задача 3.4 (№4):</strong> Вихідний рядок: «{$sentenceInput}»<br>";
echo "Результат перемішування середніх слів: «{$task3Result}»</p>";
