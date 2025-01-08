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
$idDocente = $_POST['idDocente'];
$idAlergias = $_POST['idAlergias'];
$idEnfermedadesCronicas = $_POST['idEnfermedadesCronicas'];
$idTipoSangre = $_POST['idTipoSangre'];

try {
    // Consulta preparada para insertar la información médica del docente
    $stmt = $conn->prepare("INSERT INTO InformacionMedicaDocente (IDDocente, IDAlergias, IDEnfermedadesCronicas, IDTipoSangre) VALUES (?, ?, ?, ?)");
    $stmt->execute([$idDocente, $idAlergias, $idEnfermedadesCronicas, $idTipoSangre]);

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
