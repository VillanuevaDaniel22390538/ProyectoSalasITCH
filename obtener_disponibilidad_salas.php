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

// Consulta para obtener la disponibilidad de las salas
$sql = "SELECT IDSala, 
               CASE 
                   WHEN COUNT(*) = 0 THEN 'Disponible todo el día'
                   ELSE CONCAT('Ocupada hasta ', MAX(HoraFin))
               END AS disponibilidad
        FROM PrestamoSalas
        WHERE FechaPrestamo = CAST(GETDATE() AS DATE)
        GROUP BY IDSala";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$disponibilidad = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Devuelve los datos en formato JSON
echo json_encode($disponibilidad);
?>
