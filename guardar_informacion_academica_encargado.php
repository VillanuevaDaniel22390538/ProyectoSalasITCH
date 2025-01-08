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
$idEncargadoLaboratorio = $_POST['idEncargadoLaboratorio'];
$correoInstitucional = $_POST['correoInstitucional'];
$idGrado = $_POST['idGrado'];
$universidad = $_POST['universidad'];
$cedula = $_POST['cedula'];
$idDepartamentoAcademico = $_POST['idDepartamentoAcademico'];

try {
    // Consulta preparada para insertar la información académica del encargado de laboratorio
    $stmt = $conn->prepare("INSERT INTO InformacionAcademicaEncargadoLaboratorio (IDEncargadoLaboratorio, CorreoInstitucional, IDGrado, IDDepartamentoAcademico) VALUES (?, ?, ?, ?)");
    $stmt->execute([$idEncargadoLaboratorio, $correoInstitucional, $idGrado, $idDepartamentoAcademico]);

    // Redirigir a la página de información médica del encargado de laboratorio
    $redirect_url = 'informacion_medica_encargado2.php?idEncargadoLaboratorio=' . $idEncargadoLaboratorio;
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