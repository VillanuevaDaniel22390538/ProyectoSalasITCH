<?php
session_start(); // Inicia la sesión para almacenar datos del usuario

// Verificar si el nombre del docente y el ID del docente están definidos en la sesión
if (isset($_SESSION['username']) && isset($_SESSION['idDocente'])) {
    $nombreDocente = $_SESSION['username'];
    $idDocente = $_SESSION['idDocente'];
} else {
    // Redirigir al inicio de sesión si no están definidos
    header("Location: index.php");
    exit();
}

// Configuración de conexión a la base de datos
$servername = "localhost";
$dbname = "ProyectoSalasITCH";
$username = "sa";
$password = "0103";

try {
    // Conectar a SQL Server usando PDO
    $conn = new PDO("sqlsrv:Server=$servername;Database=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener datos personales del docente
    $stmt = $conn->prepare("SELECT * FROM Docente WHERE IDDocente = ?");
    $stmt->execute([$idDocente]);
    $datosPersonales = $stmt->fetch(PDO::FETCH_ASSOC);

    // Obtener información académica del docente
    $stmt = $conn->prepare("SELECT * FROM InformacionAcademicaDocente WHERE IDDocente = ?");
    $stmt->execute([$idDocente]);
    $datosAcademicos = $stmt->fetch(PDO::FETCH_ASSOC);

    // Obtener información médica del docente
    $stmt = $conn->prepare("SELECT * FROM InformacionMedicaDocente WHERE IDDocente = ?");
    $stmt->execute([$idDocente]);
    $datosMedicos = $stmt->fetch(PDO::FETCH_ASSOC);

    // Obtener detalles adicionales de las tablas relacionadas
    if ($datosAcademicos) {
        $stmt = $conn->prepare("SELECT Nivel FROM GradoAcademico WHERE IDGrado = ?");
        $stmt->execute([$datosAcademicos['IDGrado']]);
        $gradoAcademico = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $conn->prepare("SELECT NombreDepartamento FROM DepartamentoAcademico WHERE IDDepartamentoAcademico = ?");
        $stmt->execute([$datosAcademicos['IDDepartamentoAcademico']]);
        $departamentoAcademico = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    if ($datosMedicos) {
        $stmt = $conn->prepare("SELECT NombreAlergia FROM Alergias WHERE IDAlergias = ?");
        $stmt->execute([$datosMedicos['IDAlergias']]);
        $alergia = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $conn->prepare("SELECT NombreEnfermedad FROM EnfermedadesCronicas WHERE IDEnfermedadesCronicas = ?");
        $stmt->execute([$datosMedicos['IDEnfermedadesCronicas']]);
        $enfermedadCronica = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $conn->prepare("SELECT NombreTipoSangre FROM TipoSangre WHERE IDTipoSangre = ?");
        $stmt->execute([$datosMedicos['IDTipoSangre']]);
        $tipoSangre = $stmt->fetch(PDO::FETCH_ASSOC);
    }

} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Datos del Docente</title>
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
        .data-group {
            margin-bottom: 20px;
        }
        .data-group h2 {
            color: #ffcc00; /* Color dorado para los subtítulos */
            margin-bottom: 10px;
        }
        .data-group p {
            margin: 5px 0;
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
        .container .report-button {
            background-color: #dc3545;
        }
        .container .report-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ver Datos del Docente</h1>

        <div class="data-group">
            <h2>Datos Personales</h2>
            <p><strong>ID Docente:</strong> <?php echo htmlspecialchars($datosPersonales['IDDocente'] ?? 'No disponible'); ?></p>
            <p><strong>Nombres:</strong> <?php echo htmlspecialchars($datosPersonales['Nombres'] ?? 'No disponible'); ?></p>
            <p><strong>Primer Apellido:</strong> <?php echo htmlspecialchars($datosPersonales['PrimerApellido'] ?? 'No disponible'); ?></p>
            <p><strong>Segundo Apellido:</strong> <?php echo htmlspecialchars($datosPersonales['SegundoApellido'] ?? 'No disponible'); ?></p>
            <p><strong>Fecha de Nacimiento:</strong> <?php echo htmlspecialchars($datosPersonales['FechaNacimiento'] ?? 'No disponible'); ?></p>
            <p><strong>CURP:</strong> <?php echo htmlspecialchars($datosPersonales['CURP'] ?? 'No disponible'); ?></p>
            <p><strong>RFC:</strong> <?php echo htmlspecialchars($datosPersonales['RFC'] ?? 'No disponible'); ?></p>
            <p><strong>Número de Celular:</strong> <?php echo htmlspecialchars($datosPersonales['NumeroCelular'] ?? 'No disponible'); ?></p>
            <p><strong>Teléfono de Casa:</strong> <?php echo htmlspecialchars($datosPersonales['TelefonoCasa'] ?? 'No disponible'); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($datosPersonales['Email'] ?? 'No disponible'); ?></p>
            <p><strong>Calle:</strong> <?php echo htmlspecialchars($datosPersonales['Calle'] ?? 'No disponible'); ?></p>
            <p><strong>Intersección Primera:</strong> <?php echo htmlspecialchars($datosPersonales['InterseccionPrimera'] ?? 'No disponible'); ?></p>
            <p><strong>Intersección Segunda:</strong> <?php echo htmlspecialchars($datosPersonales['InterseccionSegunda'] ?? 'No disponible'); ?></p>
            <p><strong>Número Exterior:</strong> <?php echo htmlspecialchars($datosPersonales['NumExterior'] ?? 'No disponible'); ?></p>
            <p><strong>Número Interior:</strong> <?php echo htmlspecialchars($datosPersonales['NumInterior'] ?? 'No disponible'); ?></p>
            <p><strong>Código Postal:</strong> <?php echo htmlspecialchars($datosPersonales['CodigoPostal'] ?? 'No disponible'); ?></p>
            <p><strong>Colonia:</strong> <?php echo htmlspecialchars($datosPersonales['Colonia'] ?? 'No disponible'); ?></p>
            <p><strong>Localidad:</strong> <?php echo htmlspecialchars($datosPersonales['Localidad'] ?? 'No disponible'); ?></p>
            <p><strong>Municipio:</strong> <?php echo htmlspecialchars($datosPersonales['Municipio'] ?? 'No disponible'); ?></p>
            <p><strong>Estado:</strong> <?php echo htmlspecialchars($datosPersonales['Estado'] ?? 'No disponible'); ?></p>
        </div>

        <div class="data-group">
            <h2>Información Académica</h2>
            <p><strong>Correo Institucional:</strong> <?php echo htmlspecialchars($datosAcademicos['CorreoInstitucional'] ?? 'No disponible'); ?></p>
            <p><strong>Grado Académico:</strong> <?php echo htmlspecialchars($gradoAcademico['Nivel'] ?? 'No disponible'); ?></p>
            <p><strong>Departamento Académico:</strong> <?php echo htmlspecialchars($departamentoAcademico['NombreDepartamento'] ?? 'No disponible'); ?></p>
        </div>

        <div class="data-group">
            <h2>Información Médica</h2>
            <p><strong>Alergias:</strong> <?php echo htmlspecialchars($alergia['NombreAlergia'] ?? 'No disponible'); ?></p>
            <p><strong>Enfermedades Crónicas:</strong> <?php echo htmlspecialchars($enfermedadCronica['NombreEnfermedad'] ?? 'No disponible'); ?></p>
            <p><strong>Tipo de Sangre:</strong> <?php echo htmlspecialchars($tipoSangre['NombreTipoSangre'] ?? 'No disponible'); ?></p>
        </div>

        <button onclick="window.location.href='welcome_docente.php'">Regresar</button>
        <button class="report-button" onclick="alert('Contacta con el administrador:\nCorreo: admin@proyectosalasitch.com\nHorarios de atención: Lunes a Viernes, 9:00 AM - 5:00 PM')">Reportar</button>
    </div>
</body>
</html>