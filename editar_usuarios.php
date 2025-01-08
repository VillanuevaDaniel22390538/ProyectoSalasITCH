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

    // Obtener datos de la tabla TipoDeUsuarios
    $stmt = $conn->prepare("SELECT * FROM TipoDeUsuarios");
    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Editar usuario
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar'])) {
        $id = $_POST['id'];
        $nombreUsuario = $_POST['nombreUsuario'];

        $stmt = $conn->prepare("UPDATE TipoDeUsuarios SET NombreUsuario = ? WHERE TipoDeUsuarioId = ?");
        $stmt->execute([$nombreUsuario, $id]);

        $_SESSION['mensaje_exito'] = "¡Usuario editado exitosamente!";
        header("Location: editar_usuarios.php"); // Redirige a la misma página para mostrar el mensaje
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
    <title>Editar Usuarios</title>
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
            max-width: 1000px;
            margin: auto;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            text-align: center;
        }
        .container h1 {
            color: #ffcc00;
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
            background-color:rgb(18, 17, 17);
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
            background-color: #333;
            color: white;
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
        .back-arrow {
            position: absolute;
            top: 20px; /* Ajusta la posición vertical */
            left: 20px; /* Ajusta la posición horizontal */
            color: yellow;
            text-decoration: none;
            font-size: 24px;
        }
        .mensaje-exito {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
        }
    </style>
    <!-- Enlace a Font Awesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
        <div class="container">
        <h1>Editar Usuarios</h1>
        <?php
        if (isset($_SESSION['mensaje_exito'])) {
            echo "<div class='mensaje-exito'>{$_SESSION['mensaje_exito']}</div>";
            unset($_SESSION['mensaje_exito']);
        }
        ?>
        <div class="table-container">
            <h2>Usuarios</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usuario['NombreUsuario']); ?></td>
                            <td>
                                <button onclick="document.getElementById('editar-form-<?php echo $usuario['TipoDeUsuarioId']; ?>').style.display='block'"><i class="fas fa-edit"></i> Editar</button>
                            </td>
                        </tr>
                        <tr id="editar-form-<?php echo $usuario['TipoDeUsuarioId']; ?>" style="display:none;">
                            <td colspan="2">
                                <form method="POST">
                                    <input type="hidden" name="id" value="<?php echo $usuario['TipoDeUsuarioId']; ?>">
                                    <div class="form-group">
                                        <label for="nombreUsuario">Nombre del Usuario</label>
                                        <input type="text" id="nombreUsuario" name="nombreUsuario" 
                                            value="<?php echo htmlspecialchars($usuario['NombreUsuario']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="editar">Guardar Cambios</button>
                                    </div>
                        
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <button class="back-button" onclick="location.href='usuario_detalle.php?tipo=usuario_general'">
            <i class="fas fa-arrow-left"></i> Regresar
        </button>
    </div>
</body>
</html>

