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
        $IDPersonal = $_POST["IDPersonal"];

        // Obtener historial académico del personal
        $stmt = $pdo->prepare("SELECT * FROM InformacionAcademicaPersonal WHERE IDPersonal = ?");
        $stmt->execute([$IDPersonal]);
        $historial = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$historial) {
            $mensaje = "No se encontró historial académico para el personal.";
        }
    } elseif (isset($_POST["editar"])) {
        $IDInformacionAcademica_PER = $_POST["IDInformacionAcademica_PER"];
        $CorreoInstitucional = $_POST["CorreoInstitucional"];
        $IDGrado = $_POST["IDGrado"];
        $IDDepartamentoAcademico = $_POST["IDDepartamentoAcademico"];

        // Actualizar historial académico
        $stmt = $pdo->prepare("UPDATE InformacionAcademicaPersonal SET CorreoInstitucional = ?, IDGrado = ?, IDDepartamentoAcademico = ? WHERE IDInformacionAcademica_PER = ?");
        $stmt->execute([$CorreoInstitucional, $IDGrado, $IDDepartamentoAcademico, $IDInformacionAcademica_PER]);
        $mensaje = "Historial académico actualizado exitosamente.";
    } elseif (isset($_POST["borrar"])) {
        $IDInformacionAcademica_PER = $_POST["IDInformacionAcademica_PER"];

        // Borrar historial académico
        $stmt = $pdo->prepare("DELETE FROM InformacionAcademicaPersonal WHERE IDInformacionAcademica_PER = ?");
        $stmt->execute([$IDInformacionAcademica_PER]);
        $mensaje = "Historial académico borrado exitosamente.";
    }
}

// Obtener lista de personal
$personalList = $pdo->query("SELECT IDPersonal, Nombres, PrimerApellido, SegundoApellido FROM Personal")->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Historial Académico Personal de Laboratorio</title>
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
        <div class="title">Historial Académico Personal de Laboratorio</div>
        <form method="POST">
            <div class="form-group">
                <label for="IDPersonal">ID Personal</label>
                <input type="text" id="IDPersonal" name="IDPersonal">
            </div>
            <div class="form-group">
                <label for="IDPersonalSelect">Seleccionar Personal</label>
                <select id="IDPersonalSelect" name="IDPersonal">
                    <option value="">Seleccione un personal</option>
                    <?php foreach ($personalList as $personal): ?>
                        <option value="<?= htmlspecialchars($personal['IDPersonal']) ?>">
                            <?= htmlspecialchars($personal['Nombres']) ?> <?= htmlspecialchars($personal['PrimerApellido']) ?> <?= htmlspecialchars($personal['SegundoApellido']) ?>
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
                                <td><?= htmlspecialchars($registro['IDInformacionAcademica_PER']) ?></td>
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
                                    <input type="hidden" name="IDInformacionAcademica_PER" value="<?= htmlspecialchars($registro['IDInformacionAcademica_PER']) ?>">
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