<?php
session_start(); // Inicia la sesión

// Verifica si el usuario está autenticado y es administrador
if (!isset($_SESSION['username']) || $_SESSION['tipo_usuario'] != 5) {
    header("Location: index.php"); // Redirige al inicio de sesión si no está autenticado o no es administrador
    exit();
}
$username = $_SESSION['username']; // Obtiene el nombre del usuario de la sesión

// Configuración de conexión a la base de datos
$servername = "localhost";
$dbname = "ProyectoSalasITCH";
$username = "sa";
$password = "0103";

try {
    // Conectar a SQL Server usando PDO
    $conn = new PDO("sqlsrv:Server=$servername;Database=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Inicializar las variables
    $alergias = [];
    $enfermedades = [];
    $tiposSangre = [];

    // Obtener datos de las tablas
    $stmtAlergias = $conn->prepare("SELECT * FROM Alergias");
    $stmtAlergias->execute();
    $alergias = $stmtAlergias->fetchAll(PDO::FETCH_ASSOC);

    $stmtEnfermedades = $conn->prepare("SELECT * FROM EnfermedadesCronicas");
    $stmtEnfermedades->execute();
    $enfermedades = $stmtEnfermedades->fetchAll(PDO::FETCH_ASSOC);

    $stmtTipoSangre = $conn->prepare("SELECT * FROM TipoSangre");
    $stmtTipoSangre->execute();
    $tiposSangre = $stmtTipoSangre->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión Médica</title>
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
            background-color: rgba(0, 0, 0, 0.8); /* Fondo semitransparente */
            padding: 40px;
            border-radius: 10px;
            width: 90%;
            max-width: 1000px;
            margin: auto;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            text-align: center;
        }
        .container h1 {
            color: #ffcc00; /* Color dorado para el título */
            margin-bottom: 20px;
        }
        .table-container {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color:rgb(0, 0, 0);
        }
        .button-group {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
        }
        .button-group button {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }
        .button-group button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        .back-button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }
        .back-button:hover {
            background-color: #218838;
            transform: scale(1.05);
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
    <!-- Enlace a Font Awesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<a href="javascript:history.back()" class="back-arrow">&#x2190; </a>

    <div class="container">
        <h1>Gestión Médica</h1>

        <div class="table-container">
            <h2>Alergias
                <button onclick="location.href='agregar_alergia.php'" style="margin-left: 650px;">
                    <i class="fas fa-plus"></i> Agregar Alergia
                </button>
            </h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alergias as $alergia): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($alergia['IDAlergias']); ?></td>
                            <td><?php echo htmlspecialchars($alergia['NombreAlergia']); ?></td>
                            <td><?php echo htmlspecialchars($alergia['DescripcionAlergia']); ?></td>
                            <td>
                                <button onclick="location.href='editar_alergia.php?id=<?php echo $alergia['IDAlergias']; ?>'">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <form action="eliminar_alergia.php" method="post" style="display:inline;">
                                    <input type="hidden" name="idAlergia" value="<?php echo $alergia['IDAlergias']; ?>">
                                    <button type="submit">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="table-container">
            <h2>Enfermedades Crónicas
                <button onclick="location.href='agregar_enfermedad.php'" style="margin-left: 500px;">
                    <i class="fas fa-plus"></i> Agregar Enfermedad
                </button>
            </h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($enfermedades as $enfermedad): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($enfermedad['IDEnfermedadesCronicas']); ?></td>
                            <td><?php echo htmlspecialchars($enfermedad['NombreEnfermedad']); ?></td>
                            <td><?php echo htmlspecialchars($enfermedad['DescripcionEnfermedad']); ?></td>
                            <td>
                                <button onclick="location.href='editar_enfermedad.php?id=<?php echo $enfermedad['IDEnfermedadesCronicas']; ?>'">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <form action="eliminar_enfermedad.php" method="post" style="display:inline;">
                                    <input type="hidden" name="idEnfermedad" value="<?php echo $enfermedad['IDEnfermedadesCronicas']; ?>">
                                    <button type="submit">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="table-container">
            <h2>Tipos de Sangre
                <button onclick="location.href='agregar_tipo_sangre.php'" style="margin-left: 600px;">
                    <i class="fas fa-plus"></i> Agregar Tipo de Sangre
                </button>
            </h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tiposSangre as $tipoSangre): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($tipoSangre['IDTipoSangre']); ?></td>
                            <td><?php echo htmlspecialchars($tipoSangre['NombreTipoSangre']); ?></td>
                            <td>
                                <button onclick="location.href='editar_tipo_sangre.php?id=<?php echo $tipoSangre['IDTipoSangre']; ?>'">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <form action="eliminar_tipo_sangre.php" method="post" style="display:inline;">
                                    <input type="hidden" name="idTipoSangre" value="<?php echo $tipoSangre['IDTipoSangre']; ?>">
                                    <button type="submit">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <button class="back-button" onclick="location.href='welcome_administrador.php'">
            <i class="fas fa-arrow-left"></i> Regresar al Inicio
        </button>
    </div>
</body>
</html>