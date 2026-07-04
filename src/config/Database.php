<?php
declare(strict_types=1);

namespace App\Config;

use PDO;
use PDOException;
use RuntimeException;

class Database {
    private static ?PDO $connection = null;

    public static function getConnection(): PDO {
        if (self::$connection === null) {
            $host = getenv('DB_HOST') ?: 'db';
            $port = getenv('DB_PORT') ?: '5432';
            $dbname = getenv('DB_NAME') ?: 'academic_db';
            $user = getenv('DB_USER') ?: 'academic_admin';
            $password = getenv('DB_PASSWORD') ?: 'SecurePassword2026!';

            $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

            try {
                self::$connection = new PDO($dsn, $user, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                throw new RuntimeException("Error en la conexión a la base de datos: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}
