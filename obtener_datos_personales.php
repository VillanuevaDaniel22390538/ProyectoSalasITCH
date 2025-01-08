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

// Obtener el ID del usuario desde la URL
$idUsuario = $_GET['idUsuario'];

// Consulta para obtener los datos personales del usuario
$sql = "SELECT * FROM Usuarios WHERE idUsuario = :idUsuario";
$stmt = $pdo->prepare($sql);
$stmt->execute(['idUsuario' => $idUsuario]);
$datosPersonales = $stmt->fetch(PDO::FETCH_ASSOC);

// Devolver los datos en formato JSON
echo json_encode($datosPersonales);
?>
