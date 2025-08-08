<?php
include("../config/db.php");
session_start();
$conn = db_connect();

$id = $_GET['id'];
$est = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM estudiantes WHERE id = $id"));
$usuario = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM usuarios WHERE id = {$est['usuario_id']}"));
$cursos = mysqli_query($conn, "SELECT * FROM cursos");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $ci = $_POST['ci'];
    $genero = $_POST['genero'];
    $curso_id = $_POST['curso_id'];

    mysqli_query($conn, "UPDATE usuarios SET nombre='$nombre', apellido='$apellido', ci='$ci' WHERE id = {$est['usuario_id']}");
    mysqli_query($conn, "UPDATE estudiantes SET genero='$genero', curso_id=$curso_id WHERE id = $id");

    header("Location: ListaEst.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Estudiante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Editar Estudiante</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Nombre:</label>
            <input type="text" name="nombre" class="form-control" value="<?= $usuario['nombre'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Apellido:</label>
            <input type="text" name="apellido" class="form-control" value="<?= $usuario['apellido'] ?>" required>
        </div>
        <div class="mb-3">
            <label>CI:</label>
            <input type="text" name="ci" class="form-control" value="<?= $usuario['ci'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Género:</label>
            <select name="genero" class="form-select">
                <option value="M" <?= $est['genero'] == 'M' ? 'selected' : '' ?>>Masculino</option>
                <option value="F" <?= $est['genero'] == 'F' ? 'selected' : '' ?>>Femenino</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Curso:</label>
            <select name="curso_id" class="form-select">
                <?php while ($curso = mysqli_fetch_assoc($cursos)) {
                    $selected = $curso['id'] == $est['curso_id'] ? 'selected' : '';
                    echo "<option value='{$curso['id']}' $selected>{$curso['grado']} \"{$curso['paralelo']}\"</option>";
                } ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="ListaEst.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
