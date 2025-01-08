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
$NumeroControl = $_POST['NumeroControl'];
$NombreUsuario = $_POST['NombreUsuario'];
$emailUsuario = $_POST['emailUsuario'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar la contraseña
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
    // Iniciar una transacción
    $pdo->beginTransaction();

    // Insertar datos en la tabla Usuarios
    $sql_usuario = "INSERT INTO Usuarios (NombreUsuario, emailUsuario, passsword, TipoDeUsuarioId) VALUES (?, ?, ?, ?)";
    $stmt_usuario = $pdo->prepare($sql_usuario);
    $stmt_usuario->execute([$NombreUsuario, $emailUsuario, $password, $TipoDeUsuarioId]);

    // Obtener el idUsuario recién insertado
    $idUsuario = $pdo->lastInsertId();

    // Insertar datos en la tabla Estudiante
    $sql_estudiante = "INSERT INTO Estudiante (NumeroControl, idUsuario, Nombres, PrimerApellido, SegundoApellido, FechaNacimiento, CURP, RFC, NumeroCelular, TelefonoCasa, Email, Calle, InterseccionPrimera, InterseccionSegunda, NumExterior, NumInterior, CodigoPostal, Colonia, Localidad, Municipio, Estado, TipoDeUsuarioId) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_estudiante = $pdo->prepare($sql_estudiante);
    $stmt_estudiante->execute([$NumeroControl, $idUsuario, $Nombres, $PrimerApellido, $SegundoApellido, $FechaNacimiento, $CURP, $RFC, $NumeroCelular, $TelefonoCasa, $Email, $Calle, $InterseccionPrimera, $InterseccionSegunda, $NumExterior, $NumInterior, $CodigoPostal, $Colonia, $Localidad, $Municipio, $Estado, $TipoDeUsuarioId]);

    // Confirmar la transacción
    $pdo->commit();

    // Redirigir a la página de confirmación
    header("Location: confirmacion.php?mensaje=Nuevo estudiante añadido correctamente");
    exit();
} catch (PDOException $e) {
    // Revertir la transacción en caso de error
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
}
?>