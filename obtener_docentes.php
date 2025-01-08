<?php
// Conexión a la base de datos
$serverName = "localhost"; // Nombre del servidor de la base de datos
$database = "ProyectoSalasITCH"; // Nombre de la base de datos
$username_db = "sa"; // Nombre de usuario de la base de datos
$password_db = "0103"; // Contraseña de la base de datos

try {
    // Crea una nueva conexión PDO a la base de datos
    $pdo = new PDO("sqlsrv:server=$serverName;Database=$database", $username_db, $password_db);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Establece el modo de error de PDO a excepción
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage()); // Muestra un mensaje de error si la conexión falla
}

// Consulta para obtener los docentes
$sql = "SELECT IDDocente, Nombres, PrimerApellido, SegundoApellido FROM Docente";
$stmt = $pdo->prepare($sql); // Prepara la consulta SQL
$stmt->execute(); // Ejecuta la consulta
$docentes = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtiene todos los resultados de la consulta en un array asociativo

// Devuelve los datos en formato JSON
echo json_encode($docentes);
?>

