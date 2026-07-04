<?php
declare(strict_types=1);

namespace App\Repository;

use PDO;

class UsuarioRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function findByUsername(string $username): ?array {
        $stmt = $this->db->prepare("SELECT id, username, password_hash, rol FROM usuarios WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();
        return $user ?: null;
    }
}
