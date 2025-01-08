<?php
// Conexión a la base de datos
$serverName = "localhost";
$database = "ProyectoSalasITCH";
$username_db = "sa";
$password_db = "0103";

try {
    $pdo = new PDO("sqlsrv:server=$serverName;Database=$database", $username_db, $password_db);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}

// Verificar si los datos se han enviado correctamente
if (isset($_POST['idDocente']) && isset($_POST['idUsuario']) && isset($_POST['nombres']) && isset($_POST['primerApellido']) && isset($_POST['segundoApellido']) && isset($_POST['fechaNacimiento']) && isset($_POST['curp']) && isset($_POST['rfc']) && isset($_POST['numeroCelular']) && isset($_POST['telefonoCasa']) && isset($_POST['email']) && isset($_POST['calle']) && isset($_POST['interseccionPrimera']) && isset($_POST['interseccionSegunda']) && isset($_POST['numExterior']) && isset($_POST['numInterior']) && isset($_POST['codigoPostal']) && isset($_POST['colonia']) && isset($_POST['localidad']) && isset($_POST['municipio']) && isset($_POST['estado']) && isset($_POST['tipoDeUsuarioId'])) {
    $idDocente = $_POST['idDocente'];
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
    $tipoDeUsuarioId = $_POST['tipoDeUsuarioId'];

    try {
        // Iniciar una transacción
        $pdo->beginTransaction();

        // Actualizar los datos del usuario
        $sql = "UPDATE Usuarios SET NombreUsuario = :nombreUsuario, emailUsuario = :emailUsuario, passsword = :password, TipoDeUsuarioId = :tipoDeUsuarioId WHERE idUsuario = :idUsuario";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'nombreUsuario' => $_POST['nombreUsuario'],
            'emailUsuario' => $_POST['emailUsuario'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT), // Encriptar la contraseña
            'tipoDeUsuarioId' => $tipoDeUsuarioId,
            'idUsuario' => $idUsuario
        ]);

        // Actualizar los datos del docente
        $sql = "UPDATE Docente SET Nombres = :nombres, PrimerApellido = :primerApellido, SegundoApellido = :segundoApellido, FechaNacimiento = :fechaNacimiento, CURP = :curp, RFC = :rfc, NumeroCelular = :numeroCelular, TelefonoCasa = :telefonoCasa, Email = :email, Calle = :calle, InterseccionPrimera = :interseccionPrimera, InterseccionSegunda = :interseccionSegunda, NumExterior = :numExterior, NumInterior = :numInterior, CodigoPostal = :codigoPostal, Colonia = :colonia, Localidad = :localidad, Municipio = :municipio, Estado = :estado, TipoDeUsuarioId = :tipoDeUsuarioId WHERE IDDocente = :idDocente";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'nombres' => $nombres,
            'primerApellido' => $primerApellido,
            'segundoApellido' => $segundoApellido,
            'fechaNacimiento' => $fechaNacimiento,
            'curp' => $curp,
            'rfc' => $rfc,
            'numeroCelular' => $numeroCelular,
            'telefonoCasa' => $telefonoCasa,
            'email' => $email,
            'calle' => $calle,
            'interseccionPrimera' => $interseccionPrimera,
            'interseccionSegunda' => $interseccionSegunda,
            'numExterior' => $numExterior,
            'numInterior' => $numInterior,
            'codigoPostal' => $codigoPostal,
            'colonia' => $colonia,
            'localidad' => $localidad,
            'municipio' => $municipio,
            'estado' => $estado,
            'tipoDeUsuarioId' => $tipoDeUsuarioId,
            'idDocente' => $idDocente
        ]);

        // Confirmar la transacción
        $pdo->commit();

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        // Revertir la transacción en caso de error
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos no enviados correctamente']);
}
?>
