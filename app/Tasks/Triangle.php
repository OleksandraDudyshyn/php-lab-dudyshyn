<?php

declare(strict_types=1);

namespace App\Tasks;

use InvalidArgumentException;

// Завдання 3 (Табл. 4.4, №2): Клас Triangle із незмінюваними readonly-сторонами та обчисленням периметра і площі за формулою Герона.
class Triangle
{
    public function __construct(
        public readonly float $a,
        public readonly float $b,
        public readonly float $c
    ) {
        if ($a <= 0 || $b <= 0 || $c <= 0) {
            throw new InvalidArgumentException('Сторони трикутника повинні бути додатними числами!');
        }

        if ($a + $b <= $c || $a + $c <= $b || $b + $c <= $a) {
            throw new InvalidArgumentException('Трикутник із такими сторонами не існує!');
        }
    }

    public function getPerimeter(): float
    {
        return round($this->a + $this->b + $this->c, 2);
    }

    public function getArea(): float
    {
        $halfPerimeter = $this->getPerimeter() / 2;
        $area = sqrt(
            $halfPerimeter
            * ($halfPerimeter - $this->a)
            * ($halfPerimeter - $this->b)
            * ($halfPerimeter - $this->c)
        );

        return round($area, 2);
    }
}
