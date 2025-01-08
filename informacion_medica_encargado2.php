<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Información Médica del Encargado de Laboratorio</title>
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
        .input-group select {
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
        function validateForm() {
            const idEncargadoLaboratorio = document.getElementById('idEncargadoLaboratorio').value;
            const idEncargadoLaboratorioRegex = /^\d+$/;

            if (!idEncargadoLaboratorioRegex.test(idEncargadoLaboratorio)) {
                alert('El ID del Encargado de Laboratorio debe ser un número válido.');
                return false;
            }

            return true;
        }
        
    </script>
</head>

<body>
<a href="javascript:history.back()" class="back-arrow">&#x2190; </a>

    <div class="container">
        <h1>Añadir Información Médica del Encargado de Laboratorio</h1>
        <form action="guardar_informacion_medica_encargado.php" method="POST" onsubmit="return validateForm()">
            <div class="form-row">
                <div class="input-group">
                    <label for="idEncargadoLaboratorio">ID Encargado de Laboratorio:</label>
                    <input type="text" id="idEncargadoLaboratorio" name="idEncargadoLaboratorio" value="<?php echo htmlspecialchars($_GET['idEncargadoLaboratorio']); ?>" readonly required>
                </div>
                <div class="input-group">
                    <label for="idAlergias">Alergias:</label>
                    <select id="idAlergias" name="idAlergias">
                        <option value="">Selecciona una alergia</option>
                        <?php
                        // Conectar a la base de datos y obtener las alergias
                        $servername = "localhost";
                        $dbname = "ProyectoSalasITCH";
                        $username = "sa";
                        $password = "0103";
                        try {
                            $conn = new PDO("sqlsrv:Server=$servername;Database=$dbname", $username, $password);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $stmt = $conn->prepare("SELECT IDAlergias, NombreAlergia FROM Alergias");
                            $stmt->execute();
                            $alergias = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($alergias as $alergia) {
                                echo "<option value='{$alergia['IDAlergias']}'>{$alergia['NombreAlergia']}</option>";
                            }
                        } catch (PDOException $e) {
                            echo "Error de conexión: " . $e->getMessage();
                        }
                        ?>
                    </select>
                </div>
                <div class="input-group">
                    <label for="idEnfermedadesCronicas">Enfermedades Crónicas:</label>
                    <select id="idEnfermedadesCronicas" name="idEnfermedadesCronicas">
                        <option value="">Selecciona una enfermedad</option>
                        <?php
                        // Obtener las enfermedades crónicas
                        try {
                            $stmt = $conn->prepare("SELECT IDEnfermedadesCronicas, NombreEnfermedad FROM EnfermedadesCronicas");
                            $stmt->execute();
                            $enfermedades = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($enfermedades as $enfermedad) {
                                echo "<option value='{$enfermedad['IDEnfermedadesCronicas']}'>{$enfermedad['NombreEnfermedad']}</option>";
                            }
                        } catch (PDOException $e) {
                            echo "Error de conexión: " . $e->getMessage();
                        }
                        ?>
                    </select>
                </div>
                <div class="input-group">
                    <label for="idTipoSangre">Tipo de Sangre:</label>
                    <select id="idTipoSangre" name="idTipoSangre" required>
                        <option value="">Selecciona un tipo de sangre</option>
                        <?php
                        // Obtener los tipos de sangre
                        try {
                            $stmt = $conn->prepare("SELECT IDTipoSangre, NombreTipoSangre FROM TipoSangre");
                            $stmt->execute();
                            $tiposSangre = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($tiposSangre as $tipoSangre) {
                                echo "<option value='{$tipoSangre['IDTipoSangre']}'>{$tipoSangre['NombreTipoSangre']}</option>";
                            }
                        } catch (PDOException $e) {
                            echo "Error de conexión: " . $e->getMessage();
                        }
                        ?>
                    </select>
                </div>
            </div>
            <button type="submit">Guardar Información Médica</button>
        </form>
    </div>
</body>
</html>