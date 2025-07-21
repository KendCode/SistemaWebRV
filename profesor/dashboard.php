<?php
include("../config/db.php");
session_start();

$conn = db_connect();

$profesor_id = $_SESSION['id_usuario']; // Cambia esto si el ID del profesor está en otra variable

// Consulta para obtener grado, paralelo y materias del profesor
$consulta = "SELECT
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
    <title>Dashboard Profesor</title>
</head>

<body>
    <div class="container mt-5">
        <h1>Bienvenido, <?php echo $_SESSION['nombre']; ?></h1>

        <h2>Clases Asignadas</h2>
        <div class="list-group">
            <?php if (!empty($clases)): ?>
                <?php foreach ($clases as $fila): ?>
                    <a href="grado.php?grado=<?php echo urlencode($fila['grado']); ?>&paralelo=<?php echo $fila['paralelo']; ?>" class="list-group-item list-group-item-action">
                        Grado: <?php echo $fila['grado']; ?> - Paralelo: <?php echo $fila['paralelo']; ?> - Materia: <?php echo $fila['materia']; ?>
                    </a>
                <?php endforeach; ?>

            <?php else: ?>
                <div class="alert alert-warning" role="alert">
                    <?php echo isset($error) ? $error : 'No tienes clases asignadas.'; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>