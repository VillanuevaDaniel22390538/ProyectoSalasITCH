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

        // Obtener historial académico del estudiante
        $stmt = $pdo->prepare("SELECT * FROM HistorialAcademicoEstudiante WHERE NumeroControl = ?");
        $stmt->execute([$NumeroControl]);
        $historial = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$historial) {
            $mensaje = "No se encontró historial académico para el estudiante.";
        }
    } elseif (isset($_POST["editar"])) {
        $IDHistorialAcademico_EST = $_POST["IDHistorialAcademico_EST"];
        $IDAsignatura = $_POST["IDAsignatura"];
    $TotalPromedio = $_POST["TotalPromedio"];
    $Semestre = $_POST["Semestre"];
    $IDStatusAsignatura = $_POST["IDStatusAsignatura"];
    $IDCreditosComplementarios = $_POST["IDCreditosComplementarios"];

    // Actualizar historial académico
    $stmt = $pdo->prepare("UPDATE HistorialAcademicoEstudiante SET IDAsignatura = ?, TotalPromedio = ?, Semestre = ?, IDStatusAsignatura = ?, IDCreditosComplementarios = ? WHERE IDHistorialAcademico_EST = ?");
    $stmt->execute([$IDAsignatura, $TotalPromedio, $Semestre, $IDStatusAsignatura, $IDCreditosComplementarios, $IDHistorialAcademico_EST]);
    $mensaje = "Historial académico actualizado exitosamente.";
} elseif (isset($_POST["borrar"])) {
    $IDHistorialAcademico_EST = $_POST["IDHistorialAcademico_EST"];

    // Borrar historial académico
    $stmt = $pdo->prepare("DELETE FROM HistorialAcademicoEstudiante WHERE IDHistorialAcademico_EST = ?");
    $stmt->execute([$IDHistorialAcademico_EST]);
    $mensaje = "Historial académico borrado exitosamente.";
}
}

// Obtener lista de estudiantes
$estudiantes = $pdo->query("SELECT NumeroControl, Nombres, PrimerApellido, SegundoApellido FROM Estudiante")->fetchAll(PDO::FETCH_ASSOC);

// Obtener lista de asignaturas
$asignaturas = $pdo->query("SELECT IDAsignatura, NombreAsignatura FROM Asignaturas")->fetchAll(PDO::FETCH_ASSOC);

// Obtener lista de estados de asignatura
$estadosAsignatura = $pdo->query("SELECT IDStatusAsignatura, Estado FROM StatusAsignatura")->fetchAll(PDO::FETCH_ASSOC);

// Obtener lista de créditos complementarios
$creditos = $pdo->query("SELECT IDCreditosComplementarios, Total FROM CreditosComplementarios")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial Académico Estudiante</title>
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
        <div class="title">Historial Académico Estudiante</div>
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
        <?php if (isset($historial) && $historial): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Asignatura</th>
                        <th>Total Promedio</th>
                        <th>Semestre</th>
                        <th>Estado</th>
                        <th>Créditos Complementarios</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($historial as $registro): ?>
                        <tr>
                            <form method="POST">
                                <td><?= htmlspecialchars($registro['IDHistorialAcademico_EST']) ?></td>
                                <td>
                                    <select name="IDAsignatura">
                                        <?php foreach ($asignaturas as $asignatura): ?>
                                            <option value="<?= htmlspecialchars($asignatura['IDAsignatura']) ?>" <?= $asignatura['IDAsignatura'] == $registro['IDAsignatura'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($asignatura['NombreAsignatura']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td><input type="text" name="TotalPromedio" value="<?= htmlspecialchars($registro['TotalPromedio']) ?>"></td>
                                <td><input type="text" name="Semestre" value="<?= htmlspecialchars($registro['Semestre']) ?>"></td>
                                <td>
                                    <select name="IDStatusAsignatura">
                                        <?php foreach ($estadosAsignatura as $estado): ?>
                                            <option value="<?= htmlspecialchars($estado['IDStatusAsignatura']) ?>" <?= $estado['IDStatusAsignatura'] == $registro['IDStatusAsignatura'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($estado['Estado']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="IDCreditosComplementarios">
                                        <?php foreach ($creditos as $credito): ?>
                                            <option value="<?= htmlspecialchars($credito['IDCreditosComplementarios']) ?>" <?= $credito['IDCreditosComplementarios'] == $registro['IDCreditosComplementarios'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($credito['Total']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="hidden" name="IDHistorialAcademico_EST" value="<?= htmlspecialchars($registro['IDHistorialAcademico_EST']) ?>">
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