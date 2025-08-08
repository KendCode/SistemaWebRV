<?php
include("../layaouts/navegacion.php");
?>
<?php
include("../config/db.php");
session_start();

$conn = db_connect();

$consulta = "
    SELECT 
        p.id AS profesor_id,
        u.nombre,
        u.apellido,
        u.ci,
        p.especialidad,
        p.celular,
        ad.id AS asignacion_id,
        c.grado,
        c.paralelo,
        m.nombre AS materia
    FROM profesores p
    JOIN usuarios u ON u.id = p.usuario_id
    LEFT JOIN asignaciones_docente ad ON ad.profesor_id = p.id
    LEFT JOIN cursos c ON c.id = ad.curso_id
    LEFT JOIN materias m ON m.id = ad.materia_id
    ORDER BY u.nombre ASC";

$resultado = mysqli_query($conn, $consulta);

$profesoresAgrupados = [];
if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $id = $fila['profesor_id'];

        if (!isset($profesoresAgrupados[$id])) {
            $profesoresAgrupados[$id] = [
                'nombre' => $fila['nombre'],
                'apellido' => $fila['apellido'],
                'ci' => $fila['ci'],
                'especialidad' => $fila['especialidad'],
                'celular' => $fila['celular'],
                'asignaciones' => []
            ];
        }

        if (!empty($fila['grado']) && !empty($fila['materia'])) {
            $profesoresAgrupados[$id]['asignaciones'][] = [
                'grado' => $fila['grado'] . " " . $fila['paralelo'],
                'materia' => $fila['materia'],
                'asignacion_id' => $fila['asignacion_id']
            ];
        }
    }
} else {
    $error = "Error al obtener los profesores: " . mysqli_error($conn);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Lista de Profesores y Asignaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-primary mb-4">Lista de Profesores y Asignaciones</h2>

        <?php if (!empty($profesoresAgrupados)): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>CI</th>
                            <th>Especialidad</th>
                            <th>Celular</th>
                            <th>Grados</th>
                            <th>Materias</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $contador = 1;
                        foreach ($profesoresAgrupados as $id => $prof):
                        ?>
                            <tr>
                                <td class="text-center"><?= $contador++ ?></td>
                                <td><?= htmlspecialchars($prof['nombre'] . " " . $prof['apellido']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($prof['ci']) ?></td>
                                <td><?= htmlspecialchars($prof['especialidad']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($prof['celular']) ?></td>
                                <td>
                                    <?php if (!empty($prof['asignaciones'])): ?>
                                        <?php foreach ($prof['asignaciones'] as $asig): ?>
                                            <span class="badge bg-info text-dark me-1"><?= htmlspecialchars($asig['grado']) ?></span>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <em class="text-muted">No asignado</em>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($prof['asignaciones'])): ?>
                                        <?php foreach ($prof['asignaciones'] as $asig): ?>
                                            <span class="badge bg-secondary text-white me-1"><?= htmlspecialchars($asig['materia']) ?></span>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <em class="text-muted">No asignado</em>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            Acciones
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="AsignarClase.php?id=<?= $id ?>"><i class="bi bi-journal-plus"></i> Asignar Clase</a></li>
                                            <?php if (!empty($prof['asignaciones'])): ?>
                                                <li><a class="dropdown-item" href="editar_asignacion.php?id=<?= $prof['asignaciones'][0]['asignacion_id'] ?>&profesor=<?= $id ?>"><i class="bi bi-pencil-square"></i> Editar</a></li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <a href="eliminar_asignacion.php?id=<?= $asig['asignacion_id'] ?>&profesor=<?= $id ?>" class="dropdown-item">
                                                    <i class="bi bi-trash"></i> Eliminar
                                                </a>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">No hay profesores registrados.</div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>