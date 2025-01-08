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
    <title>Editar Personal de Laboratorio</title>
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
        .form-group input, .form-group select {
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
    <script>
        function buscarPersonal() {
            var idPersonal = document.getElementById('IDPersonal').value;
            if (idPersonal) {
                window.location.href = 'editar_personal_laboratorio.php?id=' + idPersonal;
            }
        }
    </script>
</head>
<body>
<a href="javascript:history.back()" class="back-arrow">&#x2190; </a>
    <div class="container">
        <div class="title">Editar Personal de Laboratorio</div>
        <form method="GET" action="editar_personal_laboratorio.php">
            <div class="form-group">
                <label for="IDPersonal">Buscar por ID Personal</label>
                <input type="text" id="IDPersonal" name="IDPersonal">
                <button type="button" onclick="buscarPersonal()">Buscar</button>
            </div>
            <div class="form-group">
                <label for="listaPersonal">O seleccionar de la lista</label>
                <select id="listaPersonal" name="listaPersonal" onchange="window.location.href='editar_personal_laboratorio.php?id=' + this.value">
                    <option value="">Seleccione un personal</option>
                    <?php
                    // Conexión a la base de datos
                    $serverName = "localhost";
                    $database = "ProyectoSalasITCH";
                    $username = "sa";
                    $password = "0103";

                    try {
                        $pdo = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        // Obtener la lista de personal
                        $sql = "SELECT IDPersonal, Nombres, PrimerApellido, SegundoApellido FROM Personal";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        $personal = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($personal as $persona) {
                            echo "<option value='{$persona['IDPersonal']}'>{$persona['Nombres']} {$persona['PrimerApellido']} {$persona['SegundoApellido']}</option>";
                        }
                    } catch (PDOException $e) {
                        echo "Error en la conexión: " . $e->getMessage();
                    }
                    ?>
                </select>
            </div>
        </form>

        <?php
        if (isset($_GET['id'])) {
            $idPersonal = $_GET['id'];

            try {
                // Obtener los datos del personal
                $sql = "SELECT * FROM Personal WHERE IDPersonal = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$idPersonal]);
                $personal = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($personal) {
                    echo '<form method="POST" action="actualizar_personal_laboratorio.php">';
                    echo '<input type="hidden" name="IDPersonal" value="' . $personal['IDPersonal'] . '">';
                    echo '<div class="form-group"><label for="Nombres">Nombres</label><input type="text" id="Nombres" name="Nombres" value="' . $personal['Nombres'] . '" required></div>';
                    echo '<div class="form-group"><label for="PrimerApellido">Primer Apellido</label><input type="text" id="PrimerApellido" name="PrimerApellido" value="' . $personal['PrimerApellido'] . '" required></div>';
                    echo '<div class="form-group"><label for="SegundoApellido">Segundo Apellido</label><input type="text" id="SegundoApellido" name="SegundoApellido" value="' . $personal['SegundoApellido'] . '" required></div>';
                    echo '<div class="form-group"><label for="FechaNacimiento">Fecha de Nacimiento</label><input type="date" id="FechaNacimiento" name="FechaNacimiento" value="' . $personal['FechaNacimiento'] . '" required></div>';
                    echo '<div class="form-group"><label for="CURP">CURP</label><input type="text" id="CURP" name="CURP" value="' . $personal['CURP'] . '" required></div>';
                    echo '<div class="form-group"><label for="RFC">RFC</label><input type="text" id="RFC" name="RFC" value="' . $personal['RFC'] . '" required></div>';
                    echo '<div class="form-group"><label for="NumeroCelular">Número de Celular</label><input type="text" id="NumeroCelular" name="NumeroCelular" value="' . $personal['NumeroCelular'] . '" required></div>';
                    echo '<div class="form-group"><label for="TelefonoCasa">Teléfono de Casa</label><input type="text" id="TelefonoCasa" name="TelefonoCasa" value="' . $personal['TelefonoCasa'] . '"></div>';
                    echo '<div class="form-group"><label for="Email">Email</label><input type="email" id="Email" name="Email" value="' . $personal['Email'] . '" required></div>';
                    echo '<div class="form-group"><label for="Calle">Calle</label><input type="text" id="Calle" name="Calle" value="' . $personal['Calle'] . '" required></div>';
                    echo '<div class="form-group"><label for="InterseccionPrimera">Intersección Primera</label><input type="text" id="InterseccionPrimera" name="InterseccionPrimera" value="' . $personal['InterseccionPrimera'] . '" required></div>';
                    echo '<div class="form-group"><label for="InterseccionSegunda">Intersección Segunda</label><input type="text" id="InterseccionSegunda" name="InterseccionSegunda" value="' . $personal['InterseccionSegunda'] . '" required></div>';
                    echo '<div class="form-group"><label for="NumExterior">Número Exterior</label><input type="text" id="NumExterior" name="NumExterior" value="' . $personal['NumExterior'] . '" required></div>';
                    echo '<div class="form-group"><label for="NumInterior">Número Interior</label><input type="text" id="NumInterior" name="NumInterior" value="' . $personal['NumInterior'] . '"></div>';
                    echo '<div class="form-group"><label for="CodigoPostal">Código Postal</label><input type="text" id="CodigoPostal" name="CodigoPostal" value="' . $personal['CodigoPostal'] . '" required></div>';
                    echo '<div class="form-group"><label for="Colonia">Colonia</label><input type="text" id="Colonia" name="Colonia" value="' . $personal['Colonia'] . '"></div>';
                    echo '<div class="form-group"><label for="Localidad">Localidad</label><input type="text" id="Localidad" name="Localidad" value="' . $personal['Localidad'] . '"></div>';
                    echo '<div class="form-group"><label for="Municipio">Municipio</label><input type="text" id="Municipio" name="Municipio" value="' . $personal['Municipio'] . '"></div>';
                    echo '<div class="form-group"><label for="Estado">Estado</label><input type="text" id="Estado" name="Estado" value="' . $personal['Estado'] . '"></div>';
                    echo '<div class="form-group"><label for="TipoDeUsuarioId">Tipo de Usuario</label>';
                    echo '<select id="TipoDeUsuarioId" name="TipoDeUsuarioId" required>';
                    foreach ($tipos_usuarios as $tipo) {
                        $selected = $tipo['TipoDeUsuarioId'] == $coordinador['TipoDeUsuarioId'] ? 'selected' : '';
                        echo "<option value='{$tipo['TipoDeUsuarioId']}' $selected>{$tipo['NombreUsuario']}</option>";
                    }
                    echo '</select></div>';
                    echo '<div class="form-group"><button type="submit">Guardar</button></div>';
                    echo '</form>';

                } else {
                    echo '<p>Personal no encontrado.</p>';
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        ?>
    </div>
</body>
</html>