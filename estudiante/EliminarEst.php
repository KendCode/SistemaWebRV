<?php
include("../config/db.php");
session_start();
$conn = db_connect();

// Validar que id llegue y sea un número
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido");
}

$id = (int) $_GET['id'];

// Buscar estudiante
$result = mysqli_query($conn, "SELECT * FROM estudiantes WHERE id = $id");
if (!$result || mysqli_num_rows($result) === 0) {
    die("Estudiante no encontrado");
}

$est = mysqli_fetch_assoc($result);

// Eliminar estudiante
mysqli_query($conn, "DELETE FROM estudiantes WHERE id = $id");

// Eliminar usuario vinculado
if (isset($est['usuario_id']) && is_numeric($est['usuario_id'])) {
    mysqli_query($conn, "DELETE FROM usuarios WHERE id = {$est['usuario_id']}");
}

header("Location: ListaEst.php");
exit();
?>
