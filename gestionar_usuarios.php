<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Usuarios</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-image: url('imagenes/fondo.jpg'); /* Fondo similar al de index */
            background-size: cover;
            background-position: center;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: rgba(0, 0, 0, 0.7); /* Fondo semitransparente */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            text-align: center;
            width: 90%;
            max-width: 800px;
            color: white;
        }
        .title {
            font-size: 28px;
            margin-bottom: 20px;
            color: #ffcc00; /* Color dorado para el título */
        }
        .user-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .user-button {
            background-color: #007bff;
            color: white;
            padding: 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 150px;
        }
        .user-button:hover {
            background-color: #0056b3;
        }
        .user-button img {
            width: 50px;
            height: 50px;
            margin-bottom: 10px;
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
</head>
<body>
<a href="javascript:history.back()" class="back-arrow">&#x2190; </a>

    <div class="container">
        <div class="title">Gestionar Usuarios</div>
        <div class="user-buttons">
        <button class="user-button" onclick="window.open('usuario_detalle.php?tipo=coordinador', '_blank', 'width=800,height=600')">
    <img src="imagenes/coordinador_icon.png" alt="Coordinador">
    Coordinador
</button>
<button class="user-button" onclick="window.open('usuario_detalle.php?tipo=docente', '_blank', 'width=800,height=600')">
    <img src="imagenes/docente_icon.png" alt="Docente">
    Docente
</button>
<button class="user-button" onclick="window.open('usuario_detalle.php?tipo=encargado', '_blank', 'width=800,height=600')">
    <img src="imagenes/encargado_icon.png" alt="Encargado">
    Encargado
</button>
<button class="user-button" onclick="window.open('usuario_detalle.php?tipo=estudiante', '_blank', 'width=800,height=600')">
    <img src="imagenes/estudiante_icon.png" alt="Estudiante">
    Estudiante
</button>
<button class="user-button" onclick="window.open('usuario_detalle.php?tipo=jefe_departamento', '_blank', 'width=800,height=600')">
    <img src="imagenes/jefe_departamento_icon.png" alt="Jefe Departamento">
    Jefe Departamento
</button>
<button class="user-button" onclick="window.open('usuario_detalle.php?tipo=personal_laboratorio', '_blank', 'width=800,height=600')">
    <img src="imagenes/personal_laboratorio_icon.png" alt="Personal Laboratorio">
    Personal Laboratorio
</button>
<button class="user-button" onclick="window.open('usuario_detalle.php?tipo=usuario_general', '_blank', 'width=800,height=600')">
    <img src="imagenes/personal_laboratorio_icon.png" alt="Usuario General">
    Usuarios Generales
</button>

        </div>
    </div>
</body>
</html>
