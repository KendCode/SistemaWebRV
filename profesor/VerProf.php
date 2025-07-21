<?php
include("../config/db.php");
session_start();

$conn = db_connect();

$id_profesor = $_GET['id'] ?? null;

if (!$id_profesor) {
    die("ID de profesor no proporcionado.");
}

// Obtener datos básicos del profesor
$query_profesor = "SELECT 
    u.nombre, 
    u.apellido, 
    u.ci, 
    p.especialidad, 
    p.celular 
FROM profesores p
JOIN usuarios u ON u.id = p.usuario_id
WHERE p.id = ?";

$stmt = $conn->prepare($query_profesor);
$stmt->bind_param("i", $id_profesor);
$stmt->execute();
$result = $stmt->get_result();
$profesor = $result->fetch_assoc();

if (!$profesor) {
    die("Profesor no encontrado.");
}

// Obtener asignaciones: materias y cursos del profesor
$query_asignaciones = "SELECT 
    m.nombre AS materia, 
    c.grado, 
    c.paralelo 
FROM asignaciones_docente ad
JOIN materias m ON m.id = ad.materia_id
JOIN cursos c ON c.id = ad.curso_id
WHERE ad.profesor_id = ?";

$stmt2 = $conn->prepare($query_asignaciones);
$stmt2->bind_param("i", $id_profesor);
$stmt2->execute();
$result2 = $stmt2->get_result();

$asignaciones = [];
while ($fila = $result2->fetch_assoc()) {
    $asignaciones[] = $fila;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Datos del Profesor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <a href="ListProf.php" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Volver</a>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Información del Profesor</h4>
        </div>
        <div class="card-body">
            <p><strong>Nombre:</strong> <?php echo $profesor['nombre'] . " " . $profesor['apellido']; ?></p>
            <p><strong>CI:</strong> <?php echo $profesor['ci']; ?></p>
            <p><strong>Especialidad:</strong> <?php echo $profesor['especialidad']; ?></p>
            <p><strong>Celular:</strong> <?php echo $profesor['celular']; ?></p>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header bg-success text-white">
            <h5>Materias y Cursos Asignados</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($asignaciones)): ?>
                <ul class="list-group">
                    <?php foreach ($asignaciones as $asig): ?>
                        <li class="list-group-item">
                            <strong><?php echo $asig['materia']; ?></strong> - <?php echo $asig['grado'] . " " . $asig['paralelo']; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-muted">Este profesor aún no tiene asignaciones registradas.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
