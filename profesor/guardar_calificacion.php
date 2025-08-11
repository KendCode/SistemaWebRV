<?php
include("../config/db.php");
session_start();

$conn = db_connect();

$estudiante_id = $_POST['estudiante_id'] ?? null;
$curso_id      = $_POST['curso_id'] ?? null;
$tr1           = $_POST['trimestre1'] ?? null;
$tr2           = $_POST['trimestre2'] ?? null;
$tr3           = $_POST['trimestre3'] ?? null;

if (!$estudiante_id || !$curso_id) {
    die("Faltan datos.");
}

// Obtener profesor_id según usuario logueado
$sqlProf = "SELECT id FROM profesores WHERE usuario_id = ?";
$stmtP = $conn->prepare($sqlProf);
$stmtP->bind_param("i", $_SESSION['id_usuario']);
$stmtP->execute();
$resP = $stmtP->get_result();
$profRow = $resP->fetch_assoc();
if (!$profRow) {
    die("Profesor no encontrado.");
}
$profesor_id = $profRow['id'];

// Obtener asignación del curso y profesor
$sqlAsignacion = "SELECT id FROM asignaciones_docente 
                  WHERE curso_id = ? AND profesor_id = ?";
$stmtA = $conn->prepare($sqlAsignacion);
$stmtA->bind_param("ii", $curso_id, $profesor_id);
$stmtA->execute();
$resA = $stmtA->get_result();
$asignacion = $resA->fetch_assoc();
if (!$asignacion) {
    die("No se encontró asignación.");
}
$asignacion_id = $asignacion['id'];

// Verificar si ya existe calificación
$sqlCheck = "SELECT id FROM calificaciones 
             WHERE estudiante_id = ? AND asignacion_id = ?";
$stmtC = $conn->prepare($sqlCheck);
$stmtC->bind_param("ii", $estudiante_id, $asignacion_id);
$stmtC->execute();
$resC = $stmtC->get_result();

if ($resC->num_rows > 0) {
    // Actualizar
    $sqlUpdate = "UPDATE calificaciones 
                  SET trimestre1 = ?, trimestre2 = ?, trimestre3 = ? 
                  WHERE estudiante_id = ? AND asignacion_id = ?";
    $stmtU = $conn->prepare($sqlUpdate);
    $stmtU->bind_param("dddii", $tr1, $tr2, $tr3, $estudiante_id, $asignacion_id);
    $stmtU->execute();
} else {
    // Insertar
    $sqlInsert = "INSERT INTO calificaciones (estudiante_id, asignacion_id, trimestre1, trimestre2, trimestre3) 
                  VALUES (?, ?, ?, ?, ?)";
    $stmtI = $conn->prepare($sqlInsert);
    $stmtI->bind_param("iiddd", $estudiante_id, $asignacion_id, $tr1, $tr2, $tr3);
    $stmtI->execute();
}

// Redirigir
header("Location: ver_estudiantes.php?curso_id=$curso_id&guardado=1");
exit;
?>
