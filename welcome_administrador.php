<?php
session_start(); // Inicia la sesión

// Verifica si el usuario está autenticado y es administrador
if (!isset($_SESSION['username']) || $_SESSION['tipo_usuario'] != 5) {
    header("Location: index.php"); // Redirige al inicio de sesión si no está autenticado o no es administrador
    exit();
}
$username = $_SESSION['username']; // Obtiene el nombre del usuario de la sesión

// Conexión a la base de datos
$serverName = "localhost"; // Nombre del servidor de la base de datos
$database = "ProyectoSalasITCH"; // Nombre de la base de datos
$username_db = "sa"; // Nombre de usuario de la base de datos
$password_db = "0103"; // Contraseña de la base de datos

try {
    // Crea una nueva conexión PDO a la base de datos
    $pdo = new PDO("sqlsrv:server=$serverName;Database=$database", $username_db, $password_db);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Establece el modo de error de PDO a excepción
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage()); // Muestra un mensaje de error si la conexión falla
}

// Consulta para obtener las salas con descripción y capacidad
$sql = "SELECT IDSala, NombreSala, DescripcionSala, Capacidad FROM Sala";
$stmt = $pdo->prepare($sql); // Prepara la consulta SQL
$stmt->execute(); // Ejecuta la consulta
$salas = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtiene todos los resultados de la consulta en un array asociativo

// Consulta para obtener el estado de la sala
foreach ($salas as &$room) {
    $sql = "SELECT es.Descripcion 
            FROM Sala s
            JOIN EstadoSala es ON s.IDSala = es.IDEstado
            WHERE s.IDSala = :sala_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['sala_id' => $room['IDSala']]);
    $estadoDescripcion = $stmt->fetchColumn();
    $room['estado'] = $estadoDescripcion;
}
unset($room); // Desvincula la referencia al último elemento

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido Administrador</title>
    <style>
        /* Estilos generales */
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('imagenes/fondo.jpg'); /* Fondo similar al de index */
            background-size: cover;
            background-position: center;
            color: white;
        }

        /* Header */
        .header {
            background: rgba(0, 0, 0, 0.7); /* Fondo semitransparente */
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logout-btn {
            background: #dc3545;
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background: #c82333;
        }

        /* Logos */
        .logos {
            display: flex;
            justify-content: space-between;
            width: 90%;
            max-width: 1200px;
            margin: 1rem auto;
            background-color: rgba(0, 0, 0, 0.7); /* Fondo semitransparente */
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        .logos img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
        }

        .logos img:nth-child(2) {
            width: 80px;
        }

        /* Container principal */
        .main-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        /* Panel de administración */
        .admin-panel {
            background: rgba(0, 0, 0, 0.7); /* Fondo semitransparente */
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            color: white;
        }

        .admin-panel h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #ffcc00; /* Color dorado para el título */
        }

        .admin-options {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .admin-btn {
            background: #007bff;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .admin-btn:hover {
            background: #0056b3;
        }

        .admin-btn i {
            font-size: 1.2rem;
        }

        /* Footer */
        .footer {
            background: rgba(0, 0, 0, 0.7);
            color: white;
            text-align: center;
            padding: 1rem;
            position: fixed;
            bottom: 0;
            width: 100%;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.5);
        }
    </style>
    <!-- Enlace a Font Awesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<div class="logos">
    <img src="imagenes/LogoTECNM.png" alt="Logo TECNM">
    <img src="imagenes/LogoITCH.png" alt="Logo ITCH">
</div>
<header class="header">
    <h1>Bienvenido Administrador</h1>
    <div class="user-info">
        <span>Bienvenido, <?php echo htmlspecialchars($username); ?></span>
        <button class="logout-btn" onclick="location.href='logout.php'">Cerrar Sesión</button>
    </div>
</header>

<div class="main-container">
    <div class="admin-panel">
        <h2>Panel de Administración</h2>
        <div class="admin-options">
            <button class="admin-btn" onclick="location.href='solicitarsala'">
                <i class="fas fa-door-open"></i> Gestionar Salas y Horarios
            </button>
            <button class="admin-btn" onclick="window.open('gestionar_usuarios.php', '_blank', 'width=800,height=600')">
                <i class="fas fa-users-cog"></i> Gestionar Usuarios 
            </button>
            <button class="admin-btn" onclick="location.href='ver_reportes.php'">
                <i class="fas fa-file-alt"></i> Ver Reportes
            </button>
            <button class="admin-btn" onclick="location.href='inventario.php'">
                <i class="fas fa-boxes"></i> Inventario
            </button>
            <button class="admin-btn" onclick="location.href='gestion_medica.php'">
                <i class="fas fa-notes-medical"></i> Gestión Médica
            </button>
            <button class="admin-btn" onclick="location.href='gestion_departamentos.php'">
                <i class="fas fa-building"></i> Gestión Departamentos
            </button>
            <button class="admin-btn" onclick="location.href='gestion_carreras.php'">
                <i class="fas fa-building"></i> Gestión Carreras
            </button>
            <button class="admin-btn" onclick="location.href='gestion_grado_academico.php'">
                <i class="fas fa-graduation-cap"></i> Gestión Grado Académico
            </button>
            <button class="admin-btn" onclick="location.href='gestion_salas.php'">
                <i class="fas fa-chalkboard-teacher"></i> Gestión de Salas
            </button>
            <button class="admin-btn" onclick="location.href='gestion_mantenimiento.php'">
                <i class="fas fa-tools"></i> Gestión de Mantenimiento
            </button>
            <button class="admin-btn" onclick="location.href='gestion_compus_estudiantes.php'">
                <i class="fas fa-laptop"></i> Gestionar Computadoras a Estudiantes
            </button>
        </div>
    </div>
</div>

<footer class="footer">
Gestión de Salas del Laboratorio de Computo del TECNM Campus Chetumal. Todos los derechos reservados.
</footer>
</body>
</html>