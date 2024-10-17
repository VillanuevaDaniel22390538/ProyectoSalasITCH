<?php
// Datos de conexión a la base de datos
$serverName = "localhost"; // Cambia esto si tu servidor es diferente
$connectionOptions = array(
    "Database" => "SalaComputo", // Nombre de la base de datos a la que te conectas
    "Uid" => "tu_usuario", // Tu usuario de SQL Server
    "PWD" => "tu_contraseña" // Tu contraseña de SQL Server
);

// Establecer conexión con la base de datos
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Comprobar si la conexión fue exitosa
if ($conn === false) {
    // Mostrar errores si la conexión falla
    die(print_r(sqlsrv_errors(), true)); 
}
?>
