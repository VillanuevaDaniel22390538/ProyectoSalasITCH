<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Datos Personales</title>
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
            max-width: 800px;
            margin: auto;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
        }
        .container h1 {
            color: #ffcc00; /* Color dorado para el título */
            text-align: center;
            margin-bottom: 20px;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            font-weight: bold;
        }
        .input-group input,
        .input-group textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
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
            transition: background-color 0.3s;
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
            const idDocente = document.getElementById('idDocente').value;
            const curp = document.getElementById('curp').value;
            const rfc = document.getElementById('rfc').value;

            const idDocenteRegex = /^\d{10}$/;
            const curpRegex = /^[A-Z0-9]{18}$/;
            const rfcRegex = /^[A-Z0-9]{13}$/;

            if (!idDocenteRegex.test(idDocente)) {
                alert('El ID Docente debe tener exactamente 10 dígitos.');
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
    <h1>Añadir Datos Personales</h1> 
    <form action="guardar_datos_personales.php" method="POST" onsubmit="return validateForm()"> 
        <?php 
        if (isset($_GET['idUsuario']) && !empty($_GET['idUsuario'])) { 
            $idUsuario = htmlspecialchars($_GET['idUsuario']); 
            echo '<input type="hidden" id="idUsuario" name="idUsuario" value="' . $idUsuario . '">'; 
            } else { 
                die("Error: idUsuario no está definido en la URL."); 
                } 
                ?>
            <div class="form-row">
                <div class="input-group">
                    <label for="idDocente">ID Docente:</label>
                    <input type="text" id="idDocente" name="idDocente" required>
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
        </form>
    </div>
</body>
</html>
