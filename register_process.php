<?php
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
$email = $_POST['email'];
$pass = $_POST['password'];
$tipo_usuario = $_POST['tipo_usuario'];

// Encriptar la contraseña
$hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

try {
    // Consulta preparada para insertar el usuario
    $stmt = $conn->prepare("INSERT INTO Usuarios (NombreUsuario, emailUsuario, passsword, TipoDeUsuarioId) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user, $email, $hashedPassword, $tipo_usuario]);

    // Obtener el idUsuario del último registro insertado
$idUsuario = $conn->lastInsertId();

// Redirigir a la página de datos personales correspondiente con el idUsuario
switch ($tipo_usuario) {
    case 1: // Estudiante
        $redirect_url = 'datos_personales_estudiante.php?idUsuario=' . $idUsuario;
        break;
    case 2: // Docente
        $redirect_url = 'datos_personales.php?idUsuario=' . $idUsuario;
        break;
    case 7: // Encargado de Laboratorio
        $redirect_url = 'datos_personales_encargado.php?idUsuario=' . $idUsuario;
        break;
    case 4: // Jefe de Departamento
        $redirect_url = 'datos_personales_jefe.php?idUsuario=' . $idUsuario;
        break;
    default:
        $redirect_url = 'index.php'; // Redirigir al inicio de sesión por defecto
        break;
}

echo "<script>
    alert('Registro exitoso. Por favor, completa tus datos personales.');
    window.location.href='$redirect_url';
</script>";

} catch (PDOException $e) {
    echo "Error en el registro: " . $e->getMessage();
}

// Cierra la conexión
$conn = null;
?>