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

// Verificar si se ha enviado el ID de la enfermedad crónica
if (isset($_POST['idEnfermedad'])) {
    $idEnfermedad = $_POST['idEnfermedad'];
} else {
    die("Error: ID de la enfermedad crónica no proporcionado.");
}

// Iniciar una transacción
$pdo->beginTransaction();

try {
    // Eliminar registros relacionados en las tablas dependientes
    $stmt = $pdo->prepare("UPDATE InformacionMedicaEstudiante SET IDEnfermedadesCronicas = NULL WHERE IDEnfermedadesCronicas = ?");
    $stmt->execute([$idEnfermedad]);

    $stmt = $pdo->prepare("UPDATE InformacionMedicaDocente SET IDEnfermedadesCronicas = NULL WHERE IDEnfermedadesCronicas = ?");
    $stmt->execute([$idEnfermedad]);

    $stmt = $pdo->prepare("UPDATE InformacionMedicaCoordinador SET IDEnfermedadesCronicas = NULL WHERE IDEnfermedadesCronicas = ?");
    $stmt->execute([$idEnfermedad]);

    $stmt = $pdo->prepare("UPDATE InformacionMedicaPersonal SET IDEnfermedadesCronicas = NULL WHERE IDEnfermedadesCronicas = ?");
    $stmt->execute([$idEnfermedad]);

    $stmt = $pdo->prepare("UPDATE InformacionMedicaEncargadoLaboratorio SET IDEnfermedadesCronicas = NULL WHERE IDEnfermedadesCronicas = ?");
    $stmt->execute([$idEnfermedad]);

    $stmt = $pdo->prepare("UPDATE InformacionMedicaJefeDeDepartamento SET IDEnfermedadesCronicas = NULL WHERE IDEnfermedadesCronicas = ?");
    $stmt->execute([$idEnfermedad]);

    // Eliminar el registro de la tabla EnfermedadesCronicas
    $stmt = $pdo->prepare("DELETE FROM EnfermedadesCronicas WHERE IDEnfermedadesCronicas = ?");
    $stmt->execute([$idEnfermedad]);

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