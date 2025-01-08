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

// Obtener los datos enviados desde el cliente
$data = json_decode(file_get_contents('php://input'), true);

$IDSala = $data['IDSala'];
$IDDocente = $data['IDDocente'];
$FechaPrestamo = $data['FechaPrestamo'];
$HoraInicio = $data['HoraInicio'];
$HoraFin = $data['HoraFin'];
$Observaciones = $data['Observaciones'];
$IDEstado = $data['IDEstado'];

// Insertar los datos en la tabla PrestamoSalas
$sql = "INSERT INTO PrestamoSalas (IDSala, IDDocente, FechaPrestamo, HoraInicio, HoraFin, Observaciones, IDEstado) 
        VALUES (:IDSala, :IDDocente, :FechaPrestamo, :HoraInicio, :HoraFin, :Observaciones, :IDEstado)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':IDSala', $IDSala);
$stmt->bindParam(':IDDocente', $IDDocente);
$stmt->bindParam(':FechaPrestamo', $FechaPrestamo);
$stmt->bindParam(':HoraInicio', $HoraInicio);
$stmt->bindParam(':HoraFin', $HoraFin);
$stmt->bindParam(':Observaciones', $Observaciones);
$stmt->bindParam(':IDEstado', $IDEstado);

if ($stmt->execute()) {
    // Actualizar el IDEstado en la tabla Sala
    $sqlUpdate = "UPDATE Sala SET IDEstado = :IDEstado WHERE IDSala = :IDSala";
    $stmtUpdate = $pdo->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':IDEstado', $IDEstado);
    $stmtUpdate->bindParam(':IDSala', $IDSala);
    $stmtUpdate->execute();

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>