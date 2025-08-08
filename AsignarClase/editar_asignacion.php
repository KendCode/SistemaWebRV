<?php
include("../config/db.php");
session_start();

$conn = db_connect();

$id_asignacion = $_GET['id'] ?? null;
$id_profesor = $_GET['profesor'] ?? null;

if (!$id_asignacion || !$id_profesor) {
    die("Parámetros faltantes.");
}

// Obtener asignación actual
$query = "SELECT curso_id, materia_id FROM asignaciones_docente WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_asignacion);
$stmt->execute();
$res = $stmt->get_result();
$asig = $res->fetch_assoc();
if (!$asig) die("Asignación no encontrada.");

// Listas para selects
$cursos = mysqli_query($conn, "SELECT id, grado, paralelo FROM cursos");
$materias = mysqli_query($conn, "SELECT id, nombre FROM materias");

// Todas las asignaciones del profesor
$asignaciones_prof = mysqli_query($conn, "
    SELECT ad.id, c.grado, c.paralelo, m.nombre AS materia
    FROM asignaciones_docente ad
    JOIN cursos c ON c.id = ad.curso_id
    JOIN materias m ON m.id = ad.materia_id
    WHERE ad.profesor_id = $id_profesor
");

// Procesar actualización
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nuevo_curso = $_POST["curso_id"];
    $nueva_materia = $_POST["materia_id"];

    $update = "UPDATE asignaciones_docente SET curso_id = ?, materia_id = ? WHERE id = ?";
    $stmt_up = $conn->prepare($update);
    $stmt_up->bind_param("iii", $nuevo_curso, $nueva_materia, $id_asignacion);
    $stmt_up->execute();

    header("Location: editar_asignacion.php?id=$id_asignacion&profesor=$id_profesor&actualizado=1");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Asignación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <a href="../AsignarClase/ListProf.php" class="btn btn-secondary mb-3">← Volver</a>
    <h3 class="mb-4">Asignaciones del Profesor</h3>

    <?php if (isset($_GET['actualizado'])): ?>
        <div class="alert alert-success">Asignación actualizada correctamente.</div>
    <?php endif; ?>

    <!-- Tabla de asignaciones actuales -->
    <div class="table-responsive mb-4">
        <table class="table table-bordered table-hover table-sm">
            <thead class="table-dark text-center">
                <tr>
                    <!-- <th>ID Asignación</th> -->
                    <th>Curso</th>
                    <th>Materia</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($asignaciones_prof)): ?>
                    <tr class="<?php echo $row['id'] == $id_asignacion ? 'table-warning' : ''; ?>">
                        <!-- <td class="text-center"><?php echo $row['id']; ?></td> -->
                        <td><?php echo $row['grado'] . " " . $row['paralelo']; ?></td>
                        <td><?php echo $row['materia']; ?></td>
                        <td class="text-center">
                            <a href="editar_asignacion.php?id=<?php echo $row['id']; ?>&profesor=<?php echo $id_profesor; ?>" class="btn btn-sm btn-outline-primary">
                                Editar
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Formulario de edición -->
    <h4>Editar Asignación Seleccionada</h4>
    <form method="POST" class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Curso</label>
            <select name="curso_id" class="form-select">
                <?php mysqli_data_seek($cursos, 0); ?>
                <?php while ($c = mysqli_fetch_assoc($cursos)): ?>
                    <option value="<?php echo $c['id']; ?>" <?php if ($c['id'] == $asig['curso_id']) echo 'selected'; ?>>
                        <?php echo $c['grado'] . " " . $c['paralelo']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Materia</label>
            <select name="materia_id" class="form-select">
                <?php mysqli_data_seek($materias, 0); ?>
                <?php while ($m = mysqli_fetch_assoc($materias)): ?>
                    <option value="<?php echo $m['id']; ?>" <?php if ($m['id'] == $asig['materia_id']) echo 'selected'; ?>>
                        <?php echo $m['nombre']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="asignaciones_profesor.php?id=<?php echo $id_profesor; ?>" class="btn btn-secondary">Volver</a>
        </div>
    </form>
</div>
</body>
</html>
