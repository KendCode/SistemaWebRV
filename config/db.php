<?php
// config/db.php

function db_connect() {
    // Datos de conexión
    $usuario ="root";

    $contrasena ="";

    $bd_datos="sistema_escolar";

    $servidor ="localhost";

    // Crear conexión
    $conn = mysqli_connect("$servidor", "$usuario", "$contrasena", "$bd_datos") or die ("no se conecto a la base de datos, contactese con soporte tecnico");

    // Verificar conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Opcional: establecer charset para evitar problemas con acentos y caracteres
    $conn->set_charset("utf8mb4");

    return $conn;
}
?>