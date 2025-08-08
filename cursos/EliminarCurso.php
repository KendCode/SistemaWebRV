<?php
include("../config/db.php");
session_start();
$conn = db_connect();

$id = $_GET['id'];
$sql = "DELETE FROM cursos WHERE id = $id";
mysqli_query($conn, $sql);

header("Location: ListCursos.php");
exit();
?>
