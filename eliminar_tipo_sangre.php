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
}

// Verificar si se ha enviado el ID del tipo de sangre
if (isset($_POST['idTipoSangre'])) {
    $idTipoSangre = $_POST['idTipoSangre'];
} else {
    die("Error: ID del tipo de sangre no proporcionado.");
}

// Iniciar una transacción
$pdo->beginTransaction();

try {
    // Eliminar registros relacionados en las tablas dependientes
    $stmt = $pdo->prepare("UPDATE InformacionMedicaEstudiante SET IDTipoSangre = NULL WHERE IDTipoSangre = ?");
    $stmt->execute([$idTipoSangre]);

    $stmt = $pdo->prepare("UPDATE InformacionMedicaDocente SET IDTipoSangre = NULL WHERE IDTipoSangre = ?");
    $stmt->execute([$idTipoSangre]);

    $stmt = $pdo->prepare("UPDATE InformacionMedicaCoordinador SET IDTipoSangre = NULL WHERE IDTipoSangre = ?");
    $stmt->execute([$idTipoSangre]);

    $stmt = $pdo->prepare("UPDATE InformacionMedicaPersonal SET IDTipoSangre = NULL WHERE IDTipoSangre = ?");
    $stmt->execute([$idTipoSangre]);

    $stmt = $pdo->prepare("UPDATE InformacionMedicaEncargadoLaboratorio SET IDTipoSangre = NULL WHERE IDTipoSangre = ?");
    $stmt->execute([$idTipoSangre]);

    $stmt = $pdo->prepare("UPDATE InformacionMedicaJefeDeDepartamento SET IDTipoSangre = NULL WHERE IDTipoSangre = ?");
    $stmt->execute([$idTipoSangre]);

    // Eliminar el registro de la tabla TipoSangre
    $stmt = $pdo->prepare("DELETE FROM TipoSangre WHERE IDTipoSangre = ?");
    $stmt->execute([$idTipoSangre]);

    // Confirmar la transacción
    $pdo->commit();
    echo "Registro eliminado correctamente";
} catch (PDOException $e) {
    // Revertir la transacción en caso de error
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión
$pdo = null;
?>