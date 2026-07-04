<?php
declare(strict_types=1);

namespace App\Helpers;

use RuntimeException;

class Security {
    public static function setSecurityHeaders(): void {
        header("Strict-Transport-Security: max-age=31536000; includeSubDomains");
        header("X-Frame-Options: DENY");
        header("X-Content-Type-Options: nosniff");
        header("Content-Security-Policy: default-src 'self'; style-src 'self' 'unsafe-inline'; script-src 'self' 'unsafe-inline';");
    }

    public static function escape(string $data): string {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }

    public static function generateCsrfToken(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function verifyCsrfToken(?string $token): bool {
        if (empty($_SESSION['csrf_token']) || empty($token)) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }
}
