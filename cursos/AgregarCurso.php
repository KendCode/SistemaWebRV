<?php
include("../config/db.php");
session_start();
$conn = db_connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $grado = $_POST['grado'];
    $paralelo = $_POST['paralelo'];
    $nivel = $_POST['nivel'];

    $sql = "INSERT INTO cursos (grado, paralelo, nivel) VALUES ('$grado', '$paralelo', '$nivel')";
    mysqli_query($conn, $sql);
    header("Location: ListCursos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Agregar Curso</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Grado</label>
            <select name="grado" class="form-select" required>
                <option>Primero</option>
                <option>Segundo</option>
                <option>Tercero</option>
                <option>Cuarto</option>
                <option>Quinto</option>
                <option>Sexto</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Paralelo</label>
            <select name="paralelo" class="form-select" required>
                <option>A</option>
                <option>B</option>
                <option>C</option>
                <option>D</option>
                <option>E</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Nivel</label>
            <input type="text" name="nivel" class="form-control" value="Secundaria" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="ListCursos.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
