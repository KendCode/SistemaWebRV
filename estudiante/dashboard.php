<?php
include("../config/db.php");
session_start();

$conn = db_connect();

$id_estudiante = $_SESSION['id_usuario']; // Cambia esto si el ID está en otra variable

// Consulta para obtener usuarios con rol 'profesor'
$consulta = "SELECT 
    u.nombre AS nombre_profesor, 
    u.apellido AS apellido_profesor, 
    p.especialidad, 
    a.curso_id, 
    c.grado, 
    c.paralelo
FROM 
    usuarios u
JOIN 
    profesores p ON u.id = p.usuario_id
JOIN 
    asignaciones_docente a ON p.id = a.profesor_id
JOIN 
    cursos c ON a.curso_id = c.id
WHERE 
    u.rol = 'profesor' 
    AND a.curso_id IN (
        SELECT 
            e.curso_id
        FROM 
            estudiantes e
        WHERE 
            e.usuario_id = $id_estudiante)";

$resp = mysqli_query($conn, $consulta);

$profesores = [];
if ($resp) {
    while ($fila = mysqli_fetch_assoc($resp)) {
        $profesores[] = $fila;
    }
} else {
    $error = "Error en la consulta: " . mysqli_error($conn);
}

// Consulta de calificaciones del estudiante
$sqlNotas = "
SELECT 
    m.nombre AS materia,
    c.trimestre1,
    c.trimestre2,
    c.trimestre3,
    c.nota_final
FROM calificaciones c
JOIN asignaciones_docente a ON c.asignacion_id = a.id
JOIN materias m ON a.materia_id = m.id
WHERE c.estudiante_id = $id_estudiante
";

$resultadoNotas = mysqli_query($conn, $sqlNotas);
$calificaciones = [];

if ($resultadoNotas) {
    while ($fila = mysqli_fetch_assoc($resultadoNotas)) {
        $calificaciones[] = $fila;
    }
} else {
    $errorNotas = "Error al obtener calificaciones: " . mysqli_error($conn);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">

    <title>Dashboard Estudiante</title>
</head>

<body>
    <div class="container mt-5">
        <h1>Bienvenido, <?php echo $_SESSION['nombre']; ?></h1>
        <p>CI: <?php echo isset($_SESSION['ci']) ? $_SESSION['ci'] : 'CI no disponible'; ?></p>
        <p>ID de usuario: <?php echo isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : 'No disponible'; ?></p>

        <!-- Botón que abre el modal -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCalificaciones">
            <i class="bi bi-book"></i> Ver Calificaciones
        </button>

        <!-- Modal -->
        <div class="modal fade" id="modalCalificaciones" tabindex="-1" aria-labelledby="modalCalificacionesLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCalificacionesLabel">Calificaciones</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <?php if (!empty($calificaciones)): ?>
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Materia</th>
                                        <th>Trimestre 1</th>
                                        <th>Trimestre 2</th>
                                        <th>Trimestre 3</th>
                                        <th>Nota Final</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($calificaciones as $nota): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($nota['materia']) ?></td>
                                            <td><?= $nota['trimestre1'] ?? '-' ?></td>
                                            <td><?= $nota['trimestre2'] ?? '-' ?></td>
                                            <td><?= $nota['trimestre3'] ?? '-' ?></td>
                                            <td><strong><?= $nota['nota_final'] ?? '-' ?></strong></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="alert alert-info">No hay calificaciones registradas aún.</div>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>


        <h2>Profesores Asignados</h2>
        <div class="list-group">
            <?php if (!empty($profesores)): ?>
                <?php foreach ($profesores as $fila): ?>
                    <a href="#" class="list-group-item list-group-item-action">
                        Profesor: <?php echo $fila['nombre_profesor'] . " " . $fila['apellido_profesor'] . " - Grado: " . $fila['grado'] . " - Paralelo: " . $fila['paralelo']; ?>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-warning" role="alert">
                    <?php echo isset($error) ? $error : 'No hay profesores asignados.'; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>