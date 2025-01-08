<?php
$serverName = "localhost";
$database = "ProyectoSalasITCH";
$username = "sa";
$password = "0103";

try {
    $pdo = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Conexion Exitosa"; // Puedes descomentar esta línea para verificar la conexión
} catch (PDOException $e) {
    echo "Error en la conexión: " . $e->getMessage();
}
?>
