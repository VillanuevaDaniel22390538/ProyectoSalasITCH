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

    // Eliminar usuario
    if (isset($_GET['eliminar'])) {
        $id = $_GET['eliminar'];

        $stmt = $conn->prepare("DELETE FROM TipoDeUsuarios WHERE TipoDeUsuarioId = ?");
        $stmt->execute([$id]);

        $_SESSION['mensaje_exito'] = "¡Usuario eliminado exitosamente!";
        header("Location: eliminar_usuarios.php"); // Redirige a la misma página para mostrar el mensaje
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
    <title>Eliminar Usuarios</title>
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
            background-color: rgba(20, 73, 219, 0.8);
            padding: 40px;
            border-radius: 10px;
            width: 90%;
            max-width: 1000px;
            margin: auto;
            box-shadow: 0 0 15px rgba(234, 226, 14, 0.5);
            text-align: center;
        }
        .container h1 {
            color:rgb(222, 237, 18);
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
            background-color:rgb(47, 141, 241);
            color: white;
        }
        tr:nth-child(even) {
            background-color:rgb(229, 150, 53);
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
        .mensaje-exito {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color:rgb(222, 78, 21);
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 10px;
            text-align: center;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .modal-button {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }
        .modal-button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        .cancel-button {
            background-color: #dc3545;
        }
        .cancel-button:hover {
            background-color: #c82333;
        }
    </style>
    <!-- Enlace a Font Awesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        function confirmarEliminacion(id) {
            var modal = document.getElementById("modalConfirmacion");
            var eliminarBtn = document.getElementById("eliminarBtn");
            eliminarBtn.href = "eliminar_usuarios.php?eliminar=" + id;
            modal.style.display = "flex";
        }

        function cerrarModal() {
            var modal = document.getElementById("modalConfirmacion");
            modal.style.display = "none";
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Eliminar Usuarios</h1>
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
                        <th>ID</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usuario['TipoDeUsuarioId']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['NombreUsuario']); ?></td>
                            <td>
                                <button class="modal-button" onclick="confirmarEliminacion(<?php echo $usuario['TipoDeUsuarioId']; ?>)"><i class="fas fa-trash-alt"></i> Eliminar</button>
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

    <!-- Modal de confirmación -->
    <div id="modalConfirmacion" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal()">&times;</span>
            <h2>¿Seguro en querer eliminar este usuario?</h2>
            <a id="eliminarBtn" class="modal-button">Eliminar</a>
            <button class="modal-button cancel-button" onclick="cerrarModal()">Cerrar</button>
        </div>
    </div>
</body>
</html>
