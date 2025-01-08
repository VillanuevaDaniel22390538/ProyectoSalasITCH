<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Información Académica del Estudiante</title>
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
    </style>
    <script>
        function validateForm() {
            const numeroControl = document.getElementById('numeroControl').value;
            const numeroControlRegex = /^[A-Z0-9]{9}$/;

            if (!numeroControlRegex.test(numeroControl)) {
                alert('El Número de Control debe tener exactamente 9 caracteres alfanuméricos.');
                return false;
            }

            return true;
        }
    </script>
</head>

<body>
    <div class="container">
        <h1>Añadir Información Académica del Estudiante</h1>
        <form action="guardar_informacion_academica_estudiante.php" method="POST" onsubmit="return validateForm()">
            <div class="form-row">
                <div class="input-group">
                    <label for="numeroControl">Número de Control:</label>
                    <input type="text" id="numeroControl" name="numeroControl" value="<?php echo $_GET['numeroControl']; ?>" readonly required>
                </div>
                <div class="input-group">
                    <label for="correoInstitucional">Correo Institucional:</label>
                    <input type="email" id="correoInstitucional" name="correoInstitucional" required>
                </div>
                <div class="input-group">
                    <label for="idCarrera">Carrera:</label>
                    <select id="idCarrera" name="idCarrera" required>
                        <option value="">Selecciona una carrera</option>
                        <?php
                        // Conectar a la base de datos y obtener las carreras
                        $servername = "localhost";
                        $dbname = "ProyectoSalasITCH";
                        $username = "sa";
                        $password = "0103";
                        try {
                            $conn = new PDO("sqlsrv:Server=$servername;Database=$dbname", $username, $password);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $stmt = $conn->prepare("SELECT IDCarrera, NombreCarrera FROM Carrera");
                            $stmt->execute();
                            $carreras = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($carreras as $carrera) {
                                echo "<option value='{$carrera['IDCarrera']}'>{$carrera['NombreCarrera']}</option>";
                            }
                        } catch (PDOException $e) {
                            echo "Error de conexión: " . $e->getMessage();
                        }
                        ?>
                    </select>
                </div>
                <div class="input-group">
                    <label for="idCreditosComplementarios">Créditos Complementarios:</label>
                    <select id="idCreditosComplementarios" name="idCreditosComplementarios">
                        <option value="">Selecciona un tipo de crédito</option>
                        <?php
                        // Obtener los créditos complementarios
                        try {
                            $stmt = $conn->prepare("SELECT IDCreditosComplementarios, Total FROM CreditosComplementarios");
                            $stmt->execute();
                            $creditos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($creditos as $credito) {
                                echo "<option value='{$credito['IDCreditosComplementarios']}'>{$credito['Total']}</option>";
                            }
                        } catch (PDOException $e) {
                            echo "Error de conexión: " . $e->getMessage();
                        }
                        ?>
                    </select>
                </div>
                <div class="input-group">
                    <label for="promedioGeneral">Promedio General:</label>
                    <input type="text" id="promedioGeneral" name="promedioGeneral">
                </div>
                <div class="input-group">
                    <label for="semestre">Semestre:</label>
                    <input type="number" id="semestre" name="semestre" required>
                </div>
                <div class="input-group">
                    <label for="idAsignatura">Asignatura:</label>
                    <select id="idAsignatura" name="idAsignatura" required>
                        <option value="">Selecciona una asignatura</option>
                        <?php
                        // Obtener las asignaturas
                        try {
                            $stmt = $conn->prepare("SELECT IDAsignatura, NombreAsignatura FROM Asignaturas");
                            $stmt->execute();
                            $asignaturas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($asignaturas as $asignatura) {
                                echo "<option value='{$asignatura['IDAsignatura']}'>{$asignatura['NombreAsignatura']}</option>";
                            }
                        } catch (PDOException $e) {
                            echo "Error de conexión: " . $e->getMessage();
                        }
                        ?>
                    </select>
                </div>
                <div class="input-group">
                    <label for="idStatusAsignatura">Status de la Asignatura:</label>
                    <select id="idStatusAsignatura" name="idStatusAsignatura" required>
                        <option value="">Selecciona un status</option>
                        <?php
                        // Obtener los status de las asignaturas
                        try {
                            $stmt = $conn->prepare("SELECT IDStatusAsignatura, Estado FROM StatusAsignatura");
                            $stmt->execute();
                            $statusAsignaturas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($statusAsignaturas as $status) {
                                echo "<option value='{$status['IDStatusAsignatura']}'>{$status['Estado']}</option>";
                            }
                        } catch (PDOException $e) {
                            echo "Error de conexión: " . $e->getMessage();
                        }
                        ?>
                    </select>
                </div>
            </div>
            <button type="submit">Guardar Información Académica</button>
        </form>
    </div>
</body>
</html>