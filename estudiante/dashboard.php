<?php
include("../config/db.php");
session_start();

$conn = db_connect();
// Mostrar nombre del usuario
echo "Bienvenido usuario: " . $_SESSION['nombre'];

// Verificar si 'ci' está definido
if (isset($_SESSION['ci'])) {
    echo "<br>con CI: " . $_SESSION['ci'];
} else {
    echo "<br>CI no disponible en la sesión.";
}

// Consulta para obtener usuarios con rol 'profesor'
$consulta = "SELECT u.*, p.especialidad, a.curso_id, c.grado, c.paralelo
FROM usuarios u
JOIN profesores p ON u.id = p.usuario_id
JOIN asignaciones_docente a ON p.id = a.profesor_id
JOIN cursos c ON a.curso_id = c.id
WHERE u.rol = 'profesor'";
$resp = mysqli_query($conn, $consulta);

// Mostrar resultados
if ($resp) {
    while ($fila = mysqli_fetch_assoc($resp)) {
        echo "<br>Profesor: " . $fila['nombre'] . " " . $fila['apellido']." ". $fila['grado'];
    }
} else {
    echo "<br>Error en la consulta: " . mysqli_error($conn);
}
?>
