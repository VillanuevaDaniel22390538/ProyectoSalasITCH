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

// Consulta para obtener la lista de usuarios
$sql = "SELECT idUsuario, Nombres, PrimerApellido, SegundoApellido FROM Usuarios";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Devolver los datos en formato JSON
echo json_encode($usuarios);
?>