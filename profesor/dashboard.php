<?php
include("../config/db.php");
session_start();
$conn = db_connect();

// Obtener el ID de usuario (no es el ID de profesor directamente)
$usuario_id = $_SESSION['id_usuario'];

// Obtener el ID del profesor desde la tabla profesores
$sql = "SELECT id FROM profesores WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$profesor = $result->fetch_assoc();

if (!$profesor) {
    die("No se encontró al profesor.");
}

$profesor_id = $profesor['id']; // Ahora sí es el ID de la tabla 'profesores'

// Obtener los cursos y materias asignadas
$consulta = "SELECT
    c.id AS curso_id,
    c.grado,
    c.paralelo,
    m.nombre AS materia
FROM asignaciones_docente ad
JOIN cursos c ON ad.curso_id = c.id
JOIN materias m ON ad.materia_id = m.id
WHERE ad.profesor_id = ?";

$stmt = $conn->prepare($consulta);
$stmt->bind_param("i", $profesor_id);
$stmt->execute();
$result = $stmt->get_result();

$clases = [];
if ($result) {
    while ($fila = $result->fetch_assoc()) {
        $clases[] = $fila;
    }
} else {
    $error = "Error en la consulta: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Profesor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Bienvenido, <?= htmlspecialchars($_SESSION['nombre']) ?></h1>

    <h4 class="mb-3">Cursos y Materias Asignadas</h4>

    <?php if (!empty($clases)): ?>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Grado</th>
                    <th>Paralelo</th>
                    <th>Materia</th>
                    <th>Estudiantes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clases as $clase): ?>
                    <tr>
                        <td><?= htmlspecialchars($clase['grado']) ?></td>
                        <td><?= htmlspecialchars($clase['paralelo']) ?></td>
                        <td><?= htmlspecialchars($clase['materia']) ?></td>
                        <td>
                            <a href="ver_estudiantes.php?curso_id=<?= $clase['curso_id'] ?>" class="btn btn-primary btn-sm">
                                Ver Estudiantes
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">No tienes cursos asignados.</div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
