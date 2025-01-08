<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Datos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
            margin: auto;
            text-align: center;
        }
        .container h1 {
            color: #007bff;
            margin-bottom: 20px;
        }
        .container a {
            display: block;
            margin: 10px 0;
            padding: 10px;
            background-color: orange;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .container a:hover {
            background-color: darkorange;
        }
        .container button {
            margin-top: 20px;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Añadir Datos</h1>
        <a href="datos_personales.php">Añadir Datos Personales</a>
        <a href="informacion_academica.php">Información Académica</a>
        <a href="informacion_medica.php">Información Médica</a>
        <button onclick="window.location.href='welcome_docente.php'">Regresar</button>
    </div>
</body>
</html>