<?php
include("../config/db.php");


// Conectar a la base de datos
$conn = db_connect();

$ci=$_POST['ci'];
$contrasena=$_POST['contrasena'];
$rol=$_POST['rol'];
//echo "el ci es:".$ci;
//echo "<br> su contraseña es: ".$contrasena;


// primer paso guardar la consulta
$consulta="SELECT * FROM usuarios WHERE ci='$ci'";
// segundo paso mostrar la consulta
// mysqli_query (agregamos la variable de la conexion, la consulta que queremos trabajar)
$resultado= mysqli_query($conn,$consulta);

// tercer paso 
// mostrar lo recuperado de la base de datos en el ejercicio
// mysqli_fetch_assoc(varibale dela conexion y la consulta);
$resp= mysqli_fetch_assoc($resultado);

//echo "el ci del usuario usuario es: ".$resp['ci'];

//echo "<br>el nombre del usuario usuario es: ".$resp['nombre'];
//echo "<br>el rol del usuario usuario es: ".$resp['rol'];

if($ci==$resp['ci'] && $contrasena==$resp['contrasena'])
{
    session_start();
    $_SESSION['nombre'] = $resp['nombre'];
    $_SESSION['ci'] = $resp['ci'];
    $_SESSION['rol'] = $resp['rol'];
    $_SESSION['id_usuario'] = $resp['id'];

    // Redirección según rol
    if ($resp['rol'] == 'estudiante') {
        header("Location: ../estudiante/dashboard.php");
        exit;
    } elseif ($resp['rol'] == 'profesor') {
        header("Location: ../profesor/dashboard.php");
        exit;
    } elseif ($resp['rol'] == 'secretaria') {
        header("Location: ../secretaria/dashboard.php");
        exit;
    } elseif ($resp['rol'] == 'directora') {
        header("Location: ../directora/dashboard.php");
        exit;
    } else {
        echo "<script>alert('Rol no válido'); window.location='../index.php';</script>";
    }
} else {
    echo "<script>alert('CI o contraseña incorrectos'); window.location='../index.php';</script>";
}
?>