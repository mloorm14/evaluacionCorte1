<?php
declare(strict_types=1);
use App\Helpers\Security;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Autenticación - Sistema de Materias</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h2 { text-align: center; color: #005a36; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .btn { width: 100%; padding: 10px; background: #005a36; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; }
        .alert { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 14px; text-align: center; }
    </style>
</head>
<body>
<div class="login-box">
    <h2>Inicio de Sesión</h2>
    <?php if (!empty($error)): ?>
        <div class="alert"><?= Security::escape($error) ?></div>
    <?php endif; ?>
    <form action="/login" method="POST">
        <input type="hidden" name="csrf_token" value="<?= Security::escape($csrf_token) ?>">
        <div class="form-group">
            <label for="username">Usuario</label>
            <input type="text" id="username" name="username" required autocomplete="off">
        </div>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn">Ingresar</button>
    </form>
</div>
</body>
</html>
