<?php
include("../config/db.php");
$conn = db_connect();

$ci = $_POST['ci'];
$contrasena = $_POST['contrasena'];

// Consulta al usuario por CI
$consulta = "SELECT * FROM usuarios WHERE ci = ?";
$stmt = $conn->prepare($consulta);
$stmt->bind_param("s", $ci);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $resp = $resultado->fetch_assoc();

    // ✅ Verificar contraseña encriptada
    if (password_verify($contrasena, $resp['contrasena'])) {
        session_start();
        $_SESSION['nombre'] = $resp['nombre'];
        $_SESSION['ci'] = $resp['ci'];
        $_SESSION['rol'] = $resp['rol'];
        $_SESSION['id_usuario'] = $resp['id'];

        // Redirigir según el rol
        switch ($resp['rol']) {
            case 'estudiante':
                header("Location: ../estudiante/dashboard.php");
                break;
            case 'profesor':
                header("Location: ../profesor/dashboard.php");
                break;
            case 'secretaria':
                header("Location: ../secretaria/dashboard.php");
                break;
            case 'directora':
                header("Location: ../directora/dashboard.php");
                break;
            default:
                echo "<script>alert('Rol no válido'); window.location='../index.php';</script>";
        }
        exit;
    } else {
        // Contraseña incorrecta
        echo "<script>alert('Contraseña incorrecta'); window.location='../index.php';</script>";
    }
} else {
    // Usuario no encontrado
    echo "<script>alert('CI no registrado'); window.location='../index.php';</script>";
}
?>
