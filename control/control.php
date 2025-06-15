<?php
include("../config/db.php");


// Conectar a la base de datos
$conn = db_connect();

$ci=$_POST['ci'];
$contrasena=$_POST['contrasena'];
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
echo "usuario tipo estudiante";
//creamos la sesion
//session_start();
//$_SESSION["va el nombre de la sesion"]=$usuario;
//$_SESSION['admin']=$usuario;
//$_SESSION['nombre']=$resp['nombre'];
//$_SESSION['contrasena']=$contrasena;
//echo '<script>window.location="../administracion.php"</script>';
}//else{
//	echo "usuario incocorrecto";
    //echo "<script>alert('usuario o contraseña incorrecta')</script>";
   //echo '<script>window.location="../loggin.php"</script>';
    
//}

?>