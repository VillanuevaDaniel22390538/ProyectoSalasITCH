<?php
$serverName = "localhost";
$database = "ProyectoSalasITCH";
$username = "sa";
$password = "0103";

try {
    $pdo = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error en la conexión: " . $e->getMessage();
    exit();
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["buscar"])) {
        $IDJefeDeDepartamento = $_POST["IDJefeDeDepartamento"];

        // Obtener información médica del jefe de departamento
        $stmt = $pdo->prepare("SELECT * FROM InformacionMedicaJefeDeDepartamento WHERE IDJefeDeDepartamento = ?");
        $stmt->execute([$IDJefeDeDepartamento]);
        $informacionMedica = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$informacionMedica) {
            $mensaje = "No se encontró información médica para el jefe de departamento.";
        }
    } elseif (isset($_POST["editar"])) {
        $IDInformacionMedica_JD = $_POST["IDInformacionMedica_JD"];
        $IDAlergias = $_POST["IDAlergias"];
        $IDEnfermedadesCronicas = $_POST["IDEnfermedadesCronicas"];
        $IDTipoSangre = $_POST["IDTipoSangre"];

        // Actualizar información médica
        $stmt = $pdo->prepare("UPDATE InformacionMedicaJefeDeDepartamento SET IDAlergias = ?, IDEnfermedadesCronicas = ?, IDTipoSangre = ? WHERE IDInformacionMedica_JD = ?");
        $stmt->execute([$IDAlergias, $IDEnfermedadesCronicas, $IDTipoSangre, $IDInformacionMedica_JD]);
        $mensaje = "Información médica actualizada exitosamente.";
    } elseif (isset($_POST["borrar"])) {
        $IDInformacionMedica_JD = $_POST["IDInformacionMedica_JD"];

        // Borrar información médica
        $stmt = $pdo->prepare("DELETE FROM InformacionMedicaJefeDeDepartamento WHERE IDInformacionMedica_JD = ?");
        $stmt->execute([$IDInformacionMedica_JD]);
        $mensaje = "Información médica borrada exitosamente.";
    }
}

// Obtener lista de jefes de departamento
$jefes = $pdo->query("SELECT IDJefeDeDepartamento, Nombres, PrimerApellido, SegundoApellido FROM JefeDeDepartamento")->fetchAll(PDO::FETCH_ASSOC);

// Obtener lista de alergias
$alergias = $pdo->query("SELECT IDAlergias, NombreAlergia FROM Alergias")->fetchAll(PDO::FETCH_ASSOC);

// Obtener lista de enfermedades crónicas
$enfermedades = $pdo->query("SELECT IDEnfermedadesCronicas, NombreEnfermedad FROM EnfermedadesCronicas")->fetchAll(PDO::FETCH_ASSOC);

// Obtener lista de tipos de sangre
$tiposSangre = $pdo->query("SELECT IDTipoSangre, NombreTipoSangre FROM TipoSangre")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información Médica Jefe de Departamento</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-image: url('imagenes/fondo.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            text-align: center;
            width: 90%;
            max-width: 800px;
            color: white;
        }
        .title {
            font-size: 28px;
            margin-bottom: 20px;
            color: #ffcc00;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
        }
        .form-group button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid white;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .back-arrow {
    position: absolute;
    top: 20px; /* Ajusta la posición vertical */
    left: 20px; /* Ajusta la posición horizontal */
    color: yellow;
    text-decoration: none;
    font-size: 24px;
}
    </style>
</head>
<body>
<a href="javascript:history.back()" class="back-arrow">&#x2190; </a>

    <div class="container">
        <div class="title">Información Médica Jefe de Departamento</div>
        <form method="POST">
            <div class="form-group">
                <label for="IDJefeDeDepartamento">ID Jefe de Departamento</label>
                <input type="text" id="IDJefeDeDepartamento" name="IDJefeDeDepartamento">
            </div>
            <div class="form-group">
                <label for="IDJefeDeDepartamentoSelect">Seleccionar Jefe de Departamento</label>
                <select id="IDJefeDeDepartamentoSelect" name="IDJefeDeDepartamento">
                    <option value="">Seleccione un jefe de departamento</option>
                    <?php foreach ($jefes as $jefe): ?>
                        <option value="<?= htmlspecialchars($jefe['IDJefeDeDepartamento']) ?>">
                            <?= htmlspecialchars($jefe['Nombres']) ?> <?= htmlspecialchars($jefe['PrimerApellido']) ?> <?= htmlspecialchars($jefe['SegundoApellido']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" name="buscar">Buscar</button>
            </div>
        </form>
        <?php if (isset($informacionMedica) && $informacionMedica): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Alergias</th>
                        <th>Enfermedades Crónicas</th>
                        <th>Tipo de Sangre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($informacionMedica as $registro): ?>
                        <tr>
                            <form method="POST">
                                <td><?= htmlspecialchars($registro['IDInformacionMedica_JD']) ?></td>
                                <td>
                                    <select name="IDAlergias">
                                        <?php foreach ($alergias as $alergia): ?>
                                            <option value="<?= htmlspecialchars($alergia['IDAlergias']) ?>" <?= $alergia['IDAlergias'] == $registro['IDAlergias'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($alergia['NombreAlergia']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="IDEnfermedadesCronicas">
                                        <?php foreach ($enfermedades as $enfermedad): ?>
                                            <option value="<?= htmlspecialchars($enfermedad['IDEnfermedadesCronicas']) ?>" <?= $enfermedad['IDEnfermedadesCronicas'] == $registro['IDEnfermedadesCronicas'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($enfermedad['NombreEnfermedad']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="IDTipoSangre">
                                        <?php foreach ($tiposSangre as $tipo): ?>
                                            <option value="<?= htmlspecialchars($tipo['IDTipoSangre']) ?>" <?= $tipo['IDTipoSangre'] == $registro['IDTipoSangre'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($tipo['NombreTipoSangre']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="hidden" name="IDInformacionMedica_JD" value="<?= htmlspecialchars($registro['IDInformacionMedica_JD']) ?>">
                                    <button type="submit" name="editar">Editar</button>
                                    <button type="submit" name="borrar">Borrar</button>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <?php if ($mensaje): ?>
            <div class="form-group">
                <p><?= htmlspecialchars($mensaje) ?></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>