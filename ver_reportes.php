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

// Obtener los reportes de la base de datos
$stmt = $pdo->prepare("SELECT * FROM Reportes");
$stmt->execute();
$reportes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Reportes</title>
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
            overflow-y: auto;
        }
        .title {
            font-size: 28px;
            margin-bottom: 20px;
            color: #ffcc00;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .back-arrow {
            position: absolute;
            top: 20px;
            left: 20px;
            color: yellow;
            text-decoration: none;
            font-size: 24px;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #ccc;
        }
    </style>
</head>
<body>
    <a href="javascript:history.back()" class="back-arrow">&#x2190;</a>
    <div class="container">
        <div class="title">Reportes de Usuarios</div>
        <?php if (count($reportes) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID Reporte</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reportes as $reporte): ?>
                        <tr>
                            <td><?= htmlspecialchars($reporte['IDReporte']) ?></td>
                            <td><?= htmlspecialchars($reporte['Usuario']) ?></td>
                            <td><?= htmlspecialchars($reporte['Fecha']) ?></td>
                            <td><?= htmlspecialchars($reporte['Descripcion']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay reportes disponibles.</p>
        <?php endif; ?>
    </div>
    <div class="footer">
        &copy; 2024 Proyecto Salas ITCH. Todos los derechos reservados.
    </div>
</body>
</html>