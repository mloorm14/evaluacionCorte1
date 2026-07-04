<?php
declare(strict_types=1);

require_once __DIR__ . '/helpers/Security.php';
require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/repository/UsuarioRepository.php';
require_once __DIR__ . '/repository/MateriaRepository.php';
require_once __DIR__ . '/services/MateriaService.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/MateriaController.php';

use App\Helpers\Security;
use App\Config\Database;
use App\Repository\UsuarioRepository;
use App\Repository\MateriaRepository;
use App\Services\MateriaService;
use App\Controllers\AuthController;
use App\Controllers\MateriaController;

Security::setSecurityHeaders();

$secureCookie = filter_var(getenv('SESSION_SECURE') ?: false, FILTER_VALIDATE_BOOLEAN);
session_start([
    'cookie_httponly' => true,
    'cookie_sid_length' => 48,
    'cookie_sid_bits_per_character' => 6,
    'cookie_secure' => $secureCookie,
    'cookie_samesite' => 'Strict'
]);

$db = Database::getConnection();
$usuarioRepo = new UsuarioRepository($db);
$materiaRepo = new MateriaRepository($db);
$materiaService = new MateriaService($materiaRepo);

$authController = new AuthController($usuarioRepo);
$materiaController = new MateriaController($materiaService);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if ($uri === '/' || $uri === '/login') {
    if ($method === 'GET') {
        $authController->showLogin();
        exit;
    } elseif ($method === 'POST') {
        $authController->login();
        exit;
    }
}

if ($uri === '/logout' && $method === 'POST') {
    $authController->logout();
    exit;
}

if (!isset($_SESSION['usuario'])) {
    http_response_code(302);
    header('Location: /login');
    exit;
}

if ($uri === '/materias') {
    if ($method === 'GET') {
        $materiaController->listar();
        exit;
    } elseif ($method === 'POST') {
        $materiaController->crear();
        exit;
    }
}

if ($uri === '/materias/nueva' && $method === 'GET') {
    $materiaController->formularioNueva();
    exit;
}

if (preg_match('#^/materias/(\d+)/editar$#', $uri, $matches) && $method === 'GET') {
    $materiaController->formularioEditar((int)$matches[1]);
    exit;
}

if (preg_match('#^/materias/(\d+)$#', $uri, $matches) && $method === 'POST') {
    $materiaController->actualizar((int)$matches[1]);
    exit;
}

if (preg_match('#^/materias/(\d+)/eliminar$#', $uri, $matches) && $method === 'POST') {
    $materiaController->eliminarLogica((int)$matches[1]);
    exit;
}

http_response_code(404);
echo "404 - Página no encontrada";
