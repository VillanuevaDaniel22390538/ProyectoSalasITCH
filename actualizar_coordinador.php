<?php
$serverName = "localhost";
$database = "ProyectoSalasITCH";
$username = "sa";
$password = "0103";

try {
    $pdo = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión Exitosa";
} catch (PDOException $e) {
    echo "Error en la conexión: " . $e->getMessage();
    exit();
}

// Obtener datos del formulario
$IDCoordinador = $_POST['IDCoordinador'];
$Nombres = $_POST['Nombres'];
$PrimerApellido = $_POST['PrimerApellido'];
$SegundoApellido = $_POST['SegundoApellido'];
$FechaNacimiento = $_POST['FechaNacimiento'];
$CURP = $_POST['CURP'];
$RFC = $_POST['RFC'];
$NumeroCelular = $_POST['NumeroCelular'];
$TelefonoCasa = $_POST['TelefonoCasa'];
$Email = $_POST['Email'];
$Calle = $_POST['Calle'];
$InterseccionPrimera = $_POST['InterseccionPrimera'];
$InterseccionSegunda = $_POST['InterseccionSegunda'];
$NumExterior = $_POST['NumExterior'];
$NumInterior = $_POST['NumInterior'];
$CodigoPostal = $_POST['CodigoPostal'];
$Colonia = $_POST['Colonia'];
$Localidad = $_POST['Localidad'];
$Municipio = $_POST['Municipio'];
$Estado = $_POST['Estado'];
$TipoDeUsuarioId = $_POST['TipoDeUsuarioId'];

try {
    // Actualizar datos del coordinador
    $sql = "UPDATE Coordinador SET Nombres = ?, PrimerApellido = ?, SegundoApellido = ?, FechaNacimiento = ?, CURP = ?, RFC = ?, NumeroCelular = ?, TelefonoCasa = ?, Email = ?, Calle = ?, InterseccionPrimera = ?, InterseccionSegunda = ?, NumExterior = ?, NumInterior = ?, CodigoPostal = ?, Colonia = ?, Localidad = ?, Municipio = ?, Estado = ?, TipoDeUsuarioId = ? WHERE IDCoordinador = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$Nombres, $PrimerApellido, $SegundoApellido, $FechaNacimiento, $CURP, $RFC, $NumeroCelular, $TelefonoCasa, $Email, $Calle, $InterseccionPrimera, $InterseccionSegunda, $NumExterior, $NumInterior, $CodigoPostal, $Colonia, $Localidad, $Municipio, $Estado, $TipoDeUsuarioId, $IDCoordinador]);

    // Redirigir a la página de confirmación
    header("Location: confirmacion.php?mensaje=Datos del coordinador actualizados correctamente");
    exit();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>