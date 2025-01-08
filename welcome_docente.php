<?php
session_start(); // Inicia la sesión para almacenar datos del usuario

// Verificar si el nombre del docente está definido en la sesión
if (isset($_SESSION['username'])) {
    $nombreDocente = $_SESSION['username'];
} else {
    // Redirigir al inicio de sesión si no está definido
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido Docente</title>
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
            max-width: 600px;
            text-align: center;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
        }
        .container h1 {
            color: #ffcc00; /* Color dorado para el título */
            margin-bottom: 20px;
        }
        .container p {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .container a {
            display: block;
            margin: 10px 0;
            padding: 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .container a:hover {
            background-color: #0056b3;
        }
        .container button {
            margin-top: 20px;
            padding: 10px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .container button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenido Docente</h1>
        <p>Bienvenido, <?php echo htmlspecialchars($nombreDocente); ?>.</p>
        <a href="reservar_sala.php">Solicitar Reserva de Sala</a>
        <a href="ver_datos_docente.php">Ver Datos</a>
        <a href="ver_reservas.php">Ver Reservas de Salas</a> <!-- Nuevo botón -->
        <button onclick="window.location.href='logout.php'">Cerrar Sesión</button>
    </div>
</body>
</html>
