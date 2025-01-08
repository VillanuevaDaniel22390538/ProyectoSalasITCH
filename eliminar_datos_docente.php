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
if (isset($_POST['idDocente']) && isset($_POST['idUsuario'])) {
    $idDocente = $_POST['idDocente'];
    $idUsuario = $_POST['idUsuario'];

    try {
        // Iniciar una transacción
        $pdo->beginTransaction();

        // Eliminar los registros relacionados en la tabla InformacionAcademicaDocente
        $sql = "DELETE FROM InformacionAcademicaDocente WHERE IDDocente = :idDocente";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['idDocente' => $idDocente]);

        // Eliminar los registros relacionados en la tabla InformacionMedicaDocente
        $sql = "DELETE FROM InformacionMedicaDocente WHERE IDDocente = :idDocente";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['idDocente' => $idDocente]);

        // Eliminar los registros relacionados en la tabla PrestamoSalas
        $sql = "DELETE FROM PrestamoSalas WHERE IDDocente = :idDocente";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['idDocente' => $idDocente]);

        // Eliminar el registro del docente
        $sql = "DELETE FROM Docente WHERE IDDocente = :idDocente";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['idDocente' => $idDocente]);

        // Eliminar el registro del usuario
        $sql = "DELETE FROM Usuarios WHERE idUsuario = :idUsuario";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['idUsuario' => $idUsuario]);

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
