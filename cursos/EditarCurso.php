<?php
include("../config/db.php");
session_start();
$conn = db_connect();

$id = $_GET['id'];
$curso = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM cursos WHERE id = $id"));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $grado = $_POST['grado'];
    $paralelo = $_POST['paralelo'];
    $nivel = $_POST['nivel'];

    $sql = "UPDATE cursos SET grado='$grado', paralelo='$paralelo', nivel='$nivel' WHERE id=$id";
    mysqli_query($conn, $sql);
    header("Location: ListCursos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Editar Curso</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Grado</label>
            <select name="grado" class="form-select" required>
                <?php
                $grados = ['Primero', 'Segundo', 'Tercero', 'Cuarto', 'Quinto', 'Sexto'];
                foreach ($grados as $g) {
                    echo "<option value='$g'" . ($curso['grado'] == $g ? ' selected' : '') . ">$g</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Paralelo</label>
            <select name="paralelo" class="form-select" required>
                <?php
                $paralelos = ['A', 'B', 'C', 'D', 'E'];
                foreach ($paralelos as $p) {
                    echo "<option value='$p'" . ($curso['paralelo'] == $p ? ' selected' : '') . ">$p</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Nivel</label>
            <input type="text" name="nivel" class="form-control" value="<?= $curso['nivel'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="ListCursos.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
