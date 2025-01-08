<?php
session_start(); // Inicia la sesión para almacenar datos del usuario

// Verificar si el ID del docente está definido en la sesión
if (isset($_SESSION['idDocente'])) {
    $idDocente = $_SESSION['idDocente'];
} else {
    // Redirigir al inicio de sesión si no está definido
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Reserva de Sala</title>
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
            background-color: rgba(0, 0, 0, 0.7); /* Fondo semitransparente */
            padding: 40px;
            border-radius: 10px;
            width: 80%;
            max-width: 600px;
            text-align: center;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
        }
        .container h1 {
            color: #ffcc00; /* Color dorado para el título */
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            font-weight: bold;
        }
        .input-group input,
        .input-group select,
        .input-group textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px; /* Separar los botones */
            transition: background-color 0.3s;
        }
        .container button:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function validateForm() {
            const fechaPrestamo = document.getElementById('fechaPrestamo').value;
            const horaInicio = document.getElementById('horaInicio').value;
            const horaFin = document.getElementById('horaFin').value;

            const today = new Date().toISOString().split('T')[0];
            
            if (fechaPrestamo < today) {
                alert('La fecha de préstamo no puede ser en el pasado.');
                return false;
            }

            const horaRegex = /^([01]\d|2[0-3]):00$/;

            if (!horaRegex.test(horaInicio) || !horaRegex.test(horaFin)) {
                alert('Las horas deben estar en formato HH:00.');
                return false;
            }

            if (horaInicio >= horaFin) {
                alert('La hora de inicio debe ser anterior a la hora de fin.');
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Solicitar Reserva de Sala</h1>
        <form action="procesar_reserva.php" method="POST" onsubmit="return validateForm()">
            <div class="input-group">
                <label for="sala">Sala:</label>
                <select id="sala" name="sala" required>
                    <option value="">Selecciona una sala</option>
                    <option value="1">Sala 1</option>
                    <option value="2">Sala 2</option>
                    <option value="3">Sala 3</option>
                    <option value="4">Sala 4</option>
                    <option value="5">Sala 5</option>
                </select>
            </div>

            <div class="input-group">
                <label for="idDocente">ID Docente:</label>
                <input type="text" id="idDocente" name="idDocente" value="<?php echo htmlspecialchars($idDocente); ?>" readonly required>
            </div>

            <div class="input-group">
                <label for="fechaPrestamo">Fecha de Préstamo:</label>
                <input type="date" id="fechaPrestamo" name="fechaPrestamo" required>
            </div>

            <div class="input-group">
                <label for="horaInicio">Hora de Inicio:</label>
                <input type="time" id="horaInicio" name="horaInicio" required step="3600">
            </div>

            <div class="input-group">
                <label for="horaFin">Hora de Fin:</label>
                <input type="time" id="horaFin" name="horaFin" required step="3600">
            </div>

            <div class="input-group">
                <label for="observaciones">Observaciones:</label>
                <textarea id="observaciones" name="observaciones"></textarea>
            </div>

            <button type="submit">Reservar Sala</button>
            <button onclick="window.location.href='welcome_docente.php'">Regresar</button>
        </form>
    </div>
</body>
</html>
