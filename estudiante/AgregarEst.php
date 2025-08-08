<?php
include("../config/db.php");
session_start();
$conn = db_connect();

// Obtener cursos para el select
$cursos = mysqli_query($conn, "SELECT * FROM cursos");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $ci = $_POST['ci'];
    $password_raw = $_POST['contrasena'];
    $genero = $_POST['genero'];
    $curso_id = $_POST['curso_id'];

    // Encriptar contraseña
    $contrasena = password_hash($password_raw, PASSWORD_DEFAULT);

    // Insertar en tabla usuarios
    $sqlUsuario = "INSERT INTO usuarios (nombre, apellido, ci, contrasena, rol) 
                   VALUES ('$nombre', '$apellido', '$ci', '$contrasena', 'estudiante')";
    mysqli_query($conn, $sqlUsuario);
    $usuario_id = mysqli_insert_id($conn);

    // Insertar en tabla estudiantes
    $sqlEstudiante = "INSERT INTO estudiantes (usuario_id, genero, curso_id) 
                      VALUES ($usuario_id, '$genero', $curso_id)";
    mysqli_query($conn, $sqlEstudiante);

    header("Location: ListaEst.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Estudiante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Agregar Estudiante</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Nombre:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Apellido:</label>
            <input type="text" name="apellido" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>CI:</label>
            <input type="text" name="ci" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Contraseña:</label>
            <input type="password" name="contrasena" class="form-control" required minlength="4">
        </div>
        <div class="mb-3">
            <label>Género:</label>
            <select name="genero" class="form-select" required>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Curso:</label>
            <select name="curso_id" class="form-select" required>
                <?php while ($curso = mysqli_fetch_assoc($cursos)) {
                    echo "<option value='{$curso['id']}'>{$curso['grado']} \"{$curso['paralelo']}\"</option>";
                } ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="ListaEst.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
