<?php
declare(strict_types=1);

namespace App\Repository;

use PDO;

class MateriaRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function findAllActive(): array {
        $stmt = $this->db->prepare("SELECT id, codigo, nombre, creditos, semestre, activa FROM materias WHERE activa = TRUE ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT id, codigo, nombre, creditos, semestre, activa FROM materias WHERE id = :id AND activa = TRUE LIMIT 1");
        $stmt->execute(['id' => $id]);
        $materia = $stmt->fetch();
        return $materia ?: null;
    }

    public function findByCodigo(string $codigo): ?array {
        $stmt = $this->db->prepare("SELECT id, codigo, nombre, creditos, semestre, activa FROM materias WHERE codigo = :codigo LIMIT 1");
        $stmt->execute(['codigo' => $codigo]);
        $materia = $stmt->fetch();
        return $materia ?: null;
    }

    public function insert(string $codigo, string $nombre, int $creditos, int $semestre): bool {
        $stmt = $this->db->prepare("INSERT INTO materias (codigo, nombre, creditos, semestre, activa) VALUES (:codigo, :nombre, :creditos, :semestre, TRUE)");
        return $stmt->execute([
            'codigo' => $codigo,
            'nombre' => $nombre,
            'creditos' => $creditos,
            'semestre' => $semestre
        ]);
    }

    public function update(int $id, string $codigo, string $nombre, int $creditos, int $semestre): bool {
        $stmt = $this->db->prepare("UPDATE materias SET codigo = :codigo, nombre = :nombre, creditos = :creditos, semestre = :semestre WHERE id = :id AND activa = TRUE");
        return $stmt->execute([
            'id' => $id,
            'codigo' => $codigo,
            'nombre' => $nombre,
            'creditos' => $creditos,
            'semestre' => $semestre
        ]);
    }

    public function softDelete(int $id): bool {
        $stmt = $this->db->prepare("UPDATE materias SET activa = FALSE WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
