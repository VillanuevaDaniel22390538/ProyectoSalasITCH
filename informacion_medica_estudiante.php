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
        $NumeroControl = $_POST["NumeroControl"];

        // Obtener información médica del estudiante
        $stmt = $pdo->prepare("SELECT * FROM InformacionMedicaEstudiante WHERE NumeroControl = ?");
        $stmt->execute([$NumeroControl]);
        $informacionMedica = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$informacionMedica) {
            $mensaje = "No se encontró información médica para el estudiante.";
        }
    } elseif (isset($_POST["editar"])) {
        $IDInformacionMedica_EST = $_POST["IDInformacionMedica_EST"];
        $IDAlergias = $_POST["IDAlergias"];
        $IDEnfermedadesCronicas = $_POST["IDEnfermedadesCronicas"];
        $IDTipoSangre = $_POST["IDTipoSangre"];

        // Actualizar información médica
        $stmt = $pdo->prepare("UPDATE InformacionMedicaEstudiante SET IDAlergias = ?, IDEnfermedadesCronicas = ?, IDTipoSangre = ? WHERE IDInformacionMedica_EST = ?");
        $stmt->execute([$IDAlergias, $IDEnfermedadesCronicas, $IDTipoSangre, $IDInformacionMedica_EST]);
        $mensaje = "Información médica actualizada exitosamente.";
    } elseif (isset($_POST["borrar"])) {
        $IDInformacionMedica_EST = $_POST["IDInformacionMedica_EST"];

        // Borrar información médica
        $stmt = $pdo->prepare("DELETE FROM InformacionMedicaEstudiante WHERE IDInformacionMedica_EST = ?");
        $stmt->execute([$IDInformacionMedica_EST]);
        $mensaje = "Información médica borrada exitosamente.";
    }
}

// Obtener lista de estudiantes
$estudiantes = $pdo->query("SELECT NumeroControl, Nombres, PrimerApellido, SegundoApellido FROM Estudiante")->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Información Médica Estudiante</title>
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
        <div class="title">Información Médica Estudiante</div>
        <form method="POST">
            <div class="form-group">
                <label for="NumeroControl">Número de Control</label>
                <input type="text" id="NumeroControl" name="NumeroControl">
            </div>
            <div class="form-group">
                <label for="NumeroControlSelect">Seleccionar Estudiante</label>
                <select id="NumeroControlSelect" name="NumeroControl">
                    <option value="">Seleccione un estudiante</option>
                    <?php foreach ($estudiantes as $estudiante): ?>
                        <option value="<?= htmlspecialchars($estudiante['NumeroControl']) ?>">
                            <?= htmlspecialchars($estudiante['Nombres']) ?> <?= htmlspecialchars($estudiante['PrimerApellido']) ?> <?= htmlspecialchars($estudiante['SegundoApellido']) ?>
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
                                <td><?= htmlspecialchars($registro['IDInformacionMedica_EST']) ?></td>
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
                                    <input type="hidden" name="IDInformacionMedica_EST" value="<?= htmlspecialchars($registro['IDInformacionMedica_EST']) ?>">
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