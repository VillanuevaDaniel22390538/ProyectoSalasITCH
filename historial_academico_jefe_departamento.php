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

        // Obtener historial académico del jefe de departamento
        $stmt = $pdo->prepare("SELECT * FROM InformacionAcademicaJefeDeDepartamento WHERE IDJefeDeDepartamento = ?");
        $stmt->execute([$IDJefeDeDepartamento]);
        $historial = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$historial) {
            $mensaje = "No se encontró historial académico para el jefe de departamento.";
        }
    } elseif (isset($_POST["editar"])) {
        $IDInformacionAcademica_JD = $_POST["IDInformacionAcademica_JD"];
        $CorreoInstitucional = $_POST["CorreoInstitucional"];
        $IDGrado = $_POST["IDGrado"];
        $IDDepartamentoAcademico = $_POST["IDDepartamentoAcademico"];

        // Actualizar historial académico
        $stmt = $pdo->prepare("UPDATE InformacionAcademicaJefeDeDepartamento SET CorreoInstitucional = ?, IDGrado = ?, IDDepartamentoAcademico = ? WHERE IDInformacionAcademica_JD = ?");
        $stmt->execute([$CorreoInstitucional, $IDGrado, $IDDepartamentoAcademico, $IDInformacionAcademica_JD]);
        $mensaje = "Historial académico actualizado exitosamente.";
    } elseif (isset($_POST["borrar"])) {
        $IDInformacionAcademica_JD = $_POST["IDInformacionAcademica_JD"];

        // Borrar historial académico
        $stmt = $pdo->prepare("DELETE FROM InformacionAcademicaJefeDeDepartamento WHERE IDInformacionAcademica_JD = ?");
        $stmt->execute([$IDInformacionAcademica_JD]);
        $mensaje = "Historial académico borrado exitosamente.";
    }
}

// Obtener lista de jefes de departamento
$jefes = $pdo->query("SELECT IDJefeDeDepartamento, Nombres, PrimerApellido, SegundoApellido FROM JefeDeDepartamento")->fetchAll(PDO::FETCH_ASSOC);

// Obtener lista de grados académicos
$grados = $pdo->query("SELECT IDGrado, Nivel FROM GradoAcademico")->fetchAll(PDO::FETCH_ASSOC);

// Obtener lista de departamentos académicos
$departamentos = $pdo->query("SELECT IDDepartamentoAcademico, NombreDepartamento FROM DepartamentoAcademico")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial Académico Jefe de Departamento</title>
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
        <div class="title">Historial Académico Jefe de Departamento</div>
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
        <?php if (isset($historial) && $historial): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Correo Institucional</th>
                        <th>Grado</th>
                        <th>Departamento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($historial as $registro): ?>
                        <tr>
                            <form method="POST">
                                <td><?= htmlspecialchars($registro['IDInformacionAcademica_JD']) ?></td>
                                <td><input type="text" name="CorreoInstitucional" value="<?= htmlspecialchars($registro['CorreoInstitucional']) ?>"></td>
                                <td>
                                    <select name="IDGrado">
                                        <?php foreach ($grados as $grado): ?>
                                            <option value="<?= htmlspecialchars($grado['IDGrado']) ?>" <?= $grado['IDGrado'] == $registro['IDGrado'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($grado['Nivel']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="IDDepartamentoAcademico">
                                        <?php foreach ($departamentos as $departamento): ?>
                                            <option value="<?= htmlspecialchars($departamento['IDDepartamentoAcademico']) ?>" <?= $departamento['IDDepartamentoAcademico'] == $registro['IDDepartamentoAcademico'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($departamento['NombreDepartamento']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="hidden" name="IDInformacionAcademica_JD" value="<?= htmlspecialchars($registro['IDInformacionAcademica_JD']) ?>">
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