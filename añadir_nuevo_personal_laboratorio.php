<?php
$serverName = "localhost";
$database = "ProyectoSalasITCH";
$username = "sa";
$password = "0103";

try {
    $pdo = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión Exitosa";
} catch (PDOException $e) {
    echo "Error en la conexión: " . $e->getMessage();
    exit();
}

// Obtener los tipos de usuario
$sql_tipos = "SELECT TipoDeUsuarioId, NombreUsuario FROM TipoDeUsuarios";
$stmt_tipos = $pdo->query($sql_tipos);
$tipos_usuarios = $stmt_tipos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Nuevo Personal de Laboratorio</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-image: url('imagenes/fondo.jpg'); /* Fondo similar al de index */
            background-size: cover;
            background-position: center;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: rgba(0, 0, 0, 0.7); /* Fondo semitransparente */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            text-align: center;
            width: 90%;
            max-width: 800px;
            color: white;
        }
        .title {
            font-size: 28px;
            margin-bottom: 20px;
            color: #ffcc00; /* Color dorado para el título */
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
        }
        .form-group button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
        .back-arrow {
    position: absolute;
    top: 20px; /* Ajusta la posición vertical */
    left: 20px; /* Ajusta la posición horizontal */
    color: yellow;
    text-decoration: none;
    font-size: 24px;
}
    </style>
</head>
<body>
<a href="javascript:history.back()" class="back-arrow">&#x2190; </a>

    <div class="container">
        <div class="title">Añadir Nuevo Personal de Laboratorio</div>
        <form action="guardar_personal_laboratorio.php" method="POST">
            <div class="form-group">
                <label for="IDPersonal">ID Personal</label>
                <input type="text" id="IDPersonal" name="IDPersonal" required>
            </div>
            <div class="form-group">
                <label for="NombreUsuario">Nombre de Usuario</label>
                <input type="text" id="NombreUsuario" name="NombreUsuario" required>
            </div>
            <div class="form-group">
                <label for="emailUsuario">Email del Usuario</label>
                <input type="email" id="emailUsuario" name="emailUsuario" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="Nombres">Nombres</label>
                <input type="text" id="Nombres" name="Nombres" required>
            </div>
            <div class="form-group">
                <label for="PrimerApellido">Primer Apellido</label>
                <input type="text" id="PrimerApellido" name="PrimerApellido" required>
            </div>
            <div class="form-group">
                <label for="SegundoApellido">Segundo Apellido</label>
                <input type="text" id="SegundoApellido" name="SegundoApellido" required>
            </div>
            <div class="form-group">
                <label for="FechaNacimiento">Fecha de Nacimiento</label>
                <input type="date" id="FechaNacimiento" name="FechaNacimiento" required>
            </div>
            <div class="form-group">
                <label for="CURP">CURP</label>
                <input type="text" id="CURP" name="CURP" required>
            </div>
            <div class="form-group">
                <label for="RFC">RFC</label>
                <input type="text" id="RFC" name="RFC" required>
            </div>
            <div class="form-group">
                <label for="NumeroCelular">Número de Celular</label>
                <input type="text" id="NumeroCelular" name="NumeroCelular" required>
            </div>
            <div class="form-group">
                <label for="TelefonoCasa">Teléfono de Casa</label>
                <input type="text" id="TelefonoCasa" name="TelefonoCasa">
            </div>
            <div class="form-group">
                <label for="Email">Email</label>
                <input type="email" id="Email" name="Email" required>
            </div>
            <div class="form-group">
                <label for="Calle">Calle</label>
                <input type="text" id="Calle" name="Calle" required>
            </div>
            <div class="form-group">
                <label for="InterseccionPrimera">Intersección Primera</label>
                <input type="text" id="InterseccionPrimera" name="InterseccionPrimera" required>
            </div>
            <div class="form-group">
                <label for="InterseccionSegunda">Intersección Segunda</label>
                <input type="text" id="InterseccionSegunda" name="InterseccionSegunda" required>
            </div>
            <div class="form-group">
                <label for="NumExterior">Número Exterior</label>
                <input type="text" id="NumExterior" name="NumExterior" required>
            </div>
            <div class="form-group">
                <label for="NumInterior">Número Interior</label>
                <input type="text" id="NumInterior" name="NumInterior">
            </div>
            <div class="form-group">
                <label for="CodigoPostal">Código Postal</label>
                <input type="text" id="CodigoPostal" name="CodigoPostal" required>
            </div>
            <div class="form-group">
                <label for="Colonia">Colonia</label>
                <input type="text" id="Colonia" name="Colonia">
            </div>
            <div class="form-group">
                <label for="Localidad">Localidad</label>
                <input type="text" id="Localidad" name="Localidad">
            </div>
            <div class="form-group">
                <label for="Municipio">Municipio</label>
                <input type="text" id="Municipio" name="Municipio">
            </div>
            <div class="form-group">
                <label for="Estado">Estado</label>
                <input type="text" id="Estado" name="Estado">
            </div>
            <div class="form-group">
    <label for="TipoDeUsuarioId">Tipo de Usuario</label>
    <select id="TipoDeUsuarioId" name="TipoDeUsuarioId" required>
        <?php foreach ($tipos_usuarios as $tipo): ?>
            <option value="<?= $tipo['TipoDeUsuarioId'] ?>"><?= $tipo['NombreUsuario'] ?></option>
        <?php endforeach; ?>
    </select>
</div>
            <div class="form-group">
                <button type="submit">Guardar</button>
            </div>
        </form>
    </div>
</body>
</html>