<?php
include("../config/db.php");
session_start();

$conn = db_connect();

echo "<h4 class='mt-3'>Bienvenido usuario: " . $_SESSION['nombre'] . "</h4>";

$id_usuario = $_SESSION['id_usuario'] ?? null;

if (!$id_usuario) {
    echo "<div class='alert alert-danger'>No se encontró el ID de usuario en sesión.</div>";
    exit;
}

// Obtener el ID del estudiante
$query_estudiante = "SELECT id FROM estudiantes WHERE usuario_id = $id_usuario";
$resultado = mysqli_query($conn, $query_estudiante);
$estudiante = mysqli_fetch_assoc($resultado);

if (!$estudiante) {
    echo "<div class='alert alert-warning'>No se encontró el estudiante para este usuario.</div>";
    exit;
}

$id_estudiante = $estudiante['id'];

// Consulta de calificaciones
$consulta = "SELECT 
    m.nombre AS materia,
    cal.trimestre1,
    cal.trimestre2,
    cal.trimestre3,
    cal.nota_final
FROM calificaciones cal
JOIN asignaciones_docente ad ON cal.asignacion_id = ad.id
JOIN materias m ON ad.materia_id = m.id
WHERE cal.estudiante_id = $id_estudiante";

$resp = mysqli_query($conn, $consulta);

// Mostrar resultados en tabla
if ($resp && mysqli_num_rows($resp) > 0): ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <div class="container mt-4">
        <h3 class="mb-4">Tabla de Calificaciones</h3>
        <table class="table table-striped table-bordered">
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
                <?php while ($fila = mysqli_fetch_assoc($resp)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($fila['materia']); ?></td>
                        <td><?php echo $fila['trimestre1']; ?></td>
                        <td><?php echo $fila['trimestre2']; ?></td>
                        <td><?php echo $fila['trimestre3']; ?></td>
                        <td><strong><?php echo $fila['nota_final']; ?></strong></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php
else:
    echo "<div class='alert alert-info'>No se encontraron calificaciones.</div>";
endif;
?>
