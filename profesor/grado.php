<?php
include("../config/db.php");
session_start();

$conn = db_connect();

$grado = $_GET['grado'] ?? null;
$paralelo = $_GET['paralelo'] ?? null;

if (!$grado || !$paralelo) {
    die("Faltan parámetros: grado o paralelo.");
}

// Consulta para obtener los estudiantes del grado y paralelo seleccionados
$consulta = "SELECT 
    u.nombre, 
    u.apellido, 
    u.ci 
FROM estudiantes e
JOIN usuarios u ON u.id = e.usuario_id
JOIN cursos c ON e.curso_id = c.id
WHERE c.grado = ? AND c.paralelo = ?";

$stmt = $conn->prepare($consulta);
$stmt->bind_param("ss", $grado, $paralelo);
$stmt->execute();
$result = $stmt->get_result();

$estudiantes = [];
if ($result) {
    while ($fila = $result->fetch_assoc()) {
        $estudiantes[] = $fila;
    }
} else {
    $error = "Error en la consulta: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estudiantes de <?php echo $grado . " " . $paralelo; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Estudiantes de <?php echo $grado . " " . $paralelo; ?></h2>
        <a href="dashboard.php" class="btn btn-secondary mb-3">← Volver al Dashboard</a>

        <?php if (!empty($estudiantes)): ?>
            <ul class="list-group">
                <?php foreach ($estudiantes as $est): ?>
                    <li class="list-group-item">
                        <?php echo $est['nombre'] . " " . $est['apellido'] . " - CI: " . $est['ci']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="alert alert-warning">No se encontraron estudiantes en este curso.</div>
        <?php endif; ?>
    </div>
</body>
</html>
