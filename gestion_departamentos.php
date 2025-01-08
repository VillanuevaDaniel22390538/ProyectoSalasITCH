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
$dbusername = "sa";
$dbpassword = "0103";

try {
    // Conectar a SQL Server usando PDO
    $conn = new PDO("sqlsrv:Server=$servername;Database=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener datos de la tabla DepartamentoAcademico
    $stmt = $conn->prepare("SELECT * FROM DepartamentoAcademico");
    $stmt->execute();
    $departamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Departamentos Académicos</title>
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
            background-color:rgb(18, 17, 17);
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
    </style>
    <!-- Enlace a Font Awesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h1>Gestión de Departamentos Académicos</h1>

        <div class="table-container">
            <h2>Departamentos Académicos</h2>
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
                    <?php foreach ($departamentos as $departamento): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($departamento['IDDepartamentoAcademico']); ?></td>
                            <td><?php echo htmlspecialchars($departamento['NombreDepartamento']); ?></td>
                            <td><?php echo htmlspecialchars($departamento['DescripcionDepartamento']); ?></td>
                            <td>
                                <button onclick="location.href='editar_departamento.php?id=<?php echo $departamento['IDDepartamentoAcademico']; ?>'"><i class="fas fa-edit"></i> Editar</button>
                                <button onclick="location.href='eliminar_departamento.php?id=<?php echo $departamento['IDDepartamentoAcademico']; ?>'"><i class="fas fa-trash-alt"></i> Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button onclick="location.href='agregar_departamento.php'"><i class="fas fa-plus"></i> Agregar Departamento</button>
        </div>

        <button class="back-button" onclick="location.href='welcome_administrador.php'">
            <i class="fas fa-arrow-left"></i> Regresar al Inicio
        </button>
    </div>
</body>
</html>