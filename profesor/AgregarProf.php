<?php
include("../config/db.php");
session_start();

$conn = db_connect();

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $ci = $_POST["ci"];
    $contrasena = password_hash($_POST["contrasena"], PASSWORD_DEFAULT);
    $especialidad = $_POST["especialidad"];
    $celular = $_POST["celular"];

    // Insertar en usuarios
    $query_usuario = "INSERT INTO usuarios (nombre, apellido, ci, contrasena, rol) VALUES (?, ?, ?, ?, 'profesor')";
    $stmt_usuario = $conn->prepare($query_usuario);
    $stmt_usuario->bind_param("ssss", $nombre, $apellido, $ci, $contrasena);

    if ($stmt_usuario->execute()) {
        $usuario_id = $conn->insert_id;

        // Insertar en profesores
        $query_profesor = "INSERT INTO profesores (usuario_id, especialidad, celular) VALUES (?, ?, ?)";
        $stmt_profesor = $conn->prepare($query_profesor);
        $stmt_profesor->bind_param("iss", $usuario_id, $especialidad, $celular);

        if ($stmt_profesor->execute()) {
            $mensaje = "<div class='alert alert-success'>Profesor agregado correctamente.</div>";
        } else {
            $mensaje = "<div class='alert alert-danger'>Error al registrar profesor: " . $stmt_profesor->error . "</div>";
        }
    } else {
        $mensaje = "<div class='alert alert-danger'>Error al registrar usuario: " . $stmt_usuario->error . "</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Profesor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <a href="ListProf.php" class="btn btn-secondary mb-3">← Volver</a>
    <h2>Agregar Nuevo Profesor</h2>
    
    <?php echo $mensaje; ?>

    <form method="POST" class="row g-3">
        <div class="col-md-6">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" name="nombre" required>
        </div>
        <div class="col-md-6">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control" name="apellido" required>
        </div>
        <div class="col-md-6">
            <label for="ci" class="form-label">Cédula de Identidad (CI)</label>
            <input type="text" class="form-control" name="ci" required>
        </div>
        <div class="col-md-6">
            <label for="contrasena" class="form-label">Contraseña</label>
            <input type="password" class="form-control" name="contrasena" required>
        </div>
        <div class="col-md-6">
            <label for="especialidad" class="form-label">Especialidad</label>
            <input type="text" class="form-control" name="especialidad" required>
        </div>
        <div class="col-md-6">
            <label for="celular" class="form-label">Celular</label>
            <input type="text" class="form-control" name="celular" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Guardar Profesor</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
