<?php
// Incluir el archivo de conexión a la base de datos
include 'db_connection.php'; // Conectar a la base de datos

// Obtener los datos enviados desde el formulario de registro
$username = $_POST['username']; // Nombre de usuario
$email = $_POST['email']; // Correo electrónico
$password = $_POST['password']; // Contraseña

// Hashear la contraseña para mayor seguridad
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Consulta SQL para insertar el nuevo usuario en la tabla
$sql = "INSERT INTO Usuarios (username, email, password) VALUES (?, ?, ?)"; 
$params = array($username, $email, $hashedPassword); // Parámetros de la consulta

// Ejecutar la consulta
$stmt = sqlsrv_query($conn, $sql, $params);

// Comprobar si la consulta fue exitosa
if ($stmt) {
    echo "Cuenta creada exitosamente."; // Mensaje de éxito
    // Redirigir al inicio de sesión (opcional)
    header("Location: index.php"); 
    exit(); // Salir del script después de la redirección
} else {
    // Mostrar mensaje de error si la inserción falla
    echo "Error al crear la cuenta: " . print_r(sqlsrv_errors(), true); 
}

// Cerrar la conexión a la base de datos
sqlsrv_close($conn); 
?>
