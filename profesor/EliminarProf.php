<?php
include("../config/db.php");
session_start();

$conn = db_connect();

$id_profesor = $_GET['id'] ?? null;

if (!$id_profesor) {
    die("ID de profesor no proporcionado.");
}

// 1. Obtener el ID del usuario asociado al profesor
$query = "SELECT usuario_id FROM profesores WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_profesor);
$stmt->execute();
$result = $stmt->get_result();
$profesor = $result->fetch_assoc();

if (!$profesor) {
    die("Profesor no encontrado.");
}

$usuario_id = $profesor['usuario_id'];

// 2. Eliminar primero al profesor
$query_del_prof = "DELETE FROM profesores WHERE id = ?";
$stmt_del_prof = $conn->prepare($query_del_prof);
$stmt_del_prof->bind_param("i", $id_profesor);
$stmt_del_prof->execute();

// 3. Luego eliminar al usuario
$query_del_user = "DELETE FROM usuarios WHERE id = ?";
$stmt_del_user = $conn->prepare($query_del_user);
$stmt_del_user->bind_param("i", $usuario_id);
$stmt_del_user->execute();

// 4. Redireccionar de vuelta a la lista
header("Location: ListProf.php?eliminado=1");
exit;
?>
