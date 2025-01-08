<?php
// Conexión a la base de datos
$serverName = "localhost";
$database = "ProyectoSalasITCH";
$username_db = "sa";
$password_db = "0103";

try {
    $pdo = new PDO("sqlsrv:server=$serverName;Database=$database", $username_db, $password_db);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}

// Consulta para obtener los estados
$sql = "SELECT IDEstado, Descripcion FROM EstadoSala";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$estados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Devuelve los datos en formato JSON
echo json_encode($estados);
?>