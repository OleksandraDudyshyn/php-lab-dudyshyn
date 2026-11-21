<?php

declare(strict_types=1);

namespace App\Core;

use Exception;

class Database
{
    private static ?self $instance = null;

    private function __construct()
    {
        echo '<p>Підключення до БД створено</p>';
    }

    private function __clone() {}

    public function __wakeup(): void
    {
        throw new Exception('Десеріалізація Singleton заборонена!');
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }
}
