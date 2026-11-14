<?php

declare(strict_types=1);

namespace App\Services;

class DataProcessor
{
    /**
     * Таблиця 3.2 (Задача 5): Індекси елементів, які більші за свого правого сусіда, та їх кількість.
     */
    public function findGreaterThanRightNeighbor(array $numbers): array
    {
        $indices = [];
        $count = count($numbers);

        for ($i = 0; $i < $count - 1; $i++) {
            if ($numbers[$i] > $numbers[$i + 1]) {
                $indices[] = $i;
            }
        }

        return [
            'indices' => $indices,
            'count' => count($indices),
        ];
    }

    /**
     * Таблиця 3.3 (Задача 7): Слова тексту, де перша буква одного слова співпадає з останньою буквою наступного.
     */
    public function findMatchingBoundaryWords(string $text): array
    {
        $words = preg_split('/\s+/u', trim($text)) ?: [];
        $matched = [];
        $total = count($words);

        for ($i = 0; $i < $total - 1; $i++) {
            $firstCharCurrent = mb_strtolower(mb_substr($words[$i], 0, 1));
            $lastCharNext = mb_strtolower(mb_substr($words[$i + 1], -1, 1));

            if ($firstCharCurrent === $lastCharNext) {
                $matched[] = "{$words[$i]} -> {$words[$i + 1]}";
            }
        }

        return $matched;
    }

    /**
     * Таблиця 3.4 (Задача 4): Перемішати символи у кожному слові рядка, крім першого і останнього слів.
     */
    public function shuffleMiddleWordsCharacters(string $sentence): string
    {
        $words = explode(' ', trim($sentence));
        $total = count($words);

        for ($i = 1; $i < $total - 1; $i++) {
            $chars = preg_split('//u', $words[$i], -1, PREG_SPLIT_NO_EMPTY) ?: [];
            shuffle($chars);
            $words[$i] = implode('', $chars);
        }

        return implode(' ', $words);
    }
}
        return implode(' ', $words);
    }
}
