<?php
declare(strict_types=1);
use App\Helpers\Security;
require __DIR__ . '/layout/header.php';
?>
<div class="nav-bar">
    <div>
        <strong>Usuario autenticado:</strong> <?= Security::escape($_SESSION['usuario']['username']) ?>
    </div>
    <form action="/logout" method="POST" class="inline-form">
        <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
    </form>
</div>

<h2>Mantenimiento de Materias Académicas</h2>
<p><a href="/materias/nueva" class="btn">Registrar Nueva Materia</a></p>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Código</th>
            <th>Nombre de la Materia</th>
            <th>Créditos</th>
            <th>Semestre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($materias)): ?>
            <tr>
                <td colspan="6" style="text-align: center;">No existen materias registradas o activas en el sistema.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($materias as $materia): ?>
                <tr>
                    <td><?= Security::escape((string)$materia['id']) ?></td>
                    <td><strong><?= Security::escape($materia['codigo']) ?></strong></td>
                    <td><?= Security::escape($materia['nombre']) ?></td>
                    <td><?= Security::escape((string)$materia['creditos']) ?></td>
                    <td><?= Security::escape((string)$materia['semestre']) ?></td>
                    <td>
                        <a href="/materias/<?= Security::escape((string)$materia['id']) ?>/editar" class="btn">Editar</a>
                        <form action="/materias/<?= Security::escape((string)$materia['id']) ?>/eliminar" method="POST" class="inline-form" onsubmit="return confirm('¿Confirma la eliminación lógica de esta materia?');">
                            <input type="hidden" name="csrf_token" value="<?= Security::escape($_SESSION['csrf_token'] ?? '') ?>">
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
</body>
</html>
