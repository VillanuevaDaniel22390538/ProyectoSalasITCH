<?php
session_start();

// Verifica si el usuario está autenticado y es administrador
if (!isset($_SESSION['username']) || $_SESSION['tipo_usuario'] != 5) {
    header("Location: index.php");
    exit();
}

// Configuración de conexión a la base de datos
$servername = "localhost";
$dbname = "ProyectoSalasITCH";
$dbusername = "sa";
$dbpassword = "0103";

try {
    $conn = new PDO("sqlsrv:Server=$servername;Database=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['nombre'];

        $stmt = $conn->prepare("INSERT INTO TipoSangre (NombreTipoSangre) VALUES (?)");
        $stmt->execute([$nombre]);

        header("Location: gestion_medica.php");
        exit();
    }
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Tipo de Sangre</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('imagenes/fondo.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white;
        }
        .container {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 40px;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            text-align: center;
        }
        .container h1 {
            color: #ffcc00;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
        }
        .form-group button {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }
        .form-group button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        .back-button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }
        .back-button:hover {
            background-color: #218838;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Agregar Tipo de Sangre</h1>
        <form method="POST">
            <div class="form-group">
                <label for="nombre">Nombre del Tipo de Sangre</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <button type="submit">Agregar</button>
            </div>
        </form>
        <button class="back-button" onclick="location.href='gestion_medica.php'">
            <i class="fas fa-arrow-left"></i> Regresar
        </button>
    </div>
</body>
</html>