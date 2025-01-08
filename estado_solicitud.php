<?php
session_start();
include 'conexion.php'; // Asegúrate de tener un archivo de conexión a la base de datos

$id_solicitud = $_POST['id_solicitud'];

try {
    $sql = "SELECT estado FROM solicitudes_prestamo WHERE id = :id_solicitud";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_solicitud', $id_solicitud);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $estado = $result['estado'];
    } else {
        $estado = "No se encontró la solicitud.";
    }
} catch (PDOException $e) {
    $estado = "Error: " . $e->getMessage();
}

$pdo = null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de la Solicitud</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('imagenes/fondo.JPG'); /* Imagen de fondo */
            background-size: cover; /* La imagen cubre todo el fondo */
            background-position: center; /* Centra la imagen en el fondo */
            display: flex; /* Usa Flexbox para centrar el contenido */
            justify-content: center; /* Centra horizontalmente */
            align-items: center; /* Centra verticalmente */
            height: 100vh; /* Usa el 100% de la altura de la ventana */
            color: white; /* Cambia el color del texto a blanco */
        }

        .container {
            background-color: rgba(0, 0, 0, 0.7); /* Fondo semitransparente */
            padding: 40px; /* Espaciado interno del contenedor */
            border-radius: 10px; /* Bordes redondeados */
            width: 400px; /* Ancho fijo del contenedor */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5); /* Sombra ligera */
            text-align: center; /* Centra el texto */
        }

        .container h1 {
            color: #ffcc00; /* Color dorado para el título */
        }

        .container p {
            margin-top: 20px;
            font-size: 18px;
        }

        .container button {
            margin-top: 20px;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .container button:hover {
            background-color: #0056b3;
        }

        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            text-align: center;
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.7); /* Fondo semitransparente */
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Estado de la Solicitud</h1>
        <p>El estado de tu solicitud es: <strong><?php echo $estado; ?></strong></p>
        <button onclick="location.href='welcome_estudiante.php'">Regresar al Inicio</button>
    </div>

    <div class="footer">
        &copy; 2024 Administración del Préstamo de Salas de Cómputo. Todos los derechos reservados.
    </div>
</body>
</html>
