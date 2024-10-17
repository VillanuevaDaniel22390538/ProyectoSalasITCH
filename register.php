<!DOCTYPE html>
<html lang="es"> <!-- Define el idioma del documento -->
<head>
    <meta charset="UTF-8"> <!-- Establece la codificación de caracteres a UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Configuración para dispositivos móviles -->
    <title>Registro de Cuenta</title> <!-- Título de la página que se muestra en la pestaña del navegador -->
    <style>
        body {
            font-family: Arial, sans-serif; /* Establece la fuente de la página */
            margin: 0; /* Elimina los márgenes predeterminados del body */
            padding: 0; /* Elimina el relleno predeterminado del body */
            background-image: url('imagenes/fondo.jpg'); /* Imagen de fondo */
            background-size: cover; /* La imagen cubre todo el fondo */
            background-position: center; /* Centra la imagen en el fondo */
            display: flex; /* Usa Flexbox para centrar el contenido */
            justify-content: center; /* Centra horizontalmente */
            align-items: center; /* Centra verticalmente */
            height: 100vh; /* Usa el 100% de la altura de la ventana */
            color: white; /* Cambia el color del texto a blanco */
        }

        .register-container {
            background-color: rgba(217, 217, 217, 0.9); /* Fondo gris claro con opacidad */
            padding: 40px; /* Espaciado interno del contenedor */
            border-radius: 10px; /* Bordes redondeados */
            width: 400px; /* Ancho fijo del contenedor */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5); /* Sombra ligera */
        }

        .register-container h2 {
            text-align: center; /* Centra el título */
        }

        .input-group {
            margin-bottom: 15px; /* Espacio entre grupos de entrada */
        }

        .input-group label {
            display: block; /* Muestra el label como un bloque */
            font-weight: bold; /* Establece el texto del label en negrita */
        }

        .input-group input {
            width: 100%; /* Campo de entrada toma todo el ancho del contenedor */
            padding: 10px; /* Espaciado interno del campo */
            margin-top: 5px; /* Espacio entre el label y el campo */
            border-radius: 5px; /* Bordes redondeados */
            border: 1px solid #ccc; /* Borde gris claro */
        }

        .register-container button {
            width: 100%; /* Botón toma todo el ancho del contenedor */
            padding: 10px; /* Espaciado interno */
            background-color: #007bff; /* Color de fondo azul */
            color: white; /* Color del texto blanco */
            border: none; /* Sin borde */
            border-radius: 5px; /* Bordes redondeados */
            cursor: pointer; /* Cambia el cursor a una mano al pasar sobre el botón */
        }

        .register-container button:hover {
            background-color: #0056b3; /* Color de fondo azul más oscuro al pasar el cursor */
        }

        .register-container a {
            color: #007bff; /* Color del enlace */
            text-decoration: none; /* Sin subrayado */
            display: block; /* Muestra el enlace como bloque */
            text-align: center; /* Centra el texto del enlace */
            margin-top: 10px; /* Espacio encima del enlace */
        }

        .register-container a:hover {
            text-decoration: underline; /* Subraya el enlace al pasar el cursor */
        }
    </style>
</head>
<body>

    <div class="register-container"> <!-- Contenedor principal para el formulario de registro -->
        <h2>Registro de Cuenta</h2> <!-- Título del formulario -->

        <form action="register_process.php" method="POST"> <!-- Formulario que envía datos a register_process.php -->
            <div class="input-group"> <!-- Grupo de entrada para el nombre de usuario -->
                <label for="username">Usuario:</label> <!-- Etiqueta del campo -->
                <input type="text" id="username" name="username" required> <!-- Campo de entrada para el nombre de usuario -->
            </div>

            <div class="input-group"> <!-- Grupo de entrada para el correo electrónico -->
                <label for="email">Correo Electrónico:</label> <!-- Etiqueta del campo -->
                <input type="email" id="email" name="email" required> <!-- Campo de entrada para el correo -->
            </div>

            <div class="input-group"> <!-- Grupo de entrada para la contraseña -->
                <label for="password">Contraseña:</label> <!-- Etiqueta del campo -->
                <input type="password" id="password" name="password" required> <!-- Campo de entrada para la contraseña -->
            </div>

            <button type="submit">Crear Cuenta</button> <!-- Botón para enviar el formulario -->
        </form>

        <!-- Enlace para regresar al inicio de sesión -->
        <a href="index.php">Volver al Inicio de Sesión</a> <!-- Enlace que redirige al inicio de sesión -->
    </div>

</body>
</html>
