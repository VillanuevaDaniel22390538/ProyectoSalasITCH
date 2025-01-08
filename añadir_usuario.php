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
        $nombreUsuario = $_POST['nombreUsuario'];

        // Validar que el campo solo contiene letras
        if (!preg_match("/^[a-zA-Z]+$/", $nombreUsuario)) {
            $_SESSION['mensaje_error'] = "¡El nombre del usuario solo debe contener letras!";
        } else {
            $stmt = $conn->prepare("INSERT INTO TipoDeUsuarios (NombreUsuario) VALUES (?)");
            $stmt->execute([$nombreUsuario]);

            $_SESSION['mensaje_exito'] = "¡Usuario añadido exitosamente!";
        }
        header("Location: añadir_usuario.php"); // Redirige a la misma página para mostrar el mensaje
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
    <title>Añadir Usuario</title>
    <style>
        body {
            font-family: Arial, 'Times New Roman', Times, serif;
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
            background-color: rgba(222, 150, 26, 0.8);
            padding: 40px;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            text-align: center;
        }
        .container h1 {
            color:rgb(19, 47, 232);
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
        /*Botón de regreso al menú detalles*/
        .back-button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color:rgb(13, 28, 199);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }
        .back-button:hover {
            background-color: #218838;
            transform: scale(1.05);
        }
        .mensaje-exito, .mensaje-error {
            margin-bottom: 20px;
            padding: 10px;
            color: white;
            border-radius: 5px;
        }
        .mensaje-exito {
            background-color: #28a745;
        }
        .mensaje-error {
            background-color: #dc3545;
        }
    </style>
    <script>
        function validarLetras(input) {
            var nombreuseregex = /^[a-zA-Z]+$/;
            if (!nombreuseregex.test(input.value)) {
                input.setCustomValidity("Solo se permiten letras.");
            } else {
                input.setCustomValidity("");
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Añadir Usuario</h1>
        <?php
        if (isset($_SESSION['mensaje_exito'])) {
            echo "<div class='mensaje-exito'>{$_SESSION['mensaje_exito']}</div>";
            unset($_SESSION['mensaje_exito']);
        }
        if (isset($_SESSION['mensaje_error'])) {
            echo "<div class='mensaje-error'>{$_SESSION['mensaje_error']}</div>";
            unset($_SESSION['mensaje_error']);
        }
        ?>
        <form method="POST">
            <div class="form-group">
                <label for="nombreUsuario">Nombre del Usuario</label>
                <input type="text" id="nombreUsuario" name="nombreUsuario" required oninput="validarLetras(this)">
            </div>
            <div class="form-group">
                <button type="submit">Añadir</button>
            </div>
        </form>
        <button class="back-button" onclick="location.href='usuario_detalle.php?tipo=usuario_general'">
            &#x2190; Regresar
        </button>
    </div>
</body>
</html>
