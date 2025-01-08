<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Datos Personales - Jefe de Departamento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
            margin: auto;
        }
        .container h1 {
            color: #007bff;
            text-align: center;
            margin-bottom: 20px;
        }
        .input-group {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }
        .input-group label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .input-group input,
        .input-group textarea {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
        }
        .container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }
        .container button:hover {
            background-color: #0056b3;
        }
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .form-row .input-group {
            flex: 1;
            min-width: 200px;
        }
    </style>
    <script>
        function validateForm() {
            const idJefe = document.getElementById('idJefe').value;
            const curp = document.getElementById('curp').value;
            const rfc = document.getElementById('rfc').value;

            const idJefeRegex = /^\d+$/;
            const curpRegex = /^[A-Z0-9]{18}$/;
            const rfcRegex = /^[A-Z0-9]{13}$/;

            if (!idJefeRegex.test(idJefe)) {
                alert('El ID Jefe debe ser un número.');
                return false;
            }

            if (!curpRegex.test(curp)) {
                alert('La CURP debe tener exactamente 18 caracteres alfanuméricos en mayúsculas.');
                return false;
            }

            if (!rfcRegex.test(rfc)) {
                alert('El RFC debe tener exactamente 13 caracteres alfanuméricos en mayúsculas.');
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Añadir Datos Personales - Jefe de Departamento</h1>
        <form action="guardar_datos_personales_jefe.php" method="POST" onsubmit="return validateForm()">
            <div class="form-row">
                <div class="input-group">
                    <label for="idJefe">ID Jefe:</label>
                    <input type="text" id="idJefe" name="idJefe" required>
                </div>
                <div class="input-group">
                    <label for="nombres">Nombres:</label>
                    <input type="text" id="nombres" name="nombres" required>
                </div>
                <div class="input-group">
                    <label for="primerApellido">Primer Apellido:</label>
                    <input type="text" id="primerApellido" name="primerApellido" required>
                </div>
                <div class="input-group">
                    <label for="segundoApellido">Segundo Apellido:</label>
                    <input type="text" id="segundoApellido" name="segundoApellido" required>
                </div>
            </div>
            <div class="form-row">
                <div class="input-group">
                    <label for="fechaNacimiento">Fecha de Nacimiento:</label>
                    <input type="date" id="fechaNacimiento" name="fechaNacimiento" required>
                </div>
                <div class="input-group">
                    <label for="curp">CURP:</label>
                    <input type="text" id="curp" name="curp" required>
                </div>
                <div class="input-group">
                    <label for="rfc">RFC:</label>
                    <input type="text" id="rfc" name="rfc" required>
                </div>
                <div class="input-group">
                    <label for="numeroCelular">Número de Celular:</label>
                    <input type="text" id="numeroCelular" name="numeroCelular" required>
                </div>
            </div>
            <div class="form-row">
                <div class="input-group">
                    <label for="telefonoCasa">Teléfono de Casa:</label>
                    <input type="text" id="telefonoCasa" name="telefonoCasa">
                </div>
                <div class="input-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="calle">Calle:</label>
                    <input type="text" id="calle" name="calle" required>
                </div>
                <div class="input-group">
                    <label for="interseccionPrimera">Intersección Primera:</label>
                    <input type="text" id="interseccionPrimera" name="interseccionPrimera" required>
                </div>
            </div>
            <div class="form-row">
                <div class="input-group">
                    <label for="interseccionSegunda">Intersección Segunda:</label>
                    <input type="text" id="interseccionSegunda" name="interseccionSegunda" required>
                </div>
                <div class="input-group">
                    <label for="numExterior">Número Exterior:</label>
                    <input type="text" id="numExterior" name="numExterior" required>
                </div>
                <div class="input-group">
                    <label for="numInterior">Número Interior:</label>
                    <input type="text" id="numInterior" name="numInterior">
                </div>
                <div class="input-group">
                    <label for="codigoPostal">Código Postal:</label>
                    <input type="text" id="codigoPostal" name="codigoPostal" required>
                </div>
            </div>
            <div class="form-row">
                <div class="input-group">
                    <label for="colonia">Colonia:</label>
                    <input type="text" id="colonia" name="colonia">
                </div>
                <div class="input-group">
                    <label for="localidad">Localidad:</label>
                    <input type="text" id="localidad" name="localidad">
                </div>
                <div class="input-group">
                    <label for="municipio">Municipio:</label>
                    <input type="text" id="municipio" name="municipio">
                </div>
                <div class="input-group">
                    <label for="estado">Estado:</label>
                    <input type="text" id="estado" name="estado">
                </div>
            </div>
            <button type="submit">Guardar Datos</button>
            <button type="button" onclick="window.location.href='añadir_datos.php'">Regresar</button> <!-- Botón para regresar -->
        </form>
    </div>
</body>
</html>