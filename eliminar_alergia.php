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

// Obtener el ID de la alergia a eliminar
$idAlergia = $_POST['idAlergia'];

// Iniciar una transacción
$pdo->beginTransaction();

try {
    // Eliminar registros relacionados en las tablas dependientes
    $stmt = $pdo->prepare("UPDATE InformacionMedicaEstudiante SET IDAlergias = NULL WHERE IDAlergias = ?");
    $stmt->execute([$idAlergia]);

    $stmt = $pdo->prepare("UPDATE InformacionMedicaDocente SET IDAlergias = NULL WHERE IDAlergias = ?");
    $stmt->execute([$idAlergia]);

    $stmt = $pdo->prepare("UPDATE InformacionMedicaCoordinador SET IDAlergias = NULL WHERE IDAlergias = ?");
    $stmt->execute([$idAlergia]);

    $stmt = $pdo->prepare("UPDATE InformacionMedicaPersonal SET IDAlergias = NULL WHERE IDAlergias = ?");
    $stmt->execute([$idAlergia]);

    $stmt = $pdo->prepare("UPDATE InformacionMedicaEncargadoLaboratorio SET IDAlergias = NULL WHERE IDAlergias = ?");
    $stmt->execute([$idAlergia]);

    $stmt = $pdo->prepare("UPDATE InformacionMedicaJefeDeDepartamento SET IDAlergias = NULL WHERE IDAlergias = ?");
    $stmt->execute([$idAlergia]);

    // Eliminar el registro de la tabla Alergias
    $stmt = $pdo->prepare("DELETE FROM Alergias WHERE IDAlergias = ?");
    $stmt->execute([$idAlergia]);

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