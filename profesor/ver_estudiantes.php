<?php
include("../config/db.php");
session_start();

$conn = db_connect();

if (!isset($_GET['curso_id']) || !is_numeric($_GET['curso_id'])) {
    die("Curso no válido.");
}

$curso_id = intval($_GET['curso_id']);

// Obtener información del curso
$sqlCurso = "SELECT grado, paralelo, nivel FROM cursos WHERE id = ?";
$stmtCurso = $conn->prepare($sqlCurso);
$stmtCurso->bind_param("i", $curso_id);
$stmtCurso->execute();
$resultCurso = $stmtCurso->get_result();
$curso = $resultCurso->fetch_assoc();

if (!$curso) {
    die("Curso no encontrado.");
}

// Obtener estudiantes y sus calificaciones si existen
$sqlEst = "SELECT e.id AS estudiante_id, u.nombre, u.apellido, u.ci,
                  c.trimestre1, c.trimestre2, c.trimestre3, c.nota_final
           FROM estudiantes e
           JOIN usuarios u ON e.usuario_id = u.id
           LEFT JOIN calificaciones c 
                ON e.id = c.estudiante_id
                AND c.asignacion_id IN (
                    SELECT id FROM asignaciones_docente 
                    WHERE curso_id = ? 
                    AND profesor_id = (
                        SELECT id FROM profesores WHERE usuario_id = ?
                    )
                )
           WHERE e.curso_id = ?";
$stmtEst = $conn->prepare($sqlEst);
$stmtEst->bind_param("iii", $curso_id, $_SESSION['id_usuario'], $curso_id);
$stmtEst->execute();
$resultEst = $stmtEst->get_result();
$estudiantes = $resultEst->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estudiantes del Curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">
        Estudiantes del Curso: <?= htmlspecialchars($curso['grado'] . ' "' . $curso['paralelo'] . '" - ' . $curso['nivel']) ?>
    </h2>

    <?php if (!empty($estudiantes)): ?>
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>CI</th>
                    <th>Trimestre 1</th>
                    <th>Trimestre 2</th>
                    <th>Trimestre 3</th>
                    <th>Nota Final</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estudiantes as $e): ?>
                    <tr>
                        <td><?= $e['estudiante_id'] ?></td>
                        <td><?= htmlspecialchars($e['nombre']) ?></td>
                        <td><?= htmlspecialchars($e['apellido']) ?></td>
                        <td><?= htmlspecialchars($e['ci']) ?></td>
                        <td><?= $e['trimestre1'] ?? '-' ?></td>
                        <td><?= $e['trimestre2'] ?? '-' ?></td>
                        <td><?= $e['trimestre3'] ?? '-' ?></td>
                        <td><?= $e['nota_final'] ?? '-' ?></td>
                        <td>
                            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modal<?= $e['estudiante_id'] ?>">
                                Calificar
                            </button>
                        </td>
                    </tr>

                    <!-- Modal de Calificación -->
                    <div class="modal fade" id="modal<?= $e['estudiante_id'] ?>" tabindex="-1" aria-labelledby="modalLabel<?= $e['estudiante_id'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST" action="guardar_calificacion.php">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            Calificar a <?= htmlspecialchars($e['nombre'] . " " . $e['apellido']) ?>
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="estudiante_id" value="<?= $e['estudiante_id'] ?>">
                                        <input type="hidden" name="curso_id" value="<?= $curso_id ?>">

                                        <div class="mb-3">
                                            <label class="form-label">Trimestre 1:</label>
                                            <input type="number" class="form-control" name="trimestre1" min="0" max="100" value="<?= $e['trimestre1'] ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Trimestre 2:</label>
                                            <input type="number" class="form-control" name="trimestre2" min="0" max="100" value="<?= $e['trimestre2'] ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Trimestre 3:</label>
                                            <input type="number" class="form-control" name="trimestre3" min="0" max="100" value="<?= $e['trimestre3'] ?>">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">No hay estudiantes en este curso.</div>
    <?php endif; ?>

    <a href="dashboard.php" class="btn btn-secondary mt-3">← Volver</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
