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

// Obtener la lista de docentes
$stmt = $pdo->prepare("SELECT IDDocente, Nombres, PrimerApellido, SegundoApellido FROM Docente");
$stmt->execute();
$docentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$docente = null;
$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["buscar"])) {
        $IDDocente = $_POST["IDDocente"];

        // Obtener datos del docente
        $stmt = $pdo->prepare("SELECT * FROM Docente WHERE IDDocente = ?");
        $stmt->execute([$IDDocente]);
        $docente = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$docente) {
            $mensaje = "Docente no encontrado.";
        }
    } elseif (isset($_POST["confirmar"]) && $_POST["confirmar"] == "1") {
        $IDDocente = $_POST["IDDocente"];
        $password = $_POST["password"];

        // Verificar contraseña (aquí deberías implementar la lógica para verificar la contraseña)
        if ($password === 'admin') {
            // Eliminar registros relacionados
            $pdo->beginTransaction();
            try {
                $pdo->prepare("DELETE FROM PrestamoSalas WHERE IDDocente = ?")->execute([$IDDocente]);
                $pdo->prepare("DELETE FROM InformacionAcademicaDocente WHERE IDDocente = ?")->execute([$IDDocente]);
                $pdo->prepare("DELETE FROM InformacionMedicaDocente WHERE IDDocente = ?")->execute([$IDDocente]);
                $pdo->prepare("DELETE FROM Docente WHERE IDDocente = ?")->execute([$IDDocente]);
                $pdo->commit();
                $mensaje = "Docente y sus registros eliminados exitosamente.";
            } catch (Exception $e) {
                $pdo->rollBack();
                $mensaje = "Error al eliminar el docente: " . $e->getMessage();
            }
        } else {
            $mensaje = "Contraseña incorrecta.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Docente</title>
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
        .form-group select, .form-group input {
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
        <div class="title">Eliminar Docente</div>
        <form method="POST">
            <div class="form-group">
                <label for="IDDocente">Seleccione Docente</label>
                <select id="IDDocente" name="IDDocente" required>
                    <?php foreach ($docentes as $doc): ?>
                        <option value="<?= htmlspecialchars($doc['IDDocente']) ?>" <?= isset($docente) && $docente['IDDocente'] == $doc['IDDocente'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($doc['Nombres'] . ' ' . $doc['PrimerApellido'] . ' ' . $doc['SegundoApellido']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" name="buscar">Buscar</button>
            </div>
        </form>
        <?php if (isset($docente) && $docente): ?>
            <div class="form-group">
                <h3>Datos del Docente</h3>
                <p>ID: <?= htmlspecialchars($docente['IDDocente']) ?></p>
                <p>Nombre: <?= htmlspecialchars($docente['Nombres']) ?> <?= htmlspecialchars($docente['PrimerApellido']) ?> <?= htmlspecialchars($docente['SegundoApellido']) ?></p>
                <form method="POST">
                    <input type="hidden" name="IDDocente" value="<?= htmlspecialchars($docente['IDDocente']) ?>">
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="confirmar" value="1">Borrar</button>
                    </div>
                </form>
            </div>
        <?php endif; ?>
        <?php if (isset($mensaje)): ?>
            <div class="form-group">
                <p><?= htmlspecialchars($mensaje) ?></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>