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

// Insertar un nuevo registro como disponible cuando una sala se vuelve disponible
$sql = "INSERT INTO PrestamoSalas (IDSala, IDDocente, FechaPrestamo, HoraInicio, HoraFin, Observaciones, IDEstado)
        SELECT IDSala, IDDocente, FechaPrestamo, HoraFin, HoraFin, 'Automáticamente disponible', 3 -- Disponible
        FROM PrestamoSalas
        WHERE HoraFin <= CONVERT(TIME, GETDATE()) AND IDEstado IN (1,2,4,5,6)
        AND NOT EXISTS (
            SELECT 1 FROM PrestamoSalas ps
            WHERE ps.IDSala = PrestamoSalas.IDSala
            AND ps.FechaPrestamo = PrestamoSalas.FechaPrestamo
            AND ps.HoraInicio = PrestamoSalas.HoraFin
            AND ps.IDEstado = 3
        )";
$stmt = $pdo->prepare($sql);
$stmt->execute();

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