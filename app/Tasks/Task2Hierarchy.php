<?php

declare(strict_types=1);

namespace App\Tasks;

// Завдання 2 (Табл. 4.3, №5): Ієрархія Випробування -> Тест -> Іспит -> Випускний іспит зі зростаючим прохідним балом через parent::.
abstract class Trial
{
    public function __construct(protected string $title) {}

    public function getTitle(): string
    {
        return $this->title;
    }

    abstract public function getPassingScore(): int;
}

class Test extends Trial
{
    public function getPassingScore(): int
    {
        return 60;
    }
}

class Exam extends Test
{
    public function getPassingScore(): int
    {
        return parent::getPassingScore() + 15;
    }
}

class FinalExam extends Exam
{
    public function getPassingScore(): int
    {
        return parent::getPassingScore() + 10;
    }
}
