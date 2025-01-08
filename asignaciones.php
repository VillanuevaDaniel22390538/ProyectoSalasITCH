<?php
session_start(); // Inicia la sesión

// Verifica si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: index.php"); // Redirige al inicio de sesión si no está autenticado
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

// Consulta para obtener los docentes
$sql = "SELECT IDDocente, Nombres, PrimerApellido, SegundoApellido FROM Docente";
$stmt = $pdo->prepare($sql); // Prepara la consulta SQL
$stmt->execute(); // Ejecuta la consulta
$docentes = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtiene todos los resultados de la consulta en un array asociativo

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
    <title>Sistema de Reserva de Salas</title>
    <style>
        /* Estilos generales */
        body, html {
            margin: 0; /* Elimina los márgenes predeterminados del navegador */
            padding: 0; /* Elimina el relleno predeterminado del navegador */
            font-family: Arial, sans-serif; /* Establece la fuente para todo el documento */
            background-color: #f5f5f5; /* Establece el color de fondo para todo el documento */
        }

        /* Header */
        .header {
            background: #1e3c72; /* Color de fondo del encabezado */
            color: white; /* Color del texto del encabezado */
            padding: 1rem; /* Espaciado interno del encabezado */
            display: flex; /* Utiliza flexbox para el diseño del encabezado */
            justify-content: space-between; /* Distribuye el espacio entre los elementos del encabezado */
            align-items: center; /* Alinea los elementos del encabezado verticalmente al centro */
        }

        .user-info {
            display: flex; /* Utiliza flexbox para el diseño de la información del usuario */
            align-items: center; /* Alinea los elementos de la información del usuario verticalmente al centro */
            gap: 1rem; /* Espaciado entre los elementos de la información del usuario */
        }

        .logout-btn {
            background: transparent; /* Fondo transparente para el botón de cerrar sesión */
            border: 1px solid white; /* Borde blanco para el botón de cerrar sesión */
            color: white; /* Color del texto del botón de cerrar sesión */
            padding: 0.5rem 1rem; /* Espaciado interno del botón de cerrar sesión */
            border-radius: 4px; /* Bordes redondeados para el botón de cerrar sesión */
            cursor: pointer; /* Cambia el cursor al pasar sobre el botón de cerrar sesión */
        }

       /* Logos */
.logos {
    display: flex; /* Utiliza flexbox para el diseño de los logos */
    justify-content: space-between; /* Distribuye el espacio entre los logos */
    width: 90%; /* Ancho del contenedor de logos */
    max-width: 1200px; /* Ancho máximo del contenedor de logos */
    margin: 1rem auto; /* Margen superior e inferior de 1rem y centrado automático */
    background-color: #fff; /* Cambié el color de fondo */
    padding: 1rem; /* Espaciado interno del contenedor de logos */
    border-radius: 10px; /* Bordes redondeados del contenedor de logos */
}

.logos img {
    width: 60px; /* Ajusté el tamaño de los logos */
    height: 60px; /* Altura de los logos */
    border-radius: 50%; /* Bordes redondeados de los logos */
}

.logos img:nth-child(2) {
    width: 80px; /* Hice el logo ITCH más ancho */
}

/* Container principal */
.main-container {
    max-width: 1200px; /* Ancho máximo del contenedor principal */
    margin: 2rem auto; /* Margen superior e inferior de 2rem y centrado automático */
    padding: 0 1rem; /* Espaciado interno del contenedor principal */
    display: grid; /* Utiliza grid para el diseño del contenedor principal */
    grid-template-columns: 1fr; /* Define una columna */
    gap: 2rem; /* Espaciado entre los elementos del grid */
}

        /* Panel de reservas */
.booking-panel {
    background: white; /* Color de fondo del panel de reservas */
    border-radius: 10px; /* Bordes redondeados del panel de reservas */
    padding: 1.5rem; /* Espaciado interno del panel de reservas */
    box-shadow: 0 2px 10px rgba(0,0,0,0.1); /* Sombra del panel de reservas */
}

.room-grid {
    display: grid; /* Utiliza grid para el diseño de la cuadrícula de habitaciones */
    grid-template-columns: repeat(2, 1fr); /* Define dos columnas de igual tamaño */
    gap: 1rem; /* Espaciado entre los elementos de la cuadrícula de habitaciones */
    margin-top: 1rem; /* Margen superior de la cuadrícula de habitaciones */
}

.room-card {
    border: 1px solid #eee; /* Borde de las tarjetas de habitación */
    border-radius: 8px; /* Bordes redondeados de las tarjetas de habitación */
    padding: 1rem; /* Espaciado interno de las tarjetas de habitación */
    text-align: center; /* Alinea el texto de las tarjetas de habitación al centro */
}

.room-available {
    border-color: #28a745; /* Color del borde para habitaciones disponibles */
}

.room-occupied {
    border-color: #dc3545; /* Color del borde para habitaciones ocupadas */
    opacity: 0.7; /* Opacidad reducida para habitaciones ocupadas */
}

.book-btn {
    background: #28a745; /* Color de fondo del botón de reserva */
    color: white; /* Color del texto del botón de reserva */
    border: none; /* Sin borde para el botón de reserva */
    padding: 0.5rem 1rem; /* Espaciado interno del botón de reserva */
    border-radius: 4px; /* Bordes redondeados del botón de reserva */
    cursor: pointer; /* Cambia el cursor al pasar sobre el botón de reserva */
    margin-top: 0.5rem; /* Margen superior del botón de reserva */
}

.book-btn:disabled {
    background: #6c757d; /* Color de fondo del botón de reserva deshabilitado */
    cursor: not-allowed; /* Cursor no permitido para el botón de reserva deshabilitado */
}

       /* Modal */
.modal {
    display: none; /* Oculta el modal por defecto */
    position: fixed; /* Posiciona el modal de forma fija en la pantalla */
    top: 0; /* Posiciona el modal en la parte superior de la pantalla */
    left: 0; /* Posiciona el modal en la parte izquierda de la pantalla */
    width: 100%; /* Ancho completo de la pantalla */
    height: 100%; /* Altura completa de la pantalla */
    background: rgba(0,0,0,0.5); /* Fondo semitransparente para el modal */
    justify-content: center; /* Centra el contenido del modal horizontalmente */
    align-items: center; /* Centra el contenido del modal verticalmente */
}

.modal-content {
    background: white; /* Color de fondo del contenido del modal */
    padding: 0.5rem; /* Espaciado interno del contenido del modal */
    border-radius: 10px; /* Bordes redondeados del contenido del modal */
    max-width: 800px; /* Ancho máximo del contenido del modal */
    width: 100%; /* Ancho del contenido del modal */
    position: relative; /* Añadido para posicionar la tachita */
    display: flex; /* Utiliza flexbox para el diseño del contenido del modal */
    flex-direction: column; /* Coloca los elementos en una columna */
    gap: 0.1rem; /* Espaciado entre los elementos */
    max-height: 90vh; /* Altura máxima del modal */
    overflow-y: auto; /* Añadir scroll si el contenido es demasiado alto */
}

.modal-content label,
.modal-content input,
.modal-content select,
.modal-content textarea,
.modal-content button {
    margin-top: 0.1rem; /* Margen superior para los elementos */
    margin-bottom: 0.1rem; /* Margen inferior para los elementos */
    width: 50%; /* Ancho completo para los elementos */
}

.modal-content h2, .modal-content h3, .modal-content h4 {
    text-align: center; /* Centrar los encabezados */
    margin: 0.5rem 0; /* Margen superior e inferior para los encabezados */
}

.time-fields {
    display: flex; /* Utiliza flexbox para colocar los elementos en una fila */
    gap: 1rem; /* Espaciado entre los elementos */
}

.time-fields label,
.time-fields input {
    width: auto; /* Ajusta el ancho de los elementos */
    flex: 1; /* Permite que los elementos se expandan igualmente */
}

.time-slots {
    display: grid; /* Utiliza grid para el diseño de los intervalos de tiempo */
    grid-template-columns: repeat(3, 1fr); /* Define tres columnas de igual tamaño */
    gap: 0.5rem; /* Espaciado entre los intervalos de tiempo */
    margin: 1rem 0; /* Margen superior e inferior de 1rem */
}

.time-slot {
    padding: 0.5rem; /* Espaciado interno de los intervalos de tiempo */
    border: 1px solid #ddd; /* Borde de los intervalos de tiempo */
    border-radius: 4px; /* Bordes redondeados de los intervalos de tiempo */
    text-align: center; /* Alinea el texto de los intervalos de tiempo al centro */
    cursor: pointer; /* Cambia el cursor al pasar sobre los intervalos de tiempo */
}

.time-slot:hover {
    background: #f0f4ff; /* Color de fondo al pasar sobre los intervalos de tiempo */
}

.time-slot.selected {
    background: #1e3c72; /* Color de fondo para el intervalo de tiempo seleccionado */
    color: white; /* Color del texto para el intervalo de tiempo seleccionado */
}

.time-slot.booked {
    background: #dc3545; /* Color de fondo para el intervalo de tiempo reservado */
    color: white; /* Color del texto para el intervalo de tiempo reservado */
    cursor: not-allowed; /* Cursor no permitido para el intervalo de tiempo reservado */
}

.info-box { 
    background-color: #f9f9f9; /* Color de fondo del cuadro */ 
    border: 1px solid #ddd; /* Borde del cuadro */ 
    border-radius: 10px; /* Bordes redondeados del cuadro */ 
    padding: 1rem; /* Espaciado interno del cuadro */ 
    text-align: center; /* Centrar el texto del cuadro */ 
    margin-bottom: 1rem; /* Margen inferior del cuadro */ 
}

.hours-box { 
    background-color: #f9f9f9; /* Color de fondo del cuadro */ 
    border: 1px solid #ddd; /* Borde del cuadro */ 
    border-radius: 5px; /* Bordes redondeados del cuadro */ 
    padding: 0.5rem; /* Espaciado interno del cuadro */ 
    text-align: center; /* Centrar el texto del cuadro */ 
    margin-bottom: 0.5rem; /* Margen inferior del cuadro */ 
}

.status-box { 
    background-color: #f9f9f9; /* Color de fondo del cuadro */ 
    border: 1px solid #ddd; /* Borde del cuadro */ 
    border-radius: 10px; /* Bordes redondeados del cuadro */ 
    padding: 1rem; /* Espaciado interno del cuadro */ 
    text-align: center; /* Centrar el texto del cuadro */ 
    margin-bottom: 1rem; /* Margen inferior del cuadro */ 
}

.close-modal {
    position: absolute; /* Posiciona la tachita de forma absoluta */
    right: 1rem; /* Posiciona la tachita a la derecha */
    top: 1rem; /* Posiciona la tachita en la parte superior */
    background: none; /* Sin fondo para la tachita */
    border: none; /* Sin borde para la tachita */
    font-size: 1.5rem; /* Tamaño de fuente de la tachita */
    cursor: pointer; /* Cambia el cursor al pasar sobre la tachita */
}

.book-btn { 
    background: #1e3c72; 
    color: white; 
    padding: 0.5rem 1rem; 
    border: none; 
    border-radius: 4px; 
    cursor: pointer; 
    margin-top: 1rem; 
    display: block; /* Añadido para centrar el botón */ 
    margin: 1rem auto; /* Añadido para centrar el botón */ 
}
    </style>
</head>
<body>
<div class="logos"> <img src="imagenes/LogoTECNM.png" alt="Logo TECNM"> <img src="imagenes/LogoITCH.png" alt="Logo ITCH">
</div>
    <header class="header">
        <h1>Sistema de Reserva de Salas</h1>
        <div class="user-info">
            <span>Bienvenido, <?php echo htmlspecialchars($username); ?></span>
            <button class="logout-btn"onclick="location.href='logout.php'">Cerrar Sesión</button>
        </div>
    </header>

    <div class="main-container">
        <div class="booking-panel">
            <button class="nav-btn">Salas Disponibles</button>
            <h3 id="selected-date">Seleccione una fecha</h3>
            <div class="room-grid" id="room-grid">
                <!-- Las salas se llenarán dinámicamente -->
            </div>
            <button class="nav-btn" onclick="location.href='solicitarsala'">Solicitar una Sala</button>
            <button class="nav-btn" onclick="location.href='modificar_prestamo.php'">Modificar un préstamo de Sala</button>
        </div>
    </div>

   <!-- Modal de reserva -->
<div class="modal" id="booking-modal">
<div class="modal-content">
    <button class="close-modal">&times;</button>
    <h2>Reservar Sala</h2>
    <div class="info-box" id="modal-date-info">
        <!-- La fecha seleccionada se mostrará aquí -->
    </div>
    <!--<div class="hours-box">
        <label for="hora-inicio">Hora de Inicio:</label>
        <input type="time" id="hora-inicio">
        <label for="hora-fin">Hora de Fin:</label>
        <input type="time" id="hora-fin">
    </div>-->
    <div class="status-box">
        <label for="estado">Estado:</label>
        <input type="text" id="estado" readonly>
    </div>
    <h3 id="modal-room-info"></h3>
    <div class="time-slots">
        <!-- Los horarios se llenarán dinámicamente -->
    </div>
    <!--<div class="time-fields">
        <label for="hora-inicio">Hora de Inicio:</label>
        <input type="text" id="hora-inicio" readonly>
        <label for="hora-fin">Hora de Fin:</label>
        <input type="text" id="hora-fin" readonly>
    </div>-->
    <label for="docente">Docente:</label>
    <select id="docente">
        <?php foreach ($docentes as $docente): ?>
            <option value="<?php echo htmlspecialchars($docente['IDDocente']); ?>">
                <?php echo htmlspecialchars($docente['Nombres'] . ' ' . $docente['PrimerApellido'] . ' ' . $docente['SegundoApellido']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <label for="sala">Sala:</label>
    <div id="sala-seleccionada"></div>
    <div id="sala-capacidad"></div>
    <div id="sala-description" style="margin-top: 1rem; padding: 1rem; border: 1px solid #ddd; border-radius: 4px; background-color: #f9f9f9;">
        <!-- La descripción de la sala se llenará dinámicamente -->
    </div>
    <label for="observaciones">Observaciones:</label>
    <textarea id="observaciones" rows="3" style="width: 100%; height: 250px;"></textarea>
    <!-- Botón Confirmar Reserva -->
    <button class="book-btn" id="confirm-booking" style="display: block; margin: 1rem auto;">
        Confirmar Reserva
    </button>

    <script>
        document.getElementById('confirm-booking').addEventListener('click', function () {
            // Obtener valores del formulario
            const IDSala = document.getElementById('sala-seleccionada').getAttribute('data-id-sala');
            const IDDocente = document.getElementById('docente').value;
            const FechaPrestamo = document.getElementById('modal-date-info').textContent.trim(); // Formato YYYY-MM-DD
            const HoraInicio = getSelectedTimeSlot(); // Función para obtener la hora seleccionada
            const HoraFin = calculateEndTime(HoraInicio); // Calcula la Hora de Fin
            const Observaciones = document.getElementById('observaciones').value;
            const IDEstado = 2; // Estado fijo: Ocupado

            // Validación básica
            if (!IDSala || !IDDocente || !FechaPrestamo || !HoraInicio) {
                alert("Por favor, selecciona un horario válido.");
                return;
            }

            // Datos a enviar
            const data = {
                IDSala,
                IDDocente,
                FechaPrestamo,
                HoraInicio,
                HoraFin,
                Observaciones,
                IDEstado
            };

            // Enviar datos mediante fetch
            fetch('guardar_reserva.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    alert("Reserva realizada con éxito.");
                    // Cerrar el modal o refrescar la vista
                } else {
                    alert("Error al guardar la reserva. Inténtalo de nuevo.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("No se pudo conectar con el servidor.");
            });
        });

        /**
         * Obtiene la hora seleccionada en el menú interactivo de horarios.
         */
        function getSelectedTimeSlot() {
            // Busca el elemento seleccionado
            const selectedSlot = document.querySelector('.time-slot.selected'); // Asume que tienes una clase .selected
            return selectedSlot ? selectedSlot.getAttribute('data-hora-inicio') : null; // Obtén el atributo con la hora de inicio
        }

        /**
         * Calcula la Hora de Fin añadiendo 50 minutos a la Hora de Inicio.
         * @param {string} horaInicio - Hora en formato HH:MM
         * @returns {string} Hora de Fin en formato HH:MM
         */
        function calculateEndTime(horaInicio) {
            const [hours, minutes] = horaInicio.split(':').map(Number);
            const totalMinutes = hours * 60 + minutes + 50; // Sumar 50 minutos
            const endHours = Math.floor(totalMinutes / 60) % 24; // Manejo de ciclos de 24 horas
            const endMinutes = totalMinutes % 60;
            return `${String(endHours).padStart(2, '0')}:${String(endMinutes).padStart(2, '0')}`;
        }

        const salas = <?php echo json_encode($salas); ?>;

        let rooms = [
            { id: 1, name: 'Sala 1', available: true },
            { id: 2, name: 'Sala 2', available: true },
            { id: 3, name: 'Sala 3', available: true },
            { id: 4, name: 'Sala 4', available: true },
            { id: 5, name: 'Sala 5', available: true }
        ];

        class Calendar {
            constructor() {
                this.date = new Date();
                this.selectedDate = null;
                this.initCalendar();
                this.initEventListeners();
            }

            initCalendar() {
                this.updateCalendarHeader();
                this.renderCalendar();
            }

            updateCalendarHeader() {
                const months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 
                              'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                document.getElementById('current-month').textContent = 
                    `${months[this.date.getMonth()]} ${this.date.getFullYear()}`;
            }

            renderCalendar() {
                const firstDay = new Date(this.date.getFullYear(), this.date.getMonth(), 1);
                const lastDay = new Date(this.date.getFullYear(), this.date.getMonth() + 1, 0);
                const startDay = firstDay.getDay();
                const totalDays = lastDay.getDate();

                let html = '';
                for (let i = 0; i < Math.ceil((startDay + totalDays) / 7); i++) {
                    html += '<tr>';
                    for (let j = 0; j < 7; j++) {
                        const day = i * 7 + j - startDay + 1;
                        if (day > 0 && day <= totalDays) {
                            html += `<td class="calendar-day" data-date="${this.date.getFullYear()}-${this.date.getMonth() + 1}-${day}">${day}</td>`;
                        } else {
                            html += '<td></td>';
                        }
                    }
                    html += '</tr>';
                }
                document.getElementById('calendar-body').innerHTML = html;

                const today = new Date();
                if (this.date.getFullYear() === today.getFullYear() && this.date.getMonth() === today.getMonth()) {
                    const todayCell = document.querySelector(`[data-date="${today.getFullYear()}-${today.getMonth() + 1}-${today.getDate()}"]`);
                    if (todayCell) todayCell.classList.add('today');
                }
            }

            selectDate(date) {
                this.selectedDate = date;
                document.getElementById('selected-date').textContent = `Fecha seleccionada: ${date}`;
                this.showAvailableRooms();
            }

            showAvailableRooms() {
                const grid = document.getElementById('room-grid');
                grid.innerHTML = '';
                rooms.forEach(room => {
                    const roomDiv = document.createElement('div');
                    roomDiv.classList.add('room-card');
                    roomDiv.classList.add(room.available ? 'room-available' : 'room-occupied');
                    roomDiv.innerHTML = `<h4>${room.name}</h4>`;
                    if (room.available) {
                        const bookBtn = document.createElement('button');
                        bookBtn.classList.add('book-btn');
                        bookBtn.textContent = 'Reservar';
                        bookBtn.onclick = () => this.openBookingModal(room);
                        roomDiv.appendChild(bookBtn);
                    }
                    grid.appendChild(roomDiv);
                });
            }

            openBookingModal(room) {
                const selectedDateFormatted = this.formatDate(this.selectedDate);
                document.getElementById('modal-room-info').textContent = `Reserva para ${room.name}`;
                document.getElementById('modal-date-info').textContent = `Fecha: ${selectedDateFormatted}`;
                document.getElementById('booking-modal').style.display = 'flex';
                this.loadTimeSlots();
                this.showSalaSeleccionada(room.name);
                this.showSalaDescription(room.id);
                this.showSalaCapacidad(room.id);
            }

            formatDate(date) {
                const months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                const [year, month, day] = date.split('-');
                return `${day} de ${months[parseInt(month) - 1]} del ${year}`;
            }

            getEstadoDescripcion(estadoId) { 
                const estados = { 
                    1: 'Desocupado', 
                    2: 'Ocupado', 
                    3: 'Disponible', 
                    4: 'En Mantenimiento', 
                    5: 'Reservada', 
                    6: 'No disponible' 
                }; 
                return estados[estadoId] || 'Desconocido'; 
            }

            showSalaSeleccionada(selectedRoomName) {
                const salaSeleccionada = document.getElementById('sala-seleccionada');
                salaSeleccionada.textContent = selectedRoomName;
            }

            showSalaDescription(selectedRoomId) {
                const salaDescription = document.getElementById('sala-description');
                const selectedSala = salas.find(sala => sala.IDSala == selectedRoomId);
                salaDescription.textContent = selectedSala ? selectedSala.DescripcionSala : 'Descripción no disponible';
            }

            showSalaCapacidad(selectedRoomId) {
                const salaCapacidad = document.getElementById('sala-capacidad');
                const selectedSala = salas.find(sala => sala.IDSala == selectedRoomId);
                salaCapacidad.textContent = selectedSala ? `Capacidad: ${selectedSala.Capacidad}` : 'Capacidad no disponible';
            }

            loadTimeSlots() {
                const timeSlotsContainer = document.querySelector('.time-slots');
                timeSlotsContainer.innerHTML = '';
                for (let hour = 7; hour <= 22; hour++) {
                    const slot = document.createElement('div');
                    const time = `${hour < 10 ? '0' : ''}${hour}:00`;
                    slot.classList.add('time-slot');
                    slot.textContent = time;
                    slot.onclick = () => this.selectTimeSlot(slot);
                    timeSlotsContainer.appendChild(slot);
                }
            }

            selectTimeSlot(timeSlot) {
                const selectedSlot = document.querySelector('.time-slot.selected');
                if (selectedSlot) selectedSlot.classList.remove('selected');
                timeSlot.classList.add('selected');
                document.getElementById('confirm-booking').onclick = () => this.confirmBooking(timeSlot);
            }

            confirmBooking(timeSlot) {
                const selectedTime = timeSlot.textContent;
                const selectedDate = this.selectedDate;
                const selectedRoomId = document.getElementById('sala-seleccionada').getAttribute('data-id');
                const selectedDocenteId = document.getElementById('docente').value;
                const observaciones = document.getElementById('observaciones').value;
                const estado = document.getElementById('estado').value;

                // Calcular la hora de fin (50 minutos después de la hora de inicio)
                const [hour, minute] = selectedTime.split(':');
                const horaInicio = `${hour}:${minute}:00`;
                const horaFin = `${parseInt(hour) + 1}:${minute}:00`;

                // Crear un objeto con los datos de la reserva
                const reserva = {
                    IDSala: selectedRoomId,
                    IDDocente: selectedDocenteId,
                    FechaPrestamo: selectedDate,
                    HoraInicio: horaInicio,
                    HoraFin: horaFin,
                    Observaciones: observaciones,
                    IDEstado: estado
                };

                // Enviar los datos al servidor para guardarlos en la base de datos
                fetch('guardar_reserva.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(reserva)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(`Reserva confirmada para ${selectedDate} a las ${selectedTime}.`);
                        timeSlot.classList.add('booked');
                        timeSlot.classList.remove('selected');
                        timeSlot.onclick = null; // Deshabilita la selección de la hora
                        document.getElementById('booking-modal').style.display = 'none';
                    } else {
                        alert('Error al guardar la reserva. Por favor, inténtelo de nuevo.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al guardar la reserva. Por favor, inténtelo de nuevo.');
                });
            }

            initEventListeners() {
                document.getElementById('prev-month').addEventListener('click', () => this.changeMonth(-1));
                document.getElementById('next-month').addEventListener('click', () => this.changeMonth(1));

                document.querySelectorAll('.calendar-day').forEach(day => {
                    day.addEventListener('click', () => this.selectDate(day.getAttribute('data-date')));
                });

                document.querySelector('.close-modal').addEventListener('click', () => {
                    document.getElementById('booking-modal').style.display = 'none';
                });
            }

            changeMonth(offset) {
                this.date.setMonth(this.date.getMonth() + offset);
                this.initCalendar();
            }
        }
       
        document.addEventListener('DOMContentLoaded', () => { 
            const calendar = new Calendar(); 
        });
    </script>
</body>
</html>