<?php
declare(strict_types=1);
use App\Helpers\Security;
require __DIR__ . '/layout/header.php';
?>
<h2>Registrar Asignatura Curricular</h2>

<?php if (!empty($errores)): ?>
    <div class="alert">
        <ul>
            <?php foreach ($errores as $error): ?>
                <li><?= Security::escape($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="/materias" method="POST">
    <input type="hidden" name="csrf_token" value="<?= Security::escape($csrf_token) ?>">
    
    <div class="form-group">
        <label for="codigo">Código de la Materia (Exactamente 6 caracteres, ej: APW501)</label>
        <input type="text" id="codigo" name="codigo" required minlength="6" maxlength="6" pattern="[A-Z0-9]{6}" value="<?= Security::escape($valores['codigo'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label for="nombre">Nombre de la Asignatura (De 5 a 80 caracteres)</label>
        <input type="text" id="nombre" name="nombre" required minlength="5" maxlength="80" value="<?= Security::escape($valores['nombre'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label for="creditos">Número de Créditos Académicos (Rango 1 a 6)</label>
        <input type="number" id="creditos" name="creditos" required min="1" max="6" value="<?= Security::escape((string)($valores['creditos'] ?? '')) ?>">
    </div>

    <div class="form-group">
        <label for="semestre">Semestre Académico Correlativo (Rango 1 a 10)</label>
        <input type="number" id="semestre" name="semestre" required min="1" max="10" value="<?= Security::escape((string)($valores['semestre'] ?? '')) ?>">
    </div>

    <button type="submit" class="btn">Guardar Materia</button>
    <a href="/materias" class="btn btn-secondary">Cancelar</a>
</form>
</body>
</html>
