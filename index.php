<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
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

        .login-container {
            background-color: rgba(0, 0, 0, 0.7); /* Fondo semitransparente */
            padding: 40px; /* Espaciado interno del contenedor */
            border-radius: 10px; /* Bordes redondeados */
            width: 400px; /* Ancho fijo del contenedor */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5); /* Sombra ligera */
        }

        .login-container h2 {
            text-align: center; /* Centra el título */
            color: #ffcc00; /* Color dorado para el título */
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

        .login-container button {
            width: 100%; /* Botón toma todo el ancho del contenedor */
            padding: 10px; /* Espaciado interno */
            background-color: #007bff; /* Color de fondo azul */
            color: white; /* Color del texto blanco */
            border: none; /* Sin borde */
            border-radius: 5px; /* Bordes redondeados */
            cursor: pointer; /* Cambia el cursor a una mano al pasar sobre el botón */
            transition: background-color 0.3s;
        }

        .login-container button:hover {
            background-color: #0056b3; /* Color de fondo azul más oscuro al pasar el cursor */
        }

        .login-container a {
            color: #007bff; /* Color del enlace */
            text-decoration: none; /* Sin subrayado */
            display: block; /* Muestra el enlace como bloque */
            text-align: center; /* Centra el texto del enlace */
            margin-top: 10px; /* Espacio encima del enlace */
        }

        .login-container a:hover {
            text-decoration: underline; /* Subraya el enlace al pasar el cursor */
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

    <div class="login-container">
        <h2>Administración del Préstamo de Salas de Cómputo</h2>

        <form action="login_process.php" method="POST">
            <div class="input-group">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="input-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit">Acceder</button>
        </form>

        <a href="register.php">¿No tienes cuenta? Regístrate</a>
        <a href="forgot_password.php">¿Olvidaste tu contraseña?</a>
    </div>

    <div class="footer">
        &copy; 2024 Administración del Préstamo de Salas de Cómputo. Todos los derechos reservados.
    </div>

</body>
</html>
