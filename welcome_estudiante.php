<?php
session_start(); // Inicia la sesión para almacenar datos del usuario

// Verificar si el nombre del estudiante está definido en la sesión
if (isset($_SESSION['username'])) {
    $nombreEstudiante = $_SESSION['username'];
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
    <title>Bienvenido Estudiante</title>
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
            position: relative; /* Posicionamiento relativo para el botón de cerrar sesión */
        }

        .container h1 {
            color: #ffcc00; /* Color dorado para el título */
        }

        .container a {
            display: block; /* Muestra el enlace como bloque */
            margin: 10px 0; /* Espacio entre enlaces */
            padding: 10px; /* Espaciado interno */
            background-color: #007bff; /* Color de fondo azul */
            color: white; /* Color del texto blanco */
            text-decoration: none; /* Sin subrayado */
            border-radius: 5px; /* Bordes redondeados */
            transition: background-color 0.3s;
            text-align: left; /* Alinea el texto a la izquierda */
        }

        .container a:hover {
            background-color: #0056b3; /* Color de fondo azul más oscuro al pasar el cursor */
        }

        .container a img {
            vertical-align: middle; /* Alinea los iconos verticalmente en el medio */
            margin-right: 8px; /* Espacio entre el icono y el texto */
            width: 24px; /* Ajusta el ancho de la imagen */
            height: 24px; /* Ajusta la altura de la imagen */
        }

        .logout-button {
            position: absolute; /* Posicionamiento absoluto para el botón de cerrar sesión */
            top: 10px; /* Espacio desde la parte superior */
            right: 10px; /* Espacio desde la derecha */
            background-color: #ff0000; /* Color de fondo rojo */
            color: white; /* Color del texto blanco */
            padding: 10px; /* Espaciado interno */
            border: none; /* Sin borde */
            border-radius: 5px; /* Bordes redondeados */
            cursor: pointer; /* Cambia el cursor a una mano al pasar sobre el botón */
            transition: background-color 0.3s;
        }

        .logout-button:hover {
            background-color: #cc0000; /* Color de fondo rojo más oscuro al pasar el cursor */
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
    <div class="container">
        <h1>Bienvenido Mapache! <span id="nombre-usuario"><?php echo $nombreEstudiante; ?></span></h1>
        <a href="prestar_computadora.php"><img src="imagenes/prestar.png" alt="Prestar Computadora"> Prestar Computadora</a>
        <a href="ver_informacion.php"><img src="imagenes/informacion.png" alt="Ver Mi Información"> Ver Mi Información</a>
        <a href="ver_estado_solicitud.php"><img src="imagenes/estado.png" alt="Ver Estado de la Solicitud"> Ver Estado de la Solicitud</a>
        <button class="logout-button" onclick="location.href='logout.php'">Cerrar Sesión</button>
    </div>

    <div class="footer">
        &copy; 2024 Administración del Préstamo de Salas de Cómputo. Todos los derechos reservados.
    </div>
</body>
</html>
