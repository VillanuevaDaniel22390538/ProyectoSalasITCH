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
$idUsuario = $_POST['idUsuario'];
$idDocente = $_POST['idDocente'];
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
$tipoDeUsuarioId = 2; // Tipo de usuario para Docente

try {
    // Consulta preparada para insertar los datos personales del docente
    $stmt = $conn->prepare("INSERT INTO Docente (IDDocente, idUsuario, Nombres, PrimerApellido, SegundoApellido, FechaNacimiento, CURP, RFC, NumeroCelular, TelefonoCasa, Email, Calle, InterseccionPrimera, InterseccionSegunda, NumExterior, NumInterior, CodigoPostal, Colonia, Localidad, Municipio, Estado, TipoDeUsuarioId) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$idDocente, $idUsuario, $nombres, $primerApellido, $segundoApellido, $fechaNacimiento, $curp, $rfc, $numeroCelular, $telefonoCasa, $email, $calle, $interseccionPrimera, $interseccionSegunda, $numExterior, $numInterior, $codigoPostal, $colonia, $localidad, $municipio, $estado, $tipoDeUsuarioId]);

    // Redirigir a informacion_academica.php con el IDDocente
    echo "<script>
        alert('Datos personales guardados exitosamente. Por favor, completa tu información académica.');
        window.location.href='informacion_academica.php?idDocente=$idDocente';
    </script>";
} catch (PDOException $e) {
    echo "Error al guardar los datos personales: " . $e->getMessage();
}

// Cierra la conexión
$conn = null;
?>
