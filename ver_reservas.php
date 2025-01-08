<?php
session_start(); // Inicia la sesión para almacenar datos del usuario

// Configuración de conexión a la base de datos
$servername = "localhost";
$dbname = "ProyectoSalasITCH";
$username = "sa";
$password = "0103";

try {
    // Conectar a SQL Server usando PDO
    $conn = new PDO("sqlsrv:Server=$servername;Database=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

$reserva = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPrestamo = $_POST['idPrestamo'];

    // Consulta para obtener la reserva por IDPrestamo
    $stmt = $conn->prepare("SELECT IDSala, FechaPrestamo, HoraInicio, HoraFin FROM PrestamoSalas WHERE IDPrestamo = ?");
    $stmt->execute([$idPrestamo]);
    $reserva = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Reservas de Salas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('imagenes/fondo.jpg'); /* Fondo similar al de index */
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white;
        }
        .container {
            background-color: rgba(0, 0, 0, 0.7); /* Fondo semitransparente */
            padding: 40px;
            border-radius: 10px;
            width: 80%;
            max-width: 800px;
            margin: auto;
            text-align: center;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
        }
        .container h1 {
            color: #ffcc00; /* Color dorado para el título */
            margin-bottom: 20px;
        }
        .input-group {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .input-group label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .input-group input {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
            max-width: 300px;
        }
        .container button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px; /* Separar los botones */
            transition: background-color 0.3s;
        }
        .container button:hover {
            background-color: #0056b3;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table th {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ver Reservas de Salas</h1>
        <form method="POST" action="ver_reservas.php">
            <div class="input-group">
                <label for="idPrestamo">Ingresar Número de Reserva:</label>
                <input type="text" id="idPrestamo" name="idPrestamo" required>
            </div>
            <button type="submit">Buscar</button>
        </form>
        <?php if ($reserva): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Sala</th>
                        <th>Fecha</th>
                        <th>Hora de Inicio</th>
                        <th>Hora de Fin</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $reserva['IDSala']; ?></td>
                        <td><?php echo $reserva['FechaPrestamo']; ?></td>
                        <td><?php echo $reserva['HoraInicio']; ?></td>
                        <td><?php echo $reserva['HoraFin']; ?></td>
                    </tr>
                </tbody>
            </table>
        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <p>No se encontró una reserva con el número proporcionado.</p>
        <?php endif; ?>
        <button onclick="window.location.href='welcome_docente.php'">Regresar</button>
    </div>
</body>
</html>
