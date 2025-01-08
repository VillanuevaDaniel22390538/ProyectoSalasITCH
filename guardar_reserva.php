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

// Obtener los datos de la solicitud
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

if ($stmt->execute([
    'IDSala' => $IDSala,
    'IDDocente' => $IDDocente,
    'FechaPrestamo' => $FechaPrestamo,
    'HoraInicio' => $HoraInicio,
    'HoraFin' => $HoraFin,
    'Observaciones' => $Observaciones,
    'IDEstado' => $IDEstado
])) {
    // Insertar los datos en la tabla HorariosSalas
    $sqlHorario = "INSERT INTO HorariosSalas (IDSala, Fecha, HoraInicio, HoraFin, IDEstado) 
                   VALUES (:IDSala, :FechaPrestamo, :HoraInicio, :HoraFin, :IDEstado)";
    $stmtHorario = $pdo->prepare($sqlHorario);
    $stmtHorario->execute([
        'IDSala' => $IDSala,
        'FechaPrestamo' => $FechaPrestamo,
        'HoraInicio' => $HoraInicio,
        'HoraFin' => $HoraFin,
        'IDEstado' => $IDEstado
    ]);

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>