<?php

declare(strict_types=1);

namespace App\Models;

class User extends AbstractEntity
{
    public function __construct(
        string $id,
        string $createdAt,
        protected string $name,
        protected string $email,
        protected string $role
    ) {
        parent::__construct($id, $createdAt);
    }

    public function getDetails(): string
    {
        return "Користувач #{$this->id}: {$this->name} ({$this->email}), роль: {$this->role} (реєстрація: {$this->createdAt})";
    }
}
