<?php
// Configuración de conexión a la base de datos
$servername = "localhost";
$dbname = "ProyectoSalasITCH";
$username = "sa";
$password = "0103";

try {
    // Conectar a SQL Server usando PDO
    $conn = new PDO("sqlsrv:Server=$servername;Database=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Obtener datos del formulario
$sala = $_POST['sala'];
$idDocente = $_POST['idDocente'];
$fechaPrestamo = $_POST['fechaPrestamo'];
$horaInicio = $_POST['horaInicio'];
$horaFin = $_POST['horaFin'];
$observaciones = $_POST['observaciones'];
$idEstado = 5; // Estado RESERVADA

try {
    // Consulta preparada para insertar la reserva
    $stmt = $conn->prepare("INSERT INTO PrestamoSalas (IDSala, IDDocente, FechaPrestamo, HoraInicio, HoraFin, Observaciones, IDEstado) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$sala, $idDocente, $fechaPrestamo, $horaInicio, $horaFin, $observaciones, $idEstado]);

    // Obtener el ID del préstamo recién insertado
    $idPrestamo = $conn->lastInsertId();

    echo "<script>
        alert('Reserva exitosa. ID de la reserva: {$idPrestamo}');
        window.location.href='welcome_docente.php';
    </script>";
} catch (PDOException $e) {
    echo "Error en la reserva: " . $e->getMessage();
}

// Cierra la conexión
$conn = null;
?>