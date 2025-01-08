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
$numeroControl = $_POST['numeroControl'];
$idAlergias = $_POST['idAlergias'];
$idEnfermedadesCronicas = $_POST['idEnfermedadesCronicas'];
$idTipoSangre = $_POST['idTipoSangre'];

try {
    // Consulta preparada para insertar la información médica del estudiante
    $stmt = $conn->prepare("INSERT INTO InformacionMedicaEstudiante (NumeroControl, IDAlergias, IDEnfermedadesCronicas, IDTipoSangre) VALUES (?, ?, ?, ?)");
    $stmt->execute([$numeroControl, $idAlergias, $idEnfermedadesCronicas, $idTipoSangre]);

    // Redirigir a index.php
    echo "<script>
        alert('Información médica guardada exitosamente.');
        window.location.href='index.php';
    </script>";
} catch (PDOException $e) {
    echo "Error al guardar la información médica: " . $e->getMessage();
}

// Cierra la conexión
$conn = null;
?>