<?php
$serverName = "localhost";
$database = "ProyectoSalasITCH";
$username = "sa";
$password = "0103";

try {
    $pdo = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexion Exitosa";
} catch (PDOException $e) {
    echo "Error en la conexión: " . $e->getMessage();
}
// Consulta para obtener los docentes 
$sql = "SELECT IDDocente, Nombres, PrimerApellido, SegundoApellido FROM Docente"; 
$stmt = $pdo->prepare($sql); 
$stmt->execute(); 
$docentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>