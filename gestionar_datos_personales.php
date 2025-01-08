<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Datos Personales</title>
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
        .form-group {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        .form-group label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
            max-width: 300px;
        }
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between;
        }
        .buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
        }
        .button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #0056b3;
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
        <div class="title">Gestionar Datos Personales</div>
        <div class="form-group">
            <label for="buscar-id">Buscar por ID de Usuario</label>
            <input type="text" id="buscar-id" name="buscarId">
            <button type="button" class="button" onclick="buscarPorId()">Buscar</button>
        </div>
        <div class="form-group">
            <label for="lista-usuarios">Buscar por Lista de Usuarios</label>
            <select id="lista-usuarios" name="listaUsuarios" onchange="buscarPorLista()">
                <!-- Opciones de usuarios se llenarán dinámicamente -->
            </select>
        </div>
        <form id="datos-personales-form">
            <div class="form-row">
                <div class="form-group">
                    <label for="id-usuario">ID Usuario</label>
                    <input type="text" id="id-usuario" name="idUsuario" required>
                </div>
                <div class="form-group">
                    <label for="nombres">Nombres</label>
                    <input type="text" id="nombres" name="nombres" required>
                </div>
                <div class="form-group">
                    <label for="primer-apellido">Primer Apellido</label>
                    <input type="text" id="primer-apellido" name="primerApellido" required>
                </div>
                <div class="form-group">
                    <label for="segundo-apellido">Segundo Apellido</label>
                    <input type="text" id="segundo-apellido" name="segundoApellido" required>
                </div>
                <div class="form-group">
                    <label for="fecha-nacimiento">Fecha de Nacimiento</label>
                    <input type="date" id="fecha-nacimiento" name="fechaNacimiento" required>
                </div>
                <div class="form-group">
                    <label for="curp">CURP</label>
                    <input type="text" id="curp" name="curp" required>
                </div>
                <div class="form-group">
                    <label for="rfc">RFC</label>
                    <input type="text" id="rfc" name="rfc" required>
                </div>
                <div class="form-group">
                    <label for="numero-celular">Número de Celular</label>
                    <input type="text" id="numero-celular" name="numeroCelular" required>
                </div>
                <div class="form-group">
                    <label for="telefono-casa">Teléfono de Casa</label>
                    <input type="text" id="telefono-casa" name="telefonoCasa">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="calle">Calle</label>
                    <input type="text" id="calle" name="calle" required>
                </div>
                <div class="form-group">
                    <label for="interseccion-primera">Intersección Primera</label>
                    <input type="text" id="interseccion-primera" name="interseccionPrimera" required>
                </div>
                <div class="form-group">
                    <label for="interseccion-segunda">Intersección Segunda</label>
                    <input type="text" id="interseccion-segunda" name="interseccionSegunda" required>
                </div>
                <div class="form-group">
                    <label for="num-exterior">Número Exterior</label>
                    <input type="text" id="num-exterior" name="numExterior" required>
                </div>
                <div class="form-group">
                    <label for="num-interior">Número Interior</label>
                    <input type="text" id="num-interior" name="numInterior">
                </div>
                <div class="form-group">
                    <label for="codigo-postal">Código Postal</label>
                    <input type="text" id="codigo-postal" name="codigoPostal" required>
                </div>
                <div class="form-group">
                    <label for="colonia">Colonia</label>
                    <input type="text" id="colonia" name="colonia">
                </div>
                <div class="form-group">
                    <label for="localidad">Localidad</label>
                    <input type="text" id="localidad" name="localidad">
                </div>
                <div class="form-group">
                    <label for="municipio">Municipio</label>
                    <input type="text" id="municipio" name="municipio">
                </div>
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <input type="text" id="estado" name="estado">
                </div>
            </div>
            <div class="buttons">
                <button type="button" class="button" onclick="insertarDatos()">Insertar</button>
                <button type="button" class="button" onclick="editarDatos()">Editar</button>
                <button type="button" class="button" onclick="eliminarDatos()">Eliminar</button>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Cargar la lista de usuarios desde la base de datos
            fetch('obtener_usuarios.php')
                .then(response => response.json())
                .then(data => {
                    const listaUsuarios = document.getElementById('lista-usuarios');
                    data.forEach(usuario => {
                        const option = document.createElement('option');
                        option.value = usuario.idUsuario;
                        option.textContent = `${usuario.nombres} ${usuario.primerApellido} ${usuario.segundoApellido}`;
                        listaUsuarios.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error al obtener los usuarios:', error);
                });
        });

        function buscarPorId() {
            const idUsuario = document.getElementById('buscar-id').value;
            fetch(`obtener_datos_personales.php?idUsuario=${idUsuario}`)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        rellenarFormulario(data);
                    } else {
                        alert('Usuario no encontrado');
                    }
                })
                .catch(error => {
                    console.error('Error al buscar por ID:', error);
                });
        }

        function buscarPorLista() {
            const idUsuario = document.getElementById('lista-usuarios').value;
            fetch(`obtener_datos_personales.php?idUsuario=${idUsuario}`)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        rellenarFormulario(data);
                    } else {
                        alert('Usuario no encontrado');
                    }
                })
                .catch(error => {
                    console.error('Error al buscar por lista:', error);
                });
        }

        function rellenarFormulario(data) {
            document.getElementById('id-usuario').value = data.idUsuario;
            document.getElementById('nombres').value = data.nombres;
            document.getElementById('primer-apellido').value = data.primerApellido;
            document.getElementById('segundo-apellido').value = data.segundoApellido;
            document.getElementById('fecha-nacimiento').value = data.fechaNacimiento;
            document.getElementById('curp').value = data.curp;
            document.getElementById('rfc').value = data.rfc;
            document.getElementById('numero-celular').value = data.numeroCelular;
            document.getElementById('telefono-casa').value = data.telefonoCasa;
            document.getElementById('email').value = data.email;
            document.getElementById('calle').value = data.calle;
            document.getElementById('interseccion-primera').value = data.interseccionPrimera;
            document.getElementById('interseccion-segunda').value = data.interseccionSegunda;
            document.getElementById('num-exterior').value = data.numExterior;
            document.getElementById('num-interior').value = data.numInterior;
            document.getElementById('codigo-postal').value = data.codigoPostal;
            document.getElementById('colonia').value = data.colonia;
            document.getElementById('localidad').value = data.localidad;
            document.getElementById('municipio').value = data.municipio;
            document.getElementById('estado').value = data.estado;
        }

        function insertarDatos() {
            const formData = new FormData(document.getElementById('datos-personales-form'));
            fetch('insertar_datos.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Datos insertados correctamente');
                } else {
                    alert('Error al insertar datos');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al insertar datos');
            });
        }

        function editarDatos() {
            const formData = new FormData(document.getElementById('datos-personales-form'));
            fetch('editar_datos.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Datos editados correctamente');
                } else {
                    alert('Error al editar datos');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al editar datos');
            });
        }

        function eliminarDatos() {
            const formData = new FormData(document.getElementById('datos-personales-form'));
            fetch('eliminar_datos.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Datos eliminados correctamente');
                } else {
                    alert('Error al eliminar datos');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al eliminar datos');
            });
        }
    </script>
</body>
</html>
