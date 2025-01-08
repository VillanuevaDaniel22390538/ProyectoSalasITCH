<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Información Académica</title>
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
            const idDocente = document.getElementById('idDocente').value;
            const idDocenteRegex = /^\d{10}$/;

            if (!idDocenteRegex.test(idDocente)) {
                alert('El ID Docente debe tener exactamente 10 dígitos.');
                return false;
            }

            return true;
        }
    </script>
</head>

<body>
    <div class="container">
        <h1>Añadir Información Académica</h1>
        <form action="guardar_informacion_academica.php" method="POST" onsubmit="return validateForm()">
            <div class="form-row">
                <div class="input-group">
                    <label for="idDocente">ID Docente:</label>
                    <input type="text" id="idDocente" name="idDocente" value="<?php echo $_GET['idDocente']; ?>" readonly required>
                </div>
                <div class="input-group">
                    <label for="correoInstitucional">Correo Institucional:</label>
                    <input type="email" id="correoInstitucional" name="correoInstitucional" required>
                </div>
                <div class="input-group">
                    <label for="idGrado">Grado Académico:</label>
                    <select id="idGrado" name="idGrado" required>
                        <option value="">Selecciona un grado</option>
                        <?php
                        // Conectar a la base de datos y obtener los grados académicos
                        $servername = "localhost";
                        $dbname = "ProyectoSalasITCH";
                        $username = "sa";
                        $password = "0103";
                        try {
                            $conn = new PDO("sqlsrv:Server=$servername;Database=$dbname", $username, $password);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $stmt = $conn->prepare("SELECT IDGrado, Nivel FROM GradoAcademico");
                            $stmt->execute();
                            $grados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($grados as $grado) {
                                echo "<option value='{$grado['IDGrado']}'>{$grado['Nivel']}</option>";
                            }
                        } catch (PDOException $e) {
                            echo "Error de conexión: " . $e->getMessage();
                        }
                        ?>
                    </select>
                </div>
                <div class="input-group">
                    <label for="universidad">Universidad:</label>
                    <input type="text" id="universidad" name="universidad" required>
                </div>
                <div class="input-group">
                    <label for="cedula">Cédula:</label>
                    <input type="text" id="cedula" name="cedula" required>
                </div>
                <div class="input-group">
                    <label for="idDepartamentoAcademico">Departamento Académico:</label>
                    <select id="idDepartamentoAcademico" name="idDepartamentoAcademico" required>
                        <option value="">Selecciona un departamento</option>
                        <?php
                        // Obtener los departamentos académicos
                        try {
                            $stmt = $conn->prepare("SELECT IDDepartamentoAcademico, NombreDepartamento FROM DepartamentoAcademico");
                            $stmt->execute();
                            $departamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($departamentos as $departamento) {
                                echo "<option value='{$departamento['IDDepartamentoAcademico']}'>{$departamento['NombreDepartamento']}</option>";
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