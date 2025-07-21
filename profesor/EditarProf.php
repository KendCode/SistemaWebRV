<?php
include("../config/db.php");
session_start();

$conn = db_connect();

$id_profesor = $_GET['id'] ?? null;

if (!$id_profesor) {
    die("ID de profesor no proporcionado.");
}

// Obtener datos actuales
$query = "SELECT 
    u.id AS usuario_id,
    u.nombre, 
    u.apellido, 
    u.ci, 
    p.especialidad, 
    p.celular 
FROM profesores p
JOIN usuarios u ON u.id = p.usuario_id
WHERE p.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_profesor);
$stmt->execute();
$result = $stmt->get_result();
$profesor = $result->fetch_assoc();

if (!$profesor) {
    die("Profesor no encontrado.");
}

$mensaje = "";

// Si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $ci = $_POST["ci"];
    $especialidad = $_POST["especialidad"];
    $celular = $_POST["celular"];

    // Actualizar usuarios
    $query_u = "UPDATE usuarios SET nombre = ?, apellido = ?, ci = ? WHERE id = ?";
    $stmt_u = $conn->prepare($query_u);
    $stmt_u->bind_param("sssi", $nombre, $apellido, $ci, $profesor['usuario_id']);

    // Actualizar profesores
    $query_p = "UPDATE profesores SET especialidad = ?, celular = ? WHERE id = ?";
    $stmt_p = $conn->prepare($query_p);
    $stmt_p->bind_param("ssi", $especialidad, $celular, $id_profesor);

    if ($stmt_u->execute() && $stmt_p->execute()) {
        $mensaje = "<div class='alert alert-success'>Profesor actualizado correctamente.</div>";
        // Actualiza los datos mostrados
        $profesor['nombre'] = $nombre;
        $profesor['apellido'] = $apellido;
        $profesor['ci'] = $ci;
        $profesor['especialidad'] = $especialidad;
        $profesor['celular'] = $celular;
    } else {
        $mensaje = "<div class='alert alert-danger'>Error al actualizar los datos.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Profesor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <a href="profesores.php" class="btn btn-secondary mb-3">← Volver</a>
    <h2>Editar Profesor</h2>

    <?php echo $mensaje; ?>

    <form method="POST" class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?php echo $profesor['nombre']; ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Apellido</label>
            <input type="text" name="apellido" class="form-control" value="<?php echo $profesor['apellido']; ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">CI</label>
            <input type="text" name="ci" class="form-control" value="<?php echo $profesor['ci']; ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Especialidad</label>
            <input type="text" name="especialidad" class="form-control" value="<?php echo $profesor['especialidad']; ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Celular</label>
            <input type="text" name="celular" class="form-control" value="<?php echo $profesor['celular']; ?>" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
