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
$correoInstitucional = $_POST['correoInstitucional'];
$idGrado = $_POST['idGrado'];
$idDepartamentoAcademico = $_POST['idDepartamentoAcademico'];

try {
    // Consulta preparada para insertar la información académica del docente
    $stmt = $conn->prepare("INSERT INTO InformacionAcademicaDocente (IDDocente, CorreoInstitucional, IDGrado, IDDepartamentoAcademico) VALUES (?, ?, ?, ?)");
    $stmt->execute([$idDocente, $correoInstitucional, $idGrado, $idDepartamentoAcademico]);

    // Redirigir a informacion_medica.php con el IDDocente
    echo "<script>
        alert('Información académica guardada exitosamente. Por favor, completa tu información médica.');
        window.location.href='informacion_medica.php?idDocente=$idDocente';
    </script>";
} catch (PDOException $e) {
    echo "Error al guardar la información académica: " . $e->getMessage();
}

// Cierra la conexión
$conn = null;
?>