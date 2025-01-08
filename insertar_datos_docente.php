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
if (isset($_POST['idDocente']) && isset($_POST['nombreUsuario']) && isset($_POST['emailUsuario']) && isset($_POST['password']) && isset($_POST['tipoDeUsuarioId']) && isset($_POST['nombres']) && isset($_POST['primerApellido']) && isset($_POST['segundoApellido']) && isset($_POST['fechaNacimiento']) && isset($_POST['curp']) && isset($_POST['rfc']) && isset($_POST['numeroCelular']) && isset($_POST['telefonoCasa']) && isset($_POST['email']) && isset($_POST['calle']) && isset($_POST['interseccionPrimera']) && isset($_POST['interseccionSegunda']) && isset($_POST['numExterior']) && isset($_POST['numInterior']) && isset($_POST['codigoPostal']) && isset($_POST['colonia']) && isset($_POST['localidad']) && isset($_POST['municipio']) && isset($_POST['estado'])) {
    $idDocente = $_POST['idDocente'];
    $nombreUsuario = $_POST['nombreUsuario'];
    $emailUsuario = $_POST['emailUsuario'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar la contraseña
    $tipoDeUsuarioId = $_POST['tipoDeUsuarioId'];
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

    try {
        // Iniciar una transacción
        $pdo->beginTransaction();

        // Insertar los datos del usuario
        $sql = "INSERT INTO Usuarios (NombreUsuario, emailUsuario, passsword, TipoDeUsuarioId) VALUES (:nombreUsuario, :emailUsuario, :password, :tipoDeUsuarioId)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'nombreUsuario' => $nombreUsuario,
            'emailUsuario' => $emailUsuario,
            'password' => $password, // Corregir el nombre del parámetro
            'tipoDeUsuarioId' => $tipoDeUsuarioId
        ]);

        // Obtener el ID del usuario insertado
        $idUsuario = $pdo->lastInsertId();

        // Insertar los datos del docente
        $sql = "INSERT INTO Docente (IDDocente, idUsuario, Nombres, PrimerApellido, SegundoApellido, FechaNacimiento, CURP, RFC, NumeroCelular, TelefonoCasa, Email, Calle, InterseccionPrimera, InterseccionSegunda, NumExterior, NumInterior, CodigoPostal, Colonia, Localidad, Municipio, Estado, TipoDeUsuarioId) VALUES (:idDocente, :idUsuario, :nombres, :primerApellido, :segundoApellido, :fechaNacimiento, :curp, :rfc, :numeroCelular, :telefonoCasa, :email, :calle, :interseccionPrimera, :interseccionSegunda, :numExterior, :numInterior, :codigoPostal, :colonia, :localidad, :municipio, :estado, :tipoDeUsuarioId)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'idDocente' => $idDocente,
            'idUsuario' => $idUsuario,
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
            'tipoDeUsuarioId' => $tipoDeUsuarioId
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
