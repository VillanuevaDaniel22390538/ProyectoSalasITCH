<?php
session_start(); // Inicia la sesión

// Verifica si el usuario está autenticado y es administrador
if (!isset($_SESSION['username']) || $_SESSION['tipo_usuario'] != 5) {
    header("Location: index.php"); // Redirige al inicio de sesión si no está autenticado o no es administrador
    exit();
}
$username = $_SESSION['username']; // Obtiene el nombre del usuario de la sesión

// Configuración de conexión a la base de datos
$servername = "localhost";
$dbname = "ProyectoSalasITCH";
$dbusername = "sa";
$dbpassword = "0103";

try {
    // Conectar a SQL Server usando PDO
    $conn = new PDO("sqlsrv:Server=$servername;Database=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener datos de la tabla solicitudes_prestamo
    $stmt = $conn->prepare("SELECT * FROM solicitudes_prestamo");
    $stmt->execute();
    $solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Función para actualizar el estado de la solicitud
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['estado'])) {
    $id = $_POST['id'];
    $estado = $_POST['estado'];

    try {
        $stmt = $conn->prepare("UPDATE solicitudes_prestamo SET estado = ? WHERE id = ?");
        $stmt->execute([$estado, $id]);
        header("Location: gestion_compus_estudiantes.php"); // Redirige para evitar reenvío de formulario
        exit();
    } catch (PDOException $e) {
        die("Error al actualizar el estado: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Computadoras a Estudiantes</title>
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
            background-color: rgba(0, 0, 0, 0.8); /* Fondo semitransparente */
            padding: 40px;
            border-radius: 10px;
            width: 90%;
            max-width: 1000px;
            margin: auto;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            text-align: center;
        }
        .container h1 {
            color: #ffcc00; /* Color dorado para el título */
            margin-bottom: 20px;
        }
        .table-container {
            margin-bottom: 20px;
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
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color:rgb(0, 0, 0);
        }
        .button-group {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
        }
        .button-group button {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }
        .button-group button:hover {
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
    <!-- Enlace a Font Awesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h1>Gestionar Computadoras a Estudiantes</h1>

        <div class="table-container">
            <h2>Solicitudes de Préstamo</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Número de Control</th>
                        <th>Fecha de Solicitud</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($solicitudes as $solicitud): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($solicitud['id']); ?></td>
                            <td><?php echo htmlspecialchars($solicitud['NumeroControl']); ?></td>
                            <td><?php echo htmlspecialchars($solicitud['fecha_solicitud']); ?></td>
                            <td><?php echo htmlspecialchars($solicitud['estado']); ?></td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $solicitud['id']; ?>">
                                    <select name="estado" onchange="this.form.submit()">
                                        <option value="pendiente" <?php if ($solicitud['estado'] == 'pendiente') echo 'selected'; ?>>Pendiente</option>
                                        <option value="aprobada" <?php if ($solicitud['estado'] == 'aprobada') echo 'selected'; ?>>Aprobada</option>
                                        <option value="rechazada" <?php if ($solicitud['estado'] == 'rechazada') echo 'selected'; ?>>Rechazada</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <button class="back-button" onclick="location.href='welcome_administrador.php'">
            <i class="fas fa-arrow-left"></i> Regresar al Inicio
        </button>
    </div>
</body>
</html>