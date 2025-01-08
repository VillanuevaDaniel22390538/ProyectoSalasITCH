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

// Obtener el ID del docente o el ID del usuario desde la URL
$idDocente = isset($_GET['idDocente']) ? $_GET['idDocente'] : null;
$idUsuario = isset($_GET['idUsuario']) ? $_GET['idUsuario'] : null;

if ($idDocente) {
    // Consulta para obtener los datos personales del docente por ID de docente
    $sql = "SELECT d.*, u.NombreUsuario, u.emailUsuario, u.TipoDeUsuarioId FROM Docente d JOIN Usuarios u ON d.idUsuario = u.idUsuario WHERE d.IDDocente = :idDocente";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['idDocente' => $idDocente]);
} elseif ($idUsuario) {
    // Consulta para obtener los datos personales del docente por ID de usuario
    $sql = "SELECT d.*, u.NombreUsuario, u.emailUsuario, u.TipoDeUsuarioId FROM Docente d JOIN Usuarios u ON d.idUsuario = u.idUsuario WHERE u.idUsuario = :idUsuario";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['idUsuario' => $idUsuario]);
}

$datosPersonales = $stmt->fetch(PDO::FETCH_ASSOC);

// Devolver los datos en formato JSON
echo json_encode($datosPersonales);
?>
