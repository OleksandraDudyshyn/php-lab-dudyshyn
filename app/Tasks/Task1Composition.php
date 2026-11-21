<?php

declare(strict_types=1);

namespace App\Tasks;

// Завдання 1 (Табл. 4.2, №2): Композиція класів Student та Group для додавання, видалення та пошуку студентів у групі.
class Student
{
    public function __construct(
        public int $id,
        public string $name,
        public string $surname,
        public string $birthday
    ) {}

    public function getFullInfo(): string
    {
        return "#{$this->id} {$this->surname} {$this->name} (дата нар.: {$this->birthday})";
    }
}

class Group
{
    public function __construct(
        public int $groupId,
        public string $name,
        private array $students = []
    ) {}

    public function addStudent(Student $student): void
    {
        $this->students[$student->id] = $student;
    }

    public function removeStudent(int $id): bool
    {
        if (isset($this->students[$id])) {
            unset($this->students[$id]);

            return true;
        }

        return false;
    }

    public function searchStudent(string $query): array
    {
        $results = [];
        $needle = mb_strtolower($query);

        foreach ($this->students as $student) {
            $fullName = mb_strtolower("{$student->name} {$student->surname}");
            if (str_contains($fullName, $needle)) {
                $results[] = $student;
            }
        }

        return $results;
    }

    public function getStudents(): array
    {
        return array_values($this->students);
    }
}
