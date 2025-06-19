<?php
include("../config/db.php");
session_start();

$conn = db_connect();

echo "Bienvenido usuario: " . $_SESSION['nombre'] . "<br>";

if (isset($_SESSION['ci'])) {
    echo "CI: " . $_SESSION['ci'] . "<br>";
} else {
    echo "CI no disponible<br>";
}

if (isset($_SESSION['id_usuario'])) {
    echo "ID de usuario: " . $_SESSION['id_usuario'] . "<br>";
}

// Suponiendo que el ID del estudiante está en la sesión
$id_estudiante = $_SESSION['id_usuario']; // Cambia esto si el ID está en otra variable

// Consulta para obtener usuarios con rol 'profesor'
$consulta = "SELECT 
    u.nombre AS nombre_profesor, 
    u.apellido AS apellido_profesor, 
    p.especialidad, 
    a.curso_id, 
    c.grado, 
    c.paralelo
FROM 
    usuarios u
JOIN 
    profesores p ON u.id = p.usuario_id
JOIN 
    asignaciones_docente a ON p.id = a.profesor_id
JOIN 
    cursos c ON a.curso_id = c.id
WHERE 
    u.rol = 'profesor' 
    AND a.curso_id IN (
        SELECT 
            e.curso_id
        FROM 
            estudiantes e
        WHERE 
            e.usuario_id = $id_estudiante)"; // Usar la variable aquí

$resp = mysqli_query($conn, $consulta);

// Mostrar resultados
if ($resp) {
    while ($fila = mysqli_fetch_assoc($resp)) {
        echo "<br>Profesor: " . $fila['nombre_profesor'] . " " . $fila['apellido_profesor'] . " - Grado: " . $fila['grado'] . " - Paralelo: " . $fila['paralelo'];
    }
} else {
    echo "<br>Error en la consulta: " . mysqli_error($conn);
}
?>