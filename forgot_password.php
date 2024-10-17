<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <style>
        /* Estilos generales de la página */
        body {
            font-family: Arial, sans-serif; /* Fuente de la página */
            margin: 0; /* Eliminar márgenes del body */
            padding: 0; /* Eliminar relleno del body */
            background-image: url('imagenes/fondo.jpg'); /* Imagen de fondo */
            background-size: cover; /* Cubrir todo el fondo */
            background-position: center; /* Centrar la imagen */
            display: flex; /* Usar Flexbox para centrar el contenido */
            justify-content: center; /* Centrar horizontalmente */
            align-items: center; /* Centrar verticalmente */
            height: 100vh; /* Hacer que la página use el 100% de la altura de la pantalla */
            color: white; /* Cambiar color del texto a blanco */
        }

        /* Contenedor del formulario de recuperación */
        .forgot-container {
            background-color: rgba(217, 217, 217, 0.9); /* Fondo gris claro con opacidad */
            padding: 40px; /* Espaciado interno del contenedor */
            border-radius: 10px; /* Bordes redondeados */
            width: 400px; /* Ancho fijo del contenedor */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5); /* Sombra ligera */
        }

        /* Estilo del título */
        .forgot-container h2 {
            text-align: center; /* Centrar el título */
        }

        /* Grupo de entrada para el campo de correo */
        .input-group {
            margin-bottom: 15px; /* Espacio entre campos */
        }

        .input-group label {
            display: block; /* Mostrar el label como un bloque */
            font-weight: bold; /* Texto en negrita */
        }

        .input-group input {
            width: 100%; /* Campo de entrada toma todo el ancho del contenedor */
            padding: 10px; /* Espaciado interno del campo */
            margin-top: 5px; /* Espacio entre el label y el campo */
            border-radius: 5px; /* Bordes redondeados */
            border: 1px solid #ccc; /* Borde gris claro */
        }

        /* Estilo del botón */
        .forgot-container button {
            width: 100%; /* Botón toma todo el ancho del contenedor */
            padding: 10px; /* Espaciado interno */
            background-color: #007bff; /* Color de fondo azul */
            color: white; /* Color del texto blanco */
            border: none; /* Sin borde */
            border-radius: 5px; /* Bordes redondeados */
            cursor: pointer; /* Cambia el cursor a una mano al pasar sobre el botón */
        }

        /* Efecto hover para el botón */
        .forgot-container button:hover {
            background-color: #0056b3; /* Color de fondo azul más oscuro al pasar el cursor */
        }

        /* Enlace para volver al inicio de sesión */
        .forgot-container a {
            color: #007bff; /* Color del enlace */
            text-decoration: none; /* Sin subrayado */
            display: block; /* Mostrar como bloque */
            text-align: center; /* Centrar el texto */
            margin-top: 10px; /* Espacio encima del enlace */
        }

        /* Efecto hover para el enlace */
        .forgot-container a:hover {
            text-decoration: underline; /* Subrayar al pasar el cursor */
        }
    </style>
</head>
<body>

    <div class="forgot-container">
        <h2>Recuperar Contraseña</h2>
        <form action="reset_password.php" method="POST"> <!-- Enviar datos a reset_password.php -->
            <div class="input-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required> <!-- Campo para correo -->
            </div>
            <button type="submit">Enviar</button> <!-- Botón para enviar -->
        </form>

        <a href="index.php">Volver al Inicio de Sesión</a> <!-- Enlace para regresar -->
    </div>

</body>
</html>
