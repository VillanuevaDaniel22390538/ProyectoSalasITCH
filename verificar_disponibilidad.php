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

// Obtener la hora actual
$current_time = date('H:i:s');

// Consulta para obtener las salas cuyo HoraFin ha pasado y el IDEstado es 1, 2, 4, 5 o 6
$sql = "SELECT IDSala, IDDocente, FechaPrestamo, HoraFin
        FROM PrestamoSalas
        WHERE HoraFin <= :current_time AND IDEstado IN (1, 2, 4, 5, 6)";
$stmt = $pdo->prepare($sql);
$stmt->execute(['current_time' => $current_time]);
$salas = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($salas as $sala) {
    // Insertar un nuevo registro indicando que la sala está disponible
    $sqlInsert = "INSERT INTO PrestamoSalas (IDSala, IDDocente, FechaPrestamo, HoraInicio, HoraFin, Observaciones, IDEstado)
                  VALUES (:IDSala, :IDDocente, :FechaPrestamo, :HoraFin, :HoraFin, 'Automáticamente disponible', 3)";
    $stmtInsert = $pdo->prepare($sqlInsert);
    $stmtInsert->execute([
        'IDSala' => $sala['IDSala'],
        'IDDocente' => $sala['IDDocente'],
        'FechaPrestamo' => $sala['FechaPrestamo'],
        'HoraFin' => $sala['HoraFin']
    ]);
}

// Devolver una respuesta indicando que la verificación se ha completado
echo json_encode(['success' => true]);
?>