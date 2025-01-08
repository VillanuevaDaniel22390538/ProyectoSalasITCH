<?php
session_start();
include 'conexion.php'; // Asegúrate de tener un archivo de conexión a la base de datos

$NumeroControl = trim($_POST['NumeroControl']); // Elimina espacios en blanco adicionales
$fecha_solicitud = $_POST['fecha_solicitud'];
$estado = 'pendiente';

try {
    $sql = "INSERT INTO solicitudes_prestamo (NumeroControl, fecha_solicitud, estado) VALUES (:NumeroControl, :fecha_solicitud, :estado)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':NumeroControl', $NumeroControl);
    $stmt->bindParam(':fecha_solicitud', $fecha_solicitud);
    $stmt->bindParam(':estado', $estado);
    $stmt->execute();

    // Obtener el ID de la solicitud recién insertada
    $numeroSolicitud = $pdo->lastInsertId();
    $_SESSION['numero_solicitud'] = $numeroSolicitud;

    // Redirigir a la página de confirmación
    header("Location: confirmacion_solicitud.php");
    exit();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;
?>
