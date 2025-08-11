<?php
include("../config/db.php");
session_start();

$conn = db_connect();

$id_usuario = $_SESSION['id_usuario'] ?? null;
if (!$id_usuario) {
    die("No se encontró el usuario en la sesión.");
}

// Obtener ID del estudiante y curso
$sqlEst = "SELECT id, curso_id FROM estudiantes WHERE usuario_id = $id_usuario";
$resEst = mysqli_query($conn, $sqlEst);
$estudianteData = mysqli_fetch_assoc($resEst);

if (!$estudianteData) {
    die("No se encontró el estudiante para este usuario.");
}

$id_estudiante = $estudianteData['id'];
$curso_id = $estudianteData['curso_id'];

// Profesores asignados al curso del estudiante (con materia)
$consultaProfes = "SELECT 
    u.nombre AS nombre_profesor, 
    u.apellido AS apellido_profesor, 
    p.especialidad, 
    m.nombre AS materia
FROM usuarios u
JOIN profesores p ON u.id = p.usuario_id
JOIN asignaciones_docente a ON p.id = a.profesor_id
JOIN cursos c ON a.curso_id = c.id
JOIN materias m ON a.materia_id = m.id
WHERE u.rol = 'profesor' AND a.curso_id = $curso_id";

$resp = mysqli_query($conn, $consultaProfes);
$profesores = mysqli_fetch_all($resp, MYSQLI_ASSOC);

// Calificaciones
$consultaNotas = "SELECT 
    m.nombre AS materia,
    cal.trimestre1,
    cal.trimestre2,
    cal.trimestre3,
    cal.nota_final
FROM asignaciones_docente ad
JOIN materias m ON ad.materia_id = m.id
LEFT JOIN calificaciones cal 
    ON cal.asignacion_id = ad.id AND cal.estudiante_id = $id_estudiante
WHERE ad.curso_id = $curso_id";

$resultadoNotas = mysqli_query($conn, $consultaNotas);
$calificaciones = mysqli_fetch_all($resultadoNotas, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
    <title>Dashboard Estudiante</title>
    <style>
        .modal-header {
            background-color: #007bff; /* Color de fondo */
        }
        .modal-title {
            color: white; /* Color del texto del título */
        }
        .table th, .table td {
            text-align: center; /* Alinear texto al centro */
        }
        .table {
            margin: 0; /* Eliminar márgenes */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Bienvenido, <?php echo $_SESSION['nombre']; ?></h1>
        <p>CI: <?php echo isset($_SESSION['ci']) ? $_SESSION['ci'] : 'CI no disponible'; ?></p>

        <!-- Botón Calificaciones -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCalificaciones">
            <i class="bi bi-book"></i> Ver Calificaciones
        </button>

        <!-- Modal Calificaciones -->
        <div class="modal fade" id="modalCalificaciones" tabindex="-1" aria-labelledby="modalCalificacionesLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCalificacionesLabel">Calificaciones</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <?php if (!empty($calificaciones)): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Materia</th>
                                            <th>N1</th>
                                            <th>N2</th>
                                            <th>N3</th>
                                            <th>FINAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($calificaciones as $nota): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($nota['materia']) ?></td>
                                                <td><?= intval($nota['trimestre1']) ?></td>
                                                <td><?= intval($nota['trimestre2']) ?></td>
                                                <td><?= intval($nota['trimestre3']) ?></td>
                                                <td><strong><?= intval($nota['nota_final']) ?></strong></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">No hay calificaciones registradas aún.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Profesores -->
        <h2 class="mt-4">Profesores Asignados</h2>
        <div class="list-group">
            <?php if (!empty($profesores)): ?>
                <?php foreach ($profesores as $fila): ?>
                    <div class="list-group-item d-flex align-items-center">
                        <i class="bi bi-person-circle fs-1 me-3"></i>
                        <div>
                            <h5 class="mb-1"><?= htmlspecialchars($fila['materia']) ?></h5>
                            <small class="text-muted"><?= $fila['nombre_profesor'] . " " . $fila['apellido_profesor'] ?></small>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-warning">No hay profesores asignados.</div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>