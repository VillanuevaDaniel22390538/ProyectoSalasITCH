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
$correoInstitucional = $_POST['correoInstitucional'];
$idCarrera = $_POST['idCarrera'];
$idCreditosComplementarios = $_POST['idCreditosComplementarios'];
$promedioGeneral = $_POST['promedioGeneral'];
$semestre = $_POST['semestre'];
$idAsignatura = $_POST['idAsignatura'];
$idStatusAsignatura = $_POST['idStatusAsignatura'];

try {
    // Consulta preparada para insertar la información académica del estudiante
    $stmt = $conn->prepare("INSERT INTO InformacionAcademicaEstudiante (NumeroControl, IDCarrera, IDCreditosComplementarios, CorreoInstitucional, PromedioGeneral) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$numeroControl, $idCarrera, $idCreditosComplementarios, $correoInstitucional, $promedioGeneral]);

    // Consulta preparada para insertar el historial académico del estudiante
    $stmtHistorial = $conn->prepare("INSERT INTO HistorialAcademicoEstudiante (NumeroControl, IDAsignatura, Semestre, IDStatusAsignatura, IDCreditosComplementarios) VALUES (?, ?, ?, ?, ?)");
    $stmtHistorial->execute([$numeroControl, $idAsignatura, $semestre, $idStatusAsignatura, $idCreditosComplementarios]);

    // Redirigir a la página de información médica del estudiante
    $redirect_url = 'informacion_medica_estudiante2.php?numeroControl=' . $numeroControl;
    echo "<script>
        alert('Información académica guardada exitosamente. Por favor, completa tu información médica.');
        window.location.href='$redirect_url';
    </script>";

} catch (PDOException $e) {
    echo "Error al guardar la información académica: " . $e->getMessage();
}

// Cierra la conexión
$conn = null;
?>