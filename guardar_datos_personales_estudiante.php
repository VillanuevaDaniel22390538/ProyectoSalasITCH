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
$idUsuario = $_POST['idUsuario'];
$nombres = $_POST['nombres'];
$primerApellido = $_POST['primerApellido'];
$segundoApellido = $_POST['segundoApellido'];
$fechaNacimiento = $_POST['fechaNacimiento'];
$curp = $_POST['curp'];
$rfc = $_POST['rfc'];
$numeroCelular = $_POST['numeroCelular'];
$telefonoCasa = $_POST['telefonoCasa'];
$email = $_POST['email'];
$calle = $_POST['calle'];
$interseccionPrimera = $_POST['interseccionPrimera'];
$interseccionSegunda = $_POST['interseccionSegunda'];
$numExterior = $_POST['numExterior'];
$numInterior = $_POST['numInterior'];
$codigoPostal = $_POST['codigoPostal'];
$colonia = $_POST['colonia'];
$localidad = $_POST['localidad'];
$municipio = $_POST['municipio'];
$estado = $_POST['estado'];
$tipoDeUsuarioId = 1; // Tipo de usuario para estudiante

try {
    // Consulta preparada para insertar los datos del estudiante
    $stmt = $conn->prepare("INSERT INTO Estudiante (NumeroControl, idUsuario, Nombres, PrimerApellido, SegundoApellido, FechaNacimiento, CURP, RFC, NumeroCelular, TelefonoCasa, Email, Calle, InterseccionPrimera, InterseccionSegunda, NumExterior, NumInterior, CodigoPostal, Colonia, Localidad, Municipio, Estado, TipoDeUsuarioId) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$numeroControl, $idUsuario, $nombres, $primerApellido, $segundoApellido, $fechaNacimiento, $curp, $rfc, $numeroCelular, $telefonoCasa, $email, $calle, $interseccionPrimera, $interseccionSegunda, $numExterior, $numInterior, $codigoPostal, $colonia, $localidad, $municipio, $estado, $tipoDeUsuarioId]);

    // Redirigir a la página de información académica del estudiante
    $redirect_url = 'informacion_academica_estudiante.php?numeroControl=' . $numeroControl;
    echo "<script>
        alert('Datos personales guardados exitosamente. Por favor, completa tu información académica.');
        window.location.href='$redirect_url';
    </script>";

} catch (PDOException $e) {
    echo "Error al guardar los datos: " . $e->getMessage();
}

// Cierra la conexión
$conn = null;
?>