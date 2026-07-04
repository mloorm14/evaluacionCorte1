<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Repository\UsuarioRepository;
use App\Helpers\Security;

class AuthController {
    private UsuarioRepository $repository;

    public function __construct(UsuarioRepository $repository) {
        $this->repository = $repository;
    }

    public function showLogin(?string $error = null): void {
        $csrf_token = Security::generateCsrfToken();
        require __DIR__ . '/../views/login.php';
    }

    public function login(): void {
        $token = filter_input(INPUT_POST, 'csrf_token', FILTER_DEFAULT);
        if (!Security::verifyCsrfToken($token)) {
            http_response_code(400);
            $this->showLogin("Fallo de seguridad: Token CSRF ausente o inválido.");
            return;
        }

        $username = filter_input(INPUT_POST, 'username', FILTER_DEFAULT);
        $password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);

        if (empty($username) || empty($password)) {
            http_response_code(422);
            $this->showLogin("Debe proporcionar obligatoriamente todos los campos.");
            return;
        }

        $usuario = $this->repository->findByUsername($username);

        if ($usuario && password_verify($password, $usuario['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['usuario'] = [
                'id' => $usuario['id'],
                'username' => $usuario['username'],
                'rol' => $usuario['rol']
            ];
            http_response_code(302);
            header('Location: /materias');
            return;
        }

        http_response_code(400);
        $this->showLogin("Las credenciales de acceso ingresadas son incorrectas.");
    }

    public function logout(): void {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        http_response_code(302);
        header('Location: /login');
    }
}
