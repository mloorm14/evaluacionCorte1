<?php
declare(strict_types=1);

namespace App\Services;

use App\Repository\MateriaRepository;
use InvalidArgumentException;

class MateriaService {
    private MateriaRepository $repository;

    public function __construct(MateriaRepository $repository) {
        $this->repository = $repository;
    }

    public function obtenerTodas(): array {
        return $this->repository->findAllActive();
    }

    public function obtenerPorId(int $id): ?array {
        return $this->repository->findById($id);
    }

    public function crearMateria(string $codigo, string $nombre, int $creditos, int $semestre): array {
        $errores = $this->validarCampos($codigo, $nombre, $creditos, $semestre);

        if (empty($errores)) {
            $existente = $this->repository->findByCodigo($codigo);
            if ($existente) {
                $errores[] = "El código de la materia ya se encuentra registrado.";
            } else {
                $this->repository->insert($codigo, $nombre, $creditos, $semestre);
            }
        }

        return $errores;
    }

    public function actualizarMateria(int $id, string $codigo, string $nombre, int $creditos, int $semestre): array {
        $errores = $this->validarCampos($codigo, $nombre, $creditos, $semestre);

        if (empty($errores)) {
            $existente = $this->repository->findByCodigo($codigo);
            if ($existente && (int)$existente['id'] !== $id) {
                $errores[] = "El código ya pertenece a otra materia registrada.";
            } else {
                $this->repository->update($id, $codigo, $nombre, $creditos, $semestre);
            }
        }

        return $errores;
    }

    public function eliminarMateriaLogica(int $id): bool {
        return $this->repository->softDelete($id);
    }

    private function validarCampos(string $codigo, string $nombre, int $creditos, int $semestre): array {
        $errores = [];

        if (strlen($codigo) !== 6) {
            $errores[] = "El código debe tener exactamente 6 caracteres alfanuméricos.";
        }
        if (strlen($nombre) < 5 || strlen($nombre) > 80) {
            $errores[] = "El nombre de la materia debe tener entre 5 y 80 caracteres de longitud.";
        }
        if ($creditos < 1 || $creditos > 6) {
            $errores[] = "El número de créditos debe estar comprendido estrictamente en el rango de 1 a 6.";
        }
        if ($semestre < 1 || $semestre > 10) {
            $errores[] = "El semestre académico debe estar comprendido estrictamente en el rango de 1 a 10.";
        }

        return $errores;
    }
}
