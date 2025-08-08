<?php
include("../config/db.php");
session_start();

$conn = db_connect();

// Validar ID de curso
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("<div class='container mt-5 alert alert-warning'>Curso no especificado.</div>");
}

$curso_id = intval($_GET['id']);

// Obtener datos del curso
$sqlCurso = "SELECT * FROM cursos WHERE id = ?";
$stmtCurso = $conn->prepare($sqlCurso);
$stmtCurso->bind_param("i", $curso_id);
$stmtCurso->execute();
$resultCurso = $stmtCurso->get_result();
$curso = $resultCurso->fetch_assoc();

if (!$curso) {
    die("<div class='container mt-5 alert alert-danger'>Curso no encontrado.</div>");
}

$sqlEstudiantes = "
    SELECT e.id, u.nombre, u.apellido, u.ci
    FROM estudiantes e
    JOIN usuarios u ON u.id = e.usuario_id
    WHERE e.curso_id = ?
";

$stmtEst = $conn->prepare($sqlEstudiantes);
$stmtEst->bind_param("i", $curso_id);
$stmtEst->execute();
$resultEst = $stmtEst->get_result();
$estudiantes = $resultEst->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Curso <?= htmlspecialchars($curso['grado'] . " " . $curso['paralelo']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">

    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="card-title">Curso: <?= htmlspecialchars($curso['grado']) . " \"" . htmlspecialchars($curso['paralelo']) . "\"" ?></h2>
            <p class="card-text mb-1"><strong>ID del Curso:</strong> <?= $curso['id'] ?></p>
            <p class="card-text"><strong>Nivel:</strong> <?= htmlspecialchars($curso['nivel']) ?></p>
        </div>
    </div>

    <div class="mt-4">
        <h4>Estudiantes Inscritos</h4>

        <?php if (count($estudiantes) > 0): ?>
            <table class="table table-bordered table-striped mt-3">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>CI</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($estudiantes as $est): ?>
            <tr>
                <td><?= $est['id'] ?></td>
                <td><?= htmlspecialchars($est['nombre']) ?></td>
                <td><?= htmlspecialchars($est['apellido']) ?></td>
                <td><?= htmlspecialchars($est['ci']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

        <?php else: ?>
            <div class="alert alert-info mt-3">No hay estudiantes registrados en este curso.</div>
        <?php endif; ?>
    </div>

    <a href="ListCursos.php" class="btn btn-secondary mt-4">← Volver a la lista de cursos</a>
</div>
</body>
</html>
