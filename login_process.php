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

// Obtener datos del formulario
$user = $_POST['username'];
$pass = $_POST['password'];

try {
    // Consulta preparada para evitar inyección SQL
    $stmt = $conn->prepare("SELECT idUsuario, NombreUsuario, passsword, TipoDeUsuarioId FROM Usuarios WHERE NombreUsuario = ?");
    $stmt->execute([$user]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && password_verify($pass, $result['passsword'])) {
        // Inicio de sesión exitoso
        $_SESSION['username'] = $user; // Guarda el nombre del usuario en la sesión
        $_SESSION['tipo_usuario'] = $result['TipoDeUsuarioId']; // Guarda el tipo de usuario en la sesión
        $_SESSION['idUsuario'] = $result['idUsuario']; // Guarda el idUsuario en la sesión

        // Obtener el NumeroControl si el usuario es un estudiante
        if ($result['TipoDeUsuarioId'] == 1) {
            $stmt = $conn->prepare("SELECT NumeroControl FROM Estudiante WHERE idUsuario = ?");
            $stmt->execute([$result['idUsuario']]);
            $estudiante = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($estudiante) {
                $_SESSION['NumeroControl'] = $estudiante['NumeroControl'];
            }
        }

        // Obtener el ID del docente si el usuario es un docente
        if ($result['TipoDeUsuarioId'] == 2) {
            $stmt = $conn->prepare("SELECT IDDocente FROM Docente WHERE idUsuario = ?");
            $stmt->execute([$result['idUsuario']]);
            $docente = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($docente) {
                $_SESSION['idDocente'] = $docente['IDDocente'];
            }
        }

        // Redirigir según el tipo de usuario
        switch ($result['TipoDeUsuarioId']) {
            case 1: // Estudiante
                header("Location: welcome_estudiante.php");
                break;
            case 2: // Docente
                header("Location: welcome_docente.php");
                break;
            case 5: // Administrador
                header("Location: welcome_administrador.php");
                break;
            case 7: // Encargado
                header("Location: welcome_encargadolab.php");
                break;
            default:
                header("Location: dashboard.php"); // Redirigir a una página general para otros tipos de usuarios
                break;
        }
        exit();
    } else {
        // Credenciales incorrectas
        echo "<script>
            alert('Usuario o contraseña incorrectos.');
            window.location.href='index.php'; // Redirige de vuelta al inicio de sesión
        </script>";
    }
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}

// Cierra la conexión
$conn = null;
?>
