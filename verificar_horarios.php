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
    die(json_encode(['error' => 'Error en la conexión: ' . $e->getMessage()]));
}

// Obtener los datos enviados desde el cliente
$data = json_decode(file_get_contents('php://input'), true);
$IDSala = $data['IDSala'] ?? null;
$FechaPrestamo = $data['FechaPrestamo'] ?? null;
$HoraInicio = $data['HoraInicio'] ?? null;
$HoraFin = $data['HoraFin'] ?? null;

// Verificar que todos los datos necesarios estén presentes
if ($IDSala === null || $FechaPrestamo === null || $HoraInicio === null || $HoraFin === null) {
    die(json_encode(['error' => 'Datos incompletos']));
}

// Consulta para verificar si el horario ya está registrado
$sql = "SELECT COUNT(*) as count FROM PrestamoSalas 
        WHERE IDSala = :IDSala 
        AND FechaPrestamo = :FechaPrestamo 
        AND (
            (HoraInicio < :HoraFin AND HoraFin > :HoraInicio) 
            OR (HoraInicio < :HoraFin AND HoraFin > :HoraInicio)
        )";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'IDSala' => $IDSala,
    'FechaPrestamo' => $FechaPrestamo,
    'HoraInicio' => $HoraInicio,
    'HoraFin' => $HoraFin
]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Devolver el resultado en formato JSON
echo json_encode(['duplicado' => $result['count'] > 0]);
?>