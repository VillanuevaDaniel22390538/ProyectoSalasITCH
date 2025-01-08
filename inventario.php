<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Inventario del Laboratorio de Cómputo</title>
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
            width: 80%;
            max-width: 800px;
            margin: auto;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            text-align: center;
        }
        .container h1 {
            color: #ffcc00; /* Color dorado para el título */
            margin-bottom: 20px;
        }
        .button-group {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
        }
        .button-group button {
            padding: 15px 30px;
            font-size: 18px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 200px;
            height: 100px;
        }
        .button-group button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        .button-group button i {
            margin-right: 10px;
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
        <h1>Gestión de Inventario del Laboratorio de Cómputo</h1>
        <div class="button-group">
            <button onclick="location.href='equipo_computo.php'">
                <i class="fas fa-desktop"></i> Equipo de Cómputo
            </button>
            <button onclick="location.href='mobiliario.php'">
                <i class="fas fa-chair"></i> Mobiliario
            </button>
            <button onclick="location.href='software.php'">
                <i class="fas fa-laptop-code"></i> Software
            </button>
            <button onclick="location.href='equipo_general.php'">
                <i class="fas fa-tools"></i> Equipo General
            </button>
        </div>
        <button class="back-button" onclick="location.href='welcome_administrador.php'">
            <i class="fas fa-arrow-left"></i> Regresar al Inicio
        </button>
    </div>
</body>
</html>