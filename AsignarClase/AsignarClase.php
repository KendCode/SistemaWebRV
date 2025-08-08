<?php
include("../config/db.php");
session_start();

$conn = db_connect();

$id_profesor = $_GET['id'] ?? null;
if (!$id_profesor) {
    die("ID del profesor no proporcionado.");
}

// Obtener nombre del profesor
$query_prof = "SELECT u.nombre, u.apellido FROM profesores p JOIN usuarios u ON u.id = p.usuario_id WHERE p.id = ?";
$stmt_prof = $conn->prepare($query_prof);
$stmt_prof->bind_param("i", $id_profesor);
$stmt_prof->execute();
$res_prof = $stmt_prof->get_result();
$profesor = $res_prof->fetch_assoc();

if (!$profesor) {
    die("Profesor no encontrado.");
}

// Obtener cursos disponibles
$cursos = mysqli_query($conn, "SELECT id, grado, paralelo FROM cursos");

// Obtener materias disponibles
$materias = mysqli_query($conn, "SELECT id, nombre FROM materias");

$mensaje = "";

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $curso_id = $_POST['curso_id'];
    $materia_id = $_POST['materia_id'];

    // Verificar si ya existe esa asignación
    $verificar = "SELECT * FROM asignaciones_docente WHERE profesor_id = ? AND curso_id = ? AND materia_id = ?";
    $stmt_check = $conn->prepare($verificar);
    $stmt_check->bind_param("iii", $id_profesor, $curso_id, $materia_id);
    $stmt_check->execute();
    $res_check = $stmt_check->get_result();

    if ($res_check->num_rows === 0) {
        // Insertar asignación
        $insertar = "INSERT INTO asignaciones_docente (profesor_id, curso_id, materia_id) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($insertar);
        $stmt_insert->bind_param("iii", $id_profesor, $curso_id, $materia_id);
        if ($stmt_insert->execute()) {
            $mensaje = "<div class='alert alert-success'>Asignación registrada correctamente.</div>";
        } else {
            $mensaje = "<div class='alert alert-danger'>Error al asignar clase.</div>";
        }
    } else {
        $mensaje = "<div class='alert alert-warning'>Este curso y materia ya están asignados al profesor.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Clases a Profesor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <a href="../AsignarClase/ListProf.php" class="btn btn-secondary mb-3">← Volver</a>
    <h3>Asignar Clases a: <?php echo $profesor['nombre'] . ' ' . $profesor['apellido']; ?></h3>

    <?php echo $mensaje; ?>

    <form method="POST" class="row g-3 mt-3">
        <div class="col-md-6">
            <label for="curso_id" class="form-label">Curso</label>
            <select name="curso_id" class="form-select" required>
                <option value="" disabled selected>Selecciona un curso</option>
                <?php while ($c = mysqli_fetch_assoc($cursos)): ?>
                    <option value="<?php echo $c['id']; ?>">
                        <?php echo $c['grado'] . " " . $c['paralelo']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="materia_id" class="form-label">Materia</label>
            <select name="materia_id" class="form-select" required>
                <option value="" disabled selected>Selecciona una materia</option>
                <?php while ($m = mysqli_fetch_assoc($materias)): ?>
                    <option value="<?php echo $m['id']; ?>">
                        <?php echo $m['nombre']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Asignar Clase</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
