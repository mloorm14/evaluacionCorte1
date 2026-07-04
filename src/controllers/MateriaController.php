<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Services\MateriaService;
use App\Helpers\Security;

class MateriaController {
    private MateriaService $service;

    public function __construct(MateriaService $service) {
        $this->service = $service;
    }

    public function listar(): void {
        $materias = $this->service->obtenerTodas();
        require __DIR__ . '/../views/listado.php';
    }

    public function formularioNueva(?array $errores = null, ?array $valores = null): void {
        $csrf_token = Security::generateCsrfToken();
        require __DIR__ . '/../views/nueva.php';
    }

    public function crear(): void {
        $token = filter_input(INPUT_POST, 'csrf_token', FILTER_DEFAULT);
        if (!Security::verifyCsrfToken($token)) {
            http_response_code(400);
            $this->formularioNueva(["Token CSRF no válido para la operación."]);
            return;
        }

        $codigo = trim((string)filter_input(INPUT_POST, 'codigo', FILTER_DEFAULT));
        $nombre = trim((string)filter_input(INPUT_POST, 'nombre', FILTER_DEFAULT));
        $creditos = filter_input(INPUT_POST, 'creditos', FILTER_VALIDATE_INT);
        $semestre = filter_input(INPUT_POST, 'semestre', FILTER_VALIDATE_INT);

        if ($creditos === false || $semestre === false || $creditos === null || $semestre === null) {
            http_response_code(422);
            $this->formularioNueva(["Créditos y Semestre deben ser valores numéricos enteros."], $_POST);
            return;
        }

        $errores = $this->service->crearMateria($codigo, $nombre, $creditos, $semestre);

        if (!empty($errores)) {
            http_response_code(422);
            $this->formularioNueva($errores, $_POST);
            return;
        }

        http_response_code(302);
        header('Location: /materias');
    }

    public function formularioEditar(int $id, ?array $errores = null): void {
        $materia = $this->service->obtenerPorId($id);
        if (!$materia) {
            http_response_code(404);
            echo "Materia no encontrada";
            return;
        }
        $csrf_token = Security::generateCsrfToken();
        require __DIR__ . '/../views/editar.php';
    }

    public function actualizar(int $id): void {
        $token = filter_input(INPUT_POST, 'csrf_token', FILTER_DEFAULT);
        if (!Security::verifyCsrfToken($token)) {
            http_response_code(400);
            $this->formularioEditar($id, ["Token CSRF no válido para la operación."]);
            return;
        }

        $codigo = trim((string)filter_input(INPUT_POST, 'codigo', FILTER_DEFAULT));
        $nombre = trim((string)filter_input(INPUT_POST, 'nombre', FILTER_DEFAULT));
        $creditos = filter_input(INPUT_POST, 'creditos', FILTER_VALIDATE_INT);
        $semestre = filter_input(INPUT_POST, 'semestre', FILTER_VALIDATE_INT);

        if ($creditos === false || $semestre === false || $creditos === null || $semestre === null) {
            http_response_code(422);
            $this->formularioEditar($id, ["Créditos y Semestre deben contener datos enteros válidos."]);
            return;
        }

        $errores = $this->service->actualizarMateria($id, $codigo, $nombre, $creditos, $semestre);

        if (!empty($errores)) {
            http_response_code(422);
            $this->formularioEditar($id, $errores);
            return;
        }

        http_response_code(302);
        header('Location: /materias');
    }

    public function eliminarLogica(int $id): void {
        $token = filter_input(INPUT_POST, 'csrf_token', FILTER_DEFAULT);
        if (!Security::verifyCsrfToken($token)) {
            http_response_code(400);
            header('Location: /materias?error=csrf');
            return;
        }

        $this->service->eliminarMateriaLogica($id);
        http_response_code(302);
        header('Location: /materias');
    }
}
