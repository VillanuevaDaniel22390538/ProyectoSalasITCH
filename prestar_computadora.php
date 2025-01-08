<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Préstamo de Computadora</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('imagenes/fondo.JPG'); /* Imagen de fondo */
            background-size: cover; /* La imagen cubre todo el fondo */
            background-position: center; /* Centra la imagen en el fondo */
            display: flex; /* Usa Flexbox para centrar el contenido */
            justify-content: center; /* Centra horizontalmente */
            align-items: center; /* Centra verticalmente */
            height: 100vh; /* Usa el 100% de la altura de la ventana */
            color: white; /* Cambia el color del texto a blanco */
        }

        .container {
            background-color: rgba(0, 0, 0, 0.7); /* Fondo semitransparente */
            padding: 40px; /* Espaciado interno del contenedor */
            border-radius: 10px; /* Bordes redondeados */
            width: 400px; /* Ancho fijo del contenedor */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5); /* Sombra ligera */
            text-align: center; /* Centra el texto */
        }

        .container h1 {
            color: #ffcc00; /* Color dorado para el título */
        }

        .container form {
            display: flex;
            flex-direction: column;
        }

        .container form input[type="text"],
        .container form input[type="date"],
        .container form input[type="submit"] {
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px;
            border: none;
            width: 100%;
        }

        .container form input[type="text"] {
            background-color: #333;
            color: white;
        }

        .container form input[type="date"] {
            background-color: #fff;
            color: #333;
        }

        .container form input[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .container form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            text-align: center;
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.7); /* Fondo semitransparente */
            color: white;
        }
    </style>
</head>
<body>
    <?php
    session_start(); // Inicia la sesión
    if (!isset($_SESSION['NumeroControl'])) {
        echo "Error: No se encontró el número de control en la sesión.";
        exit();
    }
    ?>
    <div class="container">
        <h1>Solicitar Préstamo de Computadora</h1>
        <form action="procesar_solicitud.php" method="POST">
            <label for="NumeroControl">Número de Control:</label>
            <input type="text" id="NumeroControl" name="NumeroControl" value="<?php echo $_SESSION['NumeroControl']; ?>" readonly>

            <label for="fecha_solicitud">Fecha de Solicitud:</label>
            <input type="date" id="fecha_solicitud" name="fecha_solicitud" required>

            <label for="estado">Estado:</label>
            <input type="text" id="estado" name="estado" value="pendiente" readonly>

            <input type="submit" value="Enviar Solicitud">
        </form>
    </div>

    <div class="footer">
        &copy; 2024 Administración del Préstamo de Salas de Cómputo. Todos los derechos reservados.
    </div>
</body>
</html>
