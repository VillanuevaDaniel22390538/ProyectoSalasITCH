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

// Obtener lista de encargados de laboratorio
$encargados = $pdo->query("SELECT IDEncargadoLaboratorio, Nombres, PrimerApellido, SegundoApellido FROM EncargadoLaboratorio")->fetchAll(PDO::FETCH_ASSOC);

// Contar el total de encargados
$totalEncargados = count($encargados);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total de Encargados de Laboratorio</title>
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
        .total {
            font-size: 24px;
            margin-bottom: 20px;
            color: #ffcc00;
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
        th {
            background-color: #007bff;
        }
        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1);
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
        <div class="title">Total de Encargados de Laboratorio Registrados</div>
        <div class="total">Total de Encargados: <?= $totalEncargados ?></div>
        <table>
            <thead>
                <tr>
                    <th>ID Encargado</th>
                    <th>Nombres</th>
                    <th>Primer Apellido</th>
                    <th>Segundo Apellido</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($encargados as $encargado): ?>
                    <tr>
                        <td><?= htmlspecialchars($encargado['IDEncargadoLaboratorio']) ?></td>
                        <td><?= htmlspecialchars($encargado['Nombres']) ?></td>
                        <td><?= htmlspecialchars($encargado['PrimerApellido']) ?></td>
                        <td><?= htmlspecialchars($encargado['SegundoApellido']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>