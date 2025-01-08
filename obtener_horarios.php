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

// Obtener el ID de la sala y la fecha desde la URL
$salaId = $_GET['salaId'];
$fecha = $_GET['fecha'];

// Consulta para obtener los horarios de la sala desde PrestamoSalas
$sql = "SELECT ps.HoraInicio, ps.HoraFin, ps.IDEstado, d.Nombres + ' ' + d.PrimerApellido + ' ' + d.SegundoApellido AS Docente
        FROM PrestamoSalas ps
        JOIN Docente d ON ps.IDDocente = d.IDDocente
        WHERE ps.IDSala = :salaId AND ps.FechaPrestamo = :fecha";
$stmt = $pdo->prepare($sql);
$stmt->execute(['salaId' => $salaId, 'fecha' => $fecha]);
$horarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Devolver los datos en formato JSON
echo json_encode($horarios);

?>
