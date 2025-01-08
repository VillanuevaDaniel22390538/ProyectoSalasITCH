<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Usuario</title>
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
    </style>
</head>
<body>
    <div class="container">
        <div class="title">Detalle del Usuario</div>
        <div class="user-buttons">
            <?php
            $tipo = $_GET['tipo'];
            $botones = [
                'coordinador' => [
                    ['url' => 'gestionar_datos_personales_coordinador.php', 'img' => 'imagenes/datos_personales_icon.png', 'text' => 'Datos Personales'],
                    ['url' => 'historial_academico_coordinador.php', 'img' => 'imagenes/historial_academico_icon.png', 'text' => 'Historial Académico'],
                    ['url' => 'informacion_medica_coordinador.php', 'img' => 'imagenes/informacion_medica_icon.png', 'text' => 'Información Médica'],
                    ['url' => 'total_coordinador.php', 'img' => 'imagenes/total_icon.png', 'text' => 'Total']
                ],
                'encargado' => [
                    ['url' => 'gestionar_datos_personales_encargado.php', 'img' => 'imagenes/datos_personales_icon.png', 'text' => 'Datos Personales'],
                    ['url' => 'historial_academico_encargado.php', 'img' => 'imagenes/historial_academico_icon.png', 'text' => 'Historial Académico'],
                    ['url' => 'informacion_medica_encargado.php', 'img' => 'imagenes/informacion_medica_icon.png', 'text' => 'Información Médica'],
                    ['url' => 'total_encargado.php', 'img' => 'imagenes/total_icon.png', 'text' => 'Total']
                ],
                'estudiante' => [
                    ['url' => 'gestionar_datos_personales_estudiante.php', 'img' => 'imagenes/datos_personales_icon.png', 'text' => 'Datos Personales'],
                    ['url' => 'historial_academico_estudiante.php', 'img' => 'imagenes/historial_academico_icon.png', 'text' => 'Historial Académico'],
                    ['url' => 'informacion_medica_estudiante.php', 'img' => 'imagenes/informacion_medica_icon.png', 'text' => 'Información Médica'],
                    ['url' => 'total_estudiante.php', 'img' => 'imagenes/total_icon.png', 'text' => 'Total']
                ],
                'jefe_departamento' => [
                    ['url' => 'gestionar_datos_personales_jefe_departamento.php', 'img' => 'imagenes/datos_personales_icon.png', 'text' => 'Datos Personales'],
                    ['url' => 'historial_academico_jefe_departamento.php', 'img' => 'imagenes/historial_academico_icon.png', 'text' => 'Historial Académico'],
                    ['url' => 'informacion_medica_jefe_departamento.php', 'img' => 'imagenes/informacion_medica_icon.png', 'text' => 'Información Médica'],
                    ['url' => 'total_jefe_departamento.php', 'img' => 'imagenes/total_icon.png', 'text' => 'Total']
                ],
                'personal_laboratorio' => [
                    ['url' => 'gestionar_datos_personales_personal_laboratorio.php', 'img' => 'imagenes/datos_personales_icon.png', 'text' => 'Datos Personales'],
                    ['url' => 'historial_academico_personal_laboratorio.php', 'img' => 'imagenes/historial_academico_icon.png', 'text' => 'Historial Académico'],
                    ['url' => 'informacion_medica_personal_laboratorio.php', 'img' => 'imagenes/informacion_medica_icon.png', 'text' => 'Información Médica'],
                    ['url' => 'total_personal_laboratorio.php', 'img' => 'imagenes/total_icon.png', 'text' => 'Total']
                ],
                'docente' => [
                    ['url' => 'gestionar_datos_personales_docente.php', 'img' => 'imagenes/datos_personales_icon.png', 'text' => 'Datos Personales'],
                    ['url' => 'historial_academico_docente.php', 'img' => 'imagenes/historial_academico_icon.png', 'text' => 'Historial Académico'],
                    ['url' => 'informacion_medica_docente.php', 'img' => 'imagenes/informacion_medica_icon.png', 'text' => 'Información Médica'],
                    ['url' => 'total_docente.php', 'img' => 'imagenes/total_icon.png', 'text' => 'Total']
                ],
                'usuario_general' => [
                    ['url' => 'añadir_usuario.php', 'img' => 'imagenes/datos_personales_icon.png', 'text' => 'Añadir Usuarios'],
                    ['url' => 'editar_usuarios.php', 'img' => 'imagenes/historial_academico_icon.png', 'text' => 'Editar Usuarios Existentes'],
                    ['url' => 'eliminar_usuarios.php', 'img' => 'imagenes/informacion_medica_icon.png', 'text' => 'Eliminar Usuarios'],
                ]
            ];

            foreach ($botones[$tipo] as $boton) {
                echo "<button class='user-button' onclick=\"window.location.href='{$boton['url']}'\">
                        <img src='{$boton['img']}' alt='{$boton['text']}'>
                        {$boton['text']}
                      </button>";
            }
            ?>
        </div>
    </div>
</body>
</html>