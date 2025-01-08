<?php
session_start(); // Inicia la sesión para almacenar datos del usuario

// Configuración de conexión a la base de datos
$servername = "localhost";
$dbname = "ProyectoSalasITCH";
$username = "sa";
$password = "0103";

try {
    // Conectar a SQL Server usando PDO
    $conn = new PDO("sqlsrv:Server=$servername;Database=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Obtener el ID del docente desde la sesión
$idDocente = $_SESSION['idDocente'];

// Consulta para obtener los datos personales del docente
$stmt = $conn->prepare("SELECT * FROM Docente WHERE IDDocente = ?");
$stmt->execute([$idDocente]);
$docente = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Datos Personales</title>
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
            background-color: #f9f9f9;
            color: #333;
        }
        .input-group input[readonly],
        .input-group textarea[readonly] {
            background-color: #e9e9e9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Datos Personales</h1>
        <div class="form-row">
            <div class="input-group">
                <label for="idDocente">ID Docente:</label>
                <input type="text" id="idDocente" name="idDocente" readonly value="<?php echo $docente['IDDocente']; ?>">
            </div>
            <div class="input-group">
                <label for="nombres">Nombres:</label>
                <input type="text" id="nombres" name="nombres" readonly value="<?php echo $docente['Nombres']; ?>">
            </div>
            <div class="input-group">
                <label for="primerApellido">Primer Apellido:</label>
                <input type="text" id="primerApellido" name="primerApellido" readonly value="<?php echo $docente['PrimerApellido']; ?>">
            </div>
            <div class="input-group">
                <label for="segundoApellido">Segundo Apellido:</label>
                <input type="text" id="segundoApellido" name="segundoApellido" readonly value="<?php echo $docente['SegundoApellido']; ?>">
            </div>
        </div>
        <div class="form-row">
            <div class="input-group">
                <label for="fechaNacimiento">Fecha de Nacimiento:</label>
                <input type="date" id="fechaNacimiento" name="fechaNacimiento" readonly value="<?php echo $docente['FechaNacimiento']; ?>">
            </div>
            <div class="input-group">
                <label for="curp">CURP:</label>
                <input type="text" id="curp" name="curp" readonly value="<?php echo $docente['CURP']; ?>">
            </div>
            <div class="input-group">
                <label for="rfc">RFC:</label>
                <input type="text" id="rfc" name="rfc" readonly value="<?php echo $docente['RFC']; ?>">
            </div>
            <div class="input-group">
            <label for="numeroCelular">Número de Celular:</label>
                <input type="text" id="numeroCelular" name="numeroCelular" readonly value="<?php echo $docente['NumeroCelular']; ?>">
            </div>
        </div>
        <div class="form-row">
            <div class="input-group">
                <label for="telefonoCasa">Teléfono de Casa:</label>
                <input type="text" id="telefonoCasa" name="telefonoCasa" readonly value="<?php echo $docente['TelefonoCasa']; ?>">
            </div>
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" readonly value="<?php echo $docente['Email']; ?>">
            </div>
            <div class="input-group">
                <label for="calle">Calle:</label>
                <input type="text" id="calle" name="calle" readonly value="<?php echo $docente['Calle']; ?>">
            </div>
            <div class="input-group">
                <label for="interseccionPrimera">Intersección Primera:</label>
                <input type="text" id="interseccionPrimera" name="interseccionPrimera" readonly value="<?php echo $docente['InterseccionPrimera']; ?>">
            </div>
        </div>
        <div class="form-row">
            <div class="input-group">
                <label for="interseccionSegunda">Intersección Segunda:</label>
                <input type="text" id="interseccionSegunda" name="interseccionSegunda" readonly value="<?php echo $docente['InterseccionSegunda']; ?>">
            </div>
            <div class="input-group">
                <label for="numExterior">Número Exterior:</label>
                <input type="text" id="numExterior" name="numExterior" readonly value="<?php echo $docente['NumExterior']; ?>">
            </div>
            <div class="input-group">
                <label for="numInterior">Número Interior:</label>
                <input type="text" id="numInterior" name="numInterior" readonly value="<?php echo $docente['NumInterior']; ?>">
            </div>
            <div class="input-group">
                <label for="codigoPostal">Código Postal:</label>
                <input type="text" id="codigoPostal" name="codigoPostal" readonly value="<?php echo $docente['CodigoPostal']; ?>">
            </div>
        </div>
        <div class="form-row">
            <div class="input-group">
                <label for="colonia">Colonia:</label>
                <input type="text" id="colonia" name="colonia" readonly value="<?php echo $docente['Colonia']; ?>">
            </div>
            <div class="input-group">
                <label for="localidad">Localidad:</label>
                <input type="text" id="localidad" name="localidad" readonly value="<?php echo $docente['Localidad']; ?>">
            </div>
            <div class="input-group">
                <label for="municipio">Municipio:</label>
                <input type="text" id="municipio" name="municipio" readonly value="<?php echo $docente['Municipio']; ?>">
            </div>
            <div class="input-group">
                <label for="estado">Estado:</label>
                <input type="text" id="estado" name="estado" readonly value="<?php echo $docente['Estado']; ?>">
            </div>
        </div>
    </div>
</body>
</html>