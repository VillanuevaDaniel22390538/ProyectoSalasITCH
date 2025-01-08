<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Cuenta</title>
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
        .register-container {
            background-color: rgba(0, 0, 0, 0.7); /* Fondo semitransparente */
            padding: 40px;
            border-radius: 10px;
            width: 400px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
        }
        .register-container h2 {
            text-align: center;
            color: #ffcc00; /* Color dorado para el título */
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            font-weight: bold;
        }
        .input-group input,
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .register-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .register-container button:hover {
            background-color: #0056b3;
        }
        .register-container a {
            color: #007bff;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 10px;
        }
        .register-container a:hover {
            text-decoration: underline;
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
    <script>
        function validateForm() {
            const username = document.getElementById('username').value;
            const email = document.getElementById('email').value;
            const emailConfirm = document.getElementById('emailConfirm').value;
            const password = document.getElementById('password').value;
            const passwordConfirm = document.getElementById('passwordConfirm').value;
            const usernameRegex = /^[a-zA-Z]+$/;
            const passwordRegex = /^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;

            if (!usernameRegex.test(username)) {
                alert('El nombre de usuario solo debe contener letras.');
                return false;
            }

            if (email !== emailConfirm) {
                alert('Los correos electrónicos no coinciden.');
                return false;
            }

            if (!passwordRegex.test(password)) {
                alert('La contraseña debe tener al menos una mayúscula y un número.');
                return false;
            }

            if (password !== passwordConfirm) {
                alert('Las contraseñas no coinciden.');
                return false;
            }

            return true;
        }
    </script>
</head>


<body>

    <div class="register-container">
        <h2>Registro de Cuenta</h2>

        <form action="register_process.php" method="POST" onsubmit="return validateForm()">
            <div class="input-group">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="input-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="input-group">
                <label for="emailConfirm">Confirmar Correo Electrónico:</label>
                <input type="email" id="emailConfirm" name="emailConfirm" required>
            </div>

            <div class="input-group">
                <label for="role">¿Qué eres?:</label>
                <select class="input-group select" id="role" name="tipo_usuario" required>
                    <option value="">Selecciona una opción</option>
                    <option value="1">Estudiante</option>
                    <option value="2">Docente</option>
                    <option value="3">Coordinador</option>
                    <option value="4">JefeDepartamento</option>
                    <option value="5">Administrador</option>
                    <option value="6">Personal</option>
                    <option value="7">Encargado</option>
                </select>
            </div>

            <div class="input-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="input-group">
                <label for="passwordConfirm">Confirmar Contraseña:</label>
                <input type="password" id="passwordConfirm" name="passwordConfirm" required>
            </div>

            <button type="submit">Crear Cuenta</button>
        </form>

        <a href="index.php">Volver al Inicio de Sesión</a>
    </div>

    <div class="footer">
        &copy; 2024 Administración del Préstamo de Salas de Cómputo. Todos los derechos reservados.
    </div>

</body>


</html>