Use master 
GO

-- Crear la base de datos
CREATE DATABASE ProyectoSalasITCH;
GO

-- Usar la base de datos
USE ProyectoSalasITCH;
---------------|Tipo Usuario|-------------------
-- Tabla TipoDeUsuarios
CREATE TABLE TipoDeUsuarios (
    TipoDeUsuarioId INT PRIMARY KEY IDENTITY(1,1),
    NombreUsuario NVARCHAR(50) NOT NULL UNIQUE
);
-- Insertar los tipos de usuario
INSERT INTO TipoDeUsuarios (NombreUsuario) VALUES 
('Estudiante'),
('Docente'),
('Coordinador'),
('JefeDepartamento'),
('Administrador'),
('Personal'),
('Encargado');

------------------------------------------------
------------|Tabla Usuarios|--------------------
------------------------------------------------
-- Tabla Usuarios
CREATE TABLE Usuarios (
    idUsuario INT PRIMARY KEY IDENTITY(1,1), --Numero de identificacion del usuario
    NombreUsuario NVARCHAR(50) NOT NULL UNIQUE, --nombre del usuario sera con el numero del control
    emailUsuario NVARCHAR(50) NOT NULL UNIQUE, --email sera correo institucional
    passsword NVARCHAR(255) NOT NULL, --Contraseña del usuario
    TipoDeUsuarioId INT NOT NULL, -- Llave foránea para TipoDeUsuarios
    FOREIGN KEY (TipoDeUsuarioId) REFERENCES TipoDeUsuarios(TipoDeUsuarioId)
);

------------------------------------------------
--------------|Tablas Estudiante|----------------
------------------------------------------------

-- Tabla InformacionPersonalEstudiante
CREATE TABLE Estudiante (
    NumeroControl NVARCHAR(9) PRIMARY KEY NOT NULL,
    idUsuario INT FOREIGN KEY REFERENCES Usuarios(idUsuario),
    Nombres VARCHAR(50) NOT NULL,
    PrimerApellido VARCHAR(50) NOT NULL,
    SegundoApellido VARCHAR(50) NOT NULL,
    FechaNacimiento DATE NOT NULL,
    CURP VARCHAR(18) NOT NULL,
    RFC VARCHAR(13) NOT NULL,
    NumeroCelular NVARCHAR(15) NOT NULL,
    TelefonoCasa NVARCHAR(15) NULL,
    Email NVARCHAR(50) NOT NULL,
    Calle VARCHAR(100) NOT NULL,
    InterseccionPrimera VARCHAR(100) NOT NULL,
    InterseccionSegunda VARCHAR(100) NOT NULL,
    NumExterior VARCHAR(10) NOT NULL,
    NumInterior VARCHAR(10) NULL,
    CodigoPostal CHAR(5) NOT NULL,
    Colonia VARCHAR(100) NULL,
    Localidad VARCHAR(100) NULL,
    Municipio VARCHAR(100) NULL,
    Estado VARCHAR(100) NULL,
    TipoDeUsuarioId INT NOT NULL, -- Llave foránea para TipoDeUsuarios
    FOREIGN KEY (TipoDeUsuarioId) REFERENCES TipoDeUsuarios(TipoDeUsuarioId)
);


-- Tabla InformacionAcademicaEstudiante
CREATE TABLE InformacionAcademicaEstudiante (
    IDInformacionAcademica_EST INT PRIMARY KEY IDENTITY(1,1),
    NumeroControl NVARCHAR(9) FOREIGN KEY REFERENCES Estudiante(NumeroControl) NOT NULL,
    IDCarrera INT FOREIGN KEY REFERENCES Carrera(IDCarrera) NOT NULL,
    IDCreditosComplementarios INT FOREIGN KEY REFERENCES CreditosComplementarios(IDCreditosComplementarios) NULL,
	CorreoInstitucional NVARCHAR(50) NOT NULL,
	PromedioGeneral DECIMAL(5, 2) NULL
);

-- Tabla Carrera
CREATE TABLE Carrera (
    IDCarrera INT PRIMARY KEY IDENTITY(1,1),
    NombreCarrera VARCHAR(100) NOT NULL,
    DescripcionCarrera VARCHAR(255) NULL
); -- En esta tabla se van a agregar todas las carreras del ITCH.

-- Tabla CreditosComplementarios
CREATE TABLE CreditosComplementarios (
    IDCreditosComplementarios INT PRIMARY KEY IDENTITY(1,1),
    IDTipo INT FOREIGN KEY REFERENCES TipoCredito(IDTipo) NOT NULL,
    Total DECIMAL(3, 2) NOT NULL
); -- En esta tabla es para saber el total de créditos complementarios que lleva el alumno.

-- Tabla TipoCredito
CREATE TABLE TipoCredito (
    IDTipo INT PRIMARY KEY IDENTITY(1,1),
    DescripcionCredito VARCHAR(100) NOT NULL
); -- Tabla consecuente de Creditos Complementarios, para saber qué tipo de créditos posee el alumno.


-- Tabla HistorialAcademicoEstudiante
CREATE TABLE HistorialAcademicoEstudiante (
    IDHistorialAcademico_EST INT PRIMARY KEY IDENTITY(1,1),
    NumeroControl NVARCHAR(9) FOREIGN KEY REFERENCES Estudiante(NumeroControl) NOT NULL,
    IDAsignatura INT FOREIGN KEY REFERENCES Asignaturas(IDAsignatura) NOT NULL,
    TotalPromedio DECIMAL(5, 2) NULL,
    Semestre INT NOT NULL,
    IDStatusAsignatura INT FOREIGN KEY REFERENCES StatusAsignatura(IDStatusAsignatura) NOT NULL,
    IDCreditosComplementarios INT FOREIGN KEY REFERENCES CreditosComplementarios(IDCreditosComplementarios) NULL
);

-- Tabla StatusAsignatura
CREATE TABLE StatusAsignatura (
    IDStatusAsignatura INT PRIMARY KEY IDENTITY(1,1),
    Estado VARCHAR(50) NOT NULL
);

-- Tabla Asignaturas
CREATE TABLE Asignaturas (
    IDAsignatura INT PRIMARY KEY IDENTITY(1,1),
    NombreAsignatura VARCHAR(100) NOT NULL,
    DescripcionAsignatura VARCHAR(255) NULL,
    HorasTotales INT NOT NULL,
    Creditos DECIMAL(3, 1) NOT NULL
);

-- Tabla InformacionMedicaEstudiante
CREATE TABLE InformacionMedicaEstudiante (
    IDInformacionMedica_EST INT PRIMARY KEY IDENTITY(1,1),
    NumeroControl NVARCHAR(9) FOREIGN KEY REFERENCES Estudiante(NumeroControl) NOT NULL,
    IDAlergias INT FOREIGN KEY REFERENCES Alergias(IDAlergias) NULL,
    IDEnfermedadesCronicas INT FOREIGN KEY REFERENCES EnfermedadesCronicas(IDEnfermedadesCronicas) NULL,
    IDTipoSangre INT FOREIGN KEY REFERENCES TipoSangre(IDTipoSangre) NOT NULL
);
INSERT INTO InformacionMedicaEstudiante (NumeroControl, IDAlergias, IDEnfermedadesCronicas, IDTipoSangre)
VALUES ('22390539', 1, 1, 1);

--------------------------------------------------------
-------------------|Tablas Medicas|---------------------
--------------------------------------------------------

-- Tabla Alergias
CREATE TABLE Alergias (
    IDAlergias INT PRIMARY KEY IDENTITY(1,1),
    NombreAlergia VARCHAR(100) NOT NULL,
    DescripcionAlergia VARCHAR(255) NULL
);

-- Tabla EnfermedadesCronicas
CREATE TABLE EnfermedadesCronicas (
    IDEnfermedadesCronicas INT PRIMARY KEY IDENTITY(1,1),
    NombreEnfermedad VARCHAR(100) NOT NULL,
    DescripcionEnfermedad VARCHAR(255) NULL
);

-- Tabla TipoSangre
CREATE TABLE TipoSangre (
    IDTipoSangre INT PRIMARY KEY IDENTITY(1,1),
    NombreTipoSangre VARCHAR(50) NOT NULL
); -- En esta tabla se agregan los tipos de sangre para seleccionar------------

-- Insertar datos en la tabla Alergias
INSERT INTO Alergias (NombreAlergia, DescripcionAlergia) VALUES
('Polen', 'Reacción alérgica al polen de las plantas'),
('Ácaros del polvo', 'Reacción alérgica a los ácaros presentes en el polvo doméstico'),
('Alimentos', 'Reacción alérgica a ciertos alimentos como nueces, mariscos, etc.'),
('Medicamentos', 'Reacción alérgica a ciertos medicamentos como penicilina'),
('Picaduras de insectos', 'Reacción alérgica a las picaduras de insectos como abejas y avispas'),
('No aplica', 'No presenta alergias conocidas');

-- Insertar datos en la tabla EnfermedadesCronicas
INSERT INTO EnfermedadesCronicas (NombreEnfermedad, DescripcionEnfermedad) VALUES
('Diabetes', 'Enfermedad crónica que afecta la forma en que el cuerpo procesa la glucosa en sangre'),
('Hipertensión', 'Enfermedad crónica caracterizada por la elevación persistente de la presión arterial'),
('Asma', 'Enfermedad crónica que afecta las vías respiratorias y causa dificultad para respirar'),
('Artritis', 'Enfermedad crónica que causa inflamación y dolor en las articulaciones'),
('Enfermedad cardíaca', 'Enfermedad crónica que afecta el corazón y los vasos sanguíneos'),
('No aplica', 'No presenta enfermedades crónicas conocidas');

-- Insertar datos en la tabla TipoSangre
INSERT INTO TipoSangre (NombreTipoSangre) VALUES
('A+'),
('A-'),
('B+'),
('B-'),
('AB+'),
('AB-'),
('O+'),
('O-');




------------------------------------------------------
----------|Tabla Departamento Academico|--------------
------------------------------------------------------

-- Tabla DepartamentoAcademico
CREATE TABLE DepartamentoAcademico (
    IDDepartamentoAcademico INT PRIMARY KEY IDENTITY(1,1),
    NombreDepartamento VARCHAR(100) NOT NULL,
    DescripcionDepartamento TEXT NULL
);

-------------------------------------------------------
----------------| Tablas de Docente |------------------
-------------------------------------------------------

-- Tabla Docente
CREATE TABLE Docente (
    IDDocente NVARCHAR(10) PRIMARY KEY NOT NULL,
	idUsuario INT FOREIGN KEY REFERENCES Usuarios(idUsuario),
    Nombres VARCHAR(50) NOT NULL,
    PrimerApellido VARCHAR(50) NOT NULL,
    SegundoApellido VARCHAR(50) NOT NULL,
    FechaNacimiento DATE NOT NULL,
    CURP VARCHAR(18) NOT NULL,
    RFC VARCHAR(13) NOT NULL,
    NumeroCelular NVARCHAR(15) NOT NULL,
    TelefonoCasa NVARCHAR(15) NULL,
    Email NVARCHAR(50) NOT NULL,
    Calle VARCHAR(100) NOT NULL,
    InterseccionPrimera VARCHAR(100) NOT NULL,
    InterseccionSegunda VARCHAR(100) NOT NULL,
    NumExterior VARCHAR(10) NOT NULL,
    NumInterior VARCHAR(10) NULL,
    CodigoPostal CHAR(5) NOT NULL,
    Colonia VARCHAR(100) NULL,
    Localidad VARCHAR(100) NULL,
    Municipio VARCHAR(100) NULL,
    Estado VARCHAR(100) NULL,
    TipoDeUsuarioId INT NOT NULL, -- Llave foránea para TipoDeUsuarios
    FOREIGN KEY (TipoDeUsuarioId) REFERENCES TipoDeUsuarios(TipoDeUsuarioId)
);


-- Tabla InformacionAcademicaDocente
CREATE TABLE InformacionAcademicaDocente (
    IDInformacionAcademica_DOC INT PRIMARY KEY IDENTITY(1,1),
    IDDocente NVARCHAR(10) FOREIGN KEY REFERENCES Docente(IDDocente) NOT NULL,
    CorreoInstitucional NVARCHAR(50) NOT NULL,
    IDGrado INT FOREIGN KEY REFERENCES GradoAcademico(IDGrado) NOT NULL,
    IDDepartamentoAcademico INT FOREIGN KEY REFERENCES DepartamentoAcademico(IDDepartamentoAcademico) NOT NULL
);

-- Tabla GradoAcademico
CREATE TABLE GradoAcademico (
    IDGrado INT PRIMARY KEY IDENTITY(1,1),
    Nivel VARCHAR(50) NOT NULL,  -- Ej: Licenciatura, Maestría, Doctorado
    Universidad VARCHAR(100) NOT NULL,
    Cedula VARCHAR(50) NOT NULL
);

INSERT INTO GradoAcademico (Nivel, Universidad, Cedula) VALUES
('Licenciatura', 'Universidad', '1234567890'),
('Maestría', 'Universidad', '0987654321'),
('Doctorado', 'Universidad', '1122334455');


--Tabla Información Medica del Docente
CREATE TABLE InformacionMedicaDocente (
    IDInformacionMedica_DOC INT PRIMARY KEY IDENTITY(1,1),
    IDDocente NVARCHAR(10) FOREIGN KEY REFERENCES Docente(IDDocente) NOT NULL,
    IDAlergias INT FOREIGN KEY REFERENCES Alergias(IDAlergias) NULL,
    IDEnfermedadesCronicas INT FOREIGN KEY REFERENCES EnfermedadesCronicas(IDEnfermedadesCronicas) NULL,
    IDTipoSangre INT FOREIGN KEY REFERENCES TipoSangre(IDTipoSangre) NOT NULL
);

INSERT INTO InformacionAcademicaDocente (IDDocente, CorreoInstitucional, IDGrado, IDDepartamentoAcademico)
VALUES ('D005', 'docente005@institucion.edu.mx', 1, 1);



--------------------------------------------
-----------|Tablas Coordinador|-------------
--------------------------------------------

-- Tabla Coordinador
CREATE TABLE Coordinador (
    IDCoordinador INT PRIMARY KEY,
	idUsuario INT FOREIGN KEY REFERENCES Usuarios(idUsuario),
    Nombres VARCHAR(50) NOT NULL,
    PrimerApellido VARCHAR(50) NOT NULL,
    SegundoApellido VARCHAR(50) NOT NULL,
    FechaNacimiento DATE NOT NULL,
    CURP VARCHAR(18) NOT NULL,
    RFC VARCHAR(13) NOT NULL,
    NumeroCelular NVARCHAR(15) NOT NULL,
    TelefonoCasa NVARCHAR(15) NULL,
	Email NVARCHAR(50) NOT NULL,
    Calle VARCHAR(100) NOT NULL,
    InterseccionPrimera VARCHAR(100) NOT NULL,
    InterseccionSegunda VARCHAR(100) NOT NULL,
    NumExterior VARCHAR(10) NOT NULL,
    NumInterior VARCHAR(10) NULL,
    CodigoPostal CHAR(5) NOT NULL,
    Colonia VARCHAR(100) NULL,
    Localidad VARCHAR(100) NULL,
    Municipio VARCHAR(100) NULL,
    Estado VARCHAR(100) NULL,
	TipoDeUsuarioId INT NOT NULL, -- Llave foránea para TipoDeUsuarios
    FOREIGN KEY (TipoDeUsuarioId) REFERENCES TipoDeUsuarios(TipoDeUsuarioId)
);


-- Tabla InformacionAcademicaCoordinador
CREATE TABLE InformacionAcademicaCoordinador (
    IDInformacionAcademica_COO INT PRIMARY KEY IDENTITY(1,1),
    IDCoordinador INT FOREIGN KEY REFERENCES Coordinador(IDCoordinador) NOT NULL,
    CorreoInstitucional NVARCHAR(50) NOT NULL,
    IDGrado INT FOREIGN KEY REFERENCES GradoAcademico(IDGrado) NOT NULL,
    IDDepartamentoAcademico INT FOREIGN KEY REFERENCES DepartamentoAcademico(IDDepartamentoAcademico) NOT NULL
);

-- Tabla InformacionMedicaCoordinador
CREATE TABLE InformacionMedicaCoordinador (
    IDInformacionMedica_COO INT PRIMARY KEY IDENTITY(1,1),
    IDCoordinador INT FOREIGN KEY REFERENCES Coordinador(IDCoordinador) NOT NULL,
    IDAlergias INT FOREIGN KEY REFERENCES Alergias(IDAlergias) NULL,
    IDEnfermedadesCronicas INT FOREIGN KEY REFERENCES EnfermedadesCronicas(IDEnfermedadesCronicas) NULL,
    IDTipoSangre INT FOREIGN KEY REFERENCES TipoSangre(IDTipoSangre) NOT NULL
);

--------------------------------------
---------|Tablas Personal|------------
--------------------------------------


-- Tabla Personal
CREATE TABLE Personal (
    IDPersonal INT PRIMARY KEY IDENTITY(1,1),
	idUsuario INT FOREIGN KEY REFERENCES Usuarios(idUsuario),
    Nombres VARCHAR(50) NOT NULL,
    PrimerApellido VARCHAR(50) NOT NULL,
    SegundoApellido VARCHAR(50) NOT NULL,
    FechaNacimiento DATE NOT NULL,
    CURP VARCHAR(18) NOT NULL,
    RFC VARCHAR(13) NOT NULL,
    NumeroCelular NVARCHAR(15) NOT NULL,
    TelefonoCasa NVARCHAR(15) NULL,
	Email NVARCHAR(50) NOT NULL,
    Calle VARCHAR(100) NOT NULL,
    InterseccionPrimera VARCHAR(100) NOT NULL,
    InterseccionSegunda VARCHAR(100) NOT NULL,
    NumExterior VARCHAR(10) NOT NULL,
    NumInterior VARCHAR(10) NULL,
    CodigoPostal CHAR(5) NOT NULL,
    Colonia VARCHAR(100) NULL,
    Localidad VARCHAR(100) NULL,
    Municipio VARCHAR(100) NULL,
    Estado VARCHAR(100) NULL,
	TipoDeUsuarioId INT NOT NULL, -- Llave foránea para TipoDeUsuarios
    FOREIGN KEY (TipoDeUsuarioId) REFERENCES TipoDeUsuarios(TipoDeUsuarioId)
);


-- Tabla InformacionAcademicaPersonal
CREATE TABLE InformacionAcademicaPersonal (
    IDInformacionAcademica_PER INT PRIMARY KEY IDENTITY(1,1),
    IDPersonal INT FOREIGN KEY REFERENCES Personal(IDPersonal) NOT NULL,
    CorreoInstitucional NVARCHAR(50) NOT NULL,
    IDGrado INT FOREIGN KEY REFERENCES GradoAcademico(IDGrado) NOT NULL,
    IDDepartamentoAcademico INT FOREIGN KEY REFERENCES DepartamentoAcademico(IDDepartamentoAcademico) NOT NULL
);

-- Tabla InformacionMedicaPersonal
CREATE TABLE InformacionMedicaPersonal (
    IDInformacionMedica_PER INT PRIMARY KEY IDENTITY(1,1),
    IDPersonal INT FOREIGN KEY REFERENCES Personal(IDPersonal) NOT NULL,
    IDAlergias INT FOREIGN KEY REFERENCES Alergias(IDAlergias) NULL,
    IDEnfermedadesCronicas INT FOREIGN KEY REFERENCES EnfermedadesCronicas(IDEnfermedadesCronicas) NULL,
    IDTipoSangre INT FOREIGN KEY REFERENCES TipoSangre(IDTipoSangre) NOT NULL
	);

--------------------------------------
--------|Tablas Encargado|------------
--------------------------------------


-- Tabla EncargadoLaboratorio
CREATE TABLE EncargadoLaboratorio (
    IDEncargadoLaboratorio INT PRIMARY KEY IDENTITY(1,1),
	idUsuario INT FOREIGN KEY REFERENCES Usuarios(idUsuario),
    Nombres VARCHAR(50) NOT NULL,
    PrimerApellido VARCHAR(50) NOT NULL,
    SegundoApellido VARCHAR(50) NOT NULL,
    FechaNacimiento DATE NOT NULL,
    CURP VARCHAR(18) NOT NULL,
    RFC VARCHAR(13) NOT NULL,
    NumeroCelular NVARCHAR(15) NOT NULL,
    TelefonoCasa NVARCHAR(15) NULL,
	Email NVARCHAR(50) NOT NULL,
    Calle VARCHAR(100) NOT NULL,
    InterseccionPrimera VARCHAR(100) NOT NULL,
    InterseccionSegunda VARCHAR(100) NOT NULL,
    NumExterior VARCHAR(10) NOT NULL,
    NumInterior VARCHAR(10) NULL,
    CodigoPostal CHAR(5) NOT NULL,
    Colonia VARCHAR(100) NULL,
    Localidad VARCHAR(100) NULL,
    Municipio VARCHAR(100) NULL,
    Estado VARCHAR(100) NULL,
	TipoDeUsuarioId INT NOT NULL, -- Llave foránea para TipoDeUsuarios
    FOREIGN KEY (TipoDeUsuarioId) REFERENCES TipoDeUsuarios(TipoDeUsuarioId)

);

-- Tabla InformacionAcademicaEncargadoLaboratorio
CREATE TABLE InformacionAcademicaEncargadoLaboratorio (
    IDInformacionAcademica_EL INT PRIMARY KEY IDENTITY(1,1),
    IDEncargadoLaboratorio INT FOREIGN KEY REFERENCES EncargadoLaboratorio(IDEncargadoLaboratorio) NOT NULL,
    CorreoInstitucional NVARCHAR(50) NOT NULL,
    IDGrado INT FOREIGN KEY REFERENCES GradoAcademico(IDGrado) NOT NULL,
    IDDepartamentoAcademico INT FOREIGN KEY REFERENCES DepartamentoAcademico(IDDepartamentoAcademico) NOT NULL
);

-- Tabla InformacionMedicaEncargadoLaboratorio
CREATE TABLE InformacionMedicaEncargadoLaboratorio (
    IDInformacionMedica_EL INT PRIMARY KEY IDENTITY(1,1),
    IDEncargadoLaboratorio INT FOREIGN KEY REFERENCES EncargadoLaboratorio(IDEncargadoLaboratorio) NOT NULL,
    IDAlergias INT FOREIGN KEY REFERENCES Alergias(IDAlergias) NULL,
    IDEnfermedadesCronicas INT FOREIGN KEY REFERENCES EnfermedadesCronicas(IDEnfermedadesCronicas) NULL,
    IDTipoSangre INT FOREIGN KEY REFERENCES TipoSangre(IDTipoSangre) NOT NULL
);

----------------------------------------------
--------|Tablas Jefe Departamento|------------
----------------------------------------------

-- Tabla JefeDeDepartamento
CREATE TABLE JefeDeDepartamento (
    IDJefeDeDepartamento INT PRIMARY KEY IDENTITY(1,1),
	idUsuario INT FOREIGN KEY REFERENCES Usuarios(idUsuario),
    Nombres VARCHAR(50) NOT NULL,
    PrimerApellido VARCHAR(50) NOT NULL,
    SegundoApellido VARCHAR(50) NOT NULL,
    FechaNacimiento DATE NOT NULL,
    CURP VARCHAR(18) NOT NULL,
    RFC VARCHAR(13) NOT NULL,
    NumeroCelular NVARCHAR(15) NOT NULL,
    TelefonoCasa NVARCHAR(15) NULL,
	Email NVARCHAR(50) NOT NULL,
    Calle VARCHAR(100) NOT NULL,
    InterseccionPrimera VARCHAR(100) NOT NULL,
    InterseccionSegunda VARCHAR(100) NOT NULL,
    NumExterior VARCHAR(10) NOT NULL,
    NumInterior VARCHAR(10) NULL,
    CodigoPostal CHAR(5) NOT NULL,
    Colonia VARCHAR(100) NULL,
    Localidad VARCHAR(100) NULL,
    Municipio VARCHAR(100) NULL,
    Estado VARCHAR(100) NULL,
	TipoDeUsuarioId INT NOT NULL, -- Llave foránea para TipoDeUsuarios
    FOREIGN KEY (TipoDeUsuarioId) REFERENCES TipoDeUsuarios(TipoDeUsuarioId)
);


-- Tabla InformacionAcademicaJefeDeDepartamento
CREATE TABLE InformacionAcademicaJefeDeDepartamento (
    IDInformacionAcademica_JD INT PRIMARY KEY IDENTITY(1,1),
    IDJefeDeDepartamento INT FOREIGN KEY REFERENCES JefeDeDepartamento(IDJefeDeDepartamento) NOT NULL,
    CorreoInstitucional NVARCHAR(50) NOT NULL,
    IDGrado INT FOREIGN KEY REFERENCES GradoAcademico(IDGrado) NOT NULL,
    IDDepartamentoAcademico INT FOREIGN KEY REFERENCES DepartamentoAcademico(IDDepartamentoAcademico) NOT NULL
);

-- Tabla InformacionMedicaJefeDeDepartamento
CREATE TABLE InformacionMedicaJefeDeDepartamento (
    IDInformacionMedica_JD INT PRIMARY KEY IDENTITY(1,1),
    IDJefeDeDepartamento INT FOREIGN KEY REFERENCES JefeDeDepartamento(IDJefeDeDepartamento) NOT NULL,
    IDAlergias INT FOREIGN KEY REFERENCES Alergias(IDAlergias) NULL,
    IDEnfermedadesCronicas INT FOREIGN KEY REFERENCES EnfermedadesCronicas(IDEnfermedadesCronicas) NULL,
    IDTipoSangre INT FOREIGN KEY REFERENCES TipoSangre(IDTipoSangre) NOT NULL
);
-------------------------------------------------
-------------|Tablas Prestamo Salas|-------------
-------------------------------------------------

-----Tablas referentes al Prestamo de SALAS----------
-- Tabla PrestamoSalas
CREATE TABLE PrestamoSalas (
    IDPrestamo INT PRIMARY KEY IDENTITY(1,1) NOT NULL,
    IDSala INT FOREIGN KEY REFERENCES Sala(IDSala) NOT NULL,
    IDDocente NVARCHAR(10) FOREIGN KEY REFERENCES Docente(IDDocente) NOT NULL,
    FechaPrestamo DATE NOT NULL,
    HoraInicio TIME NOT NULL,
    HoraFin TIME NOT NULL,
    Observaciones VARCHAR(100) NULL,
    IDEstado INT FOREIGN KEY REFERENCES EstadoSala(IDEstado) NOT NULL -- Llave foránea para EstadoSala
);


-- Tabla Sala
CREATE TABLE Sala (
    IDSala INT PRIMARY KEY IDENTITY(1,1) NOT NULL,
    NombreSala VARCHAR(100) NOT NULL,
    DescripcionSala TEXT NOT NULL,
    Capacidad INT NOT NULL,
    IDDepartamentoAcademico INT, -- FK a DepartamentoAcademico
    FOREIGN KEY (IDDepartamentoAcademico) REFERENCES DepartamentoAcademico(IDDepartamentoAcademico)
);

-- Tabla EstadoSala
CREATE TABLE EstadoSala (
    IDEstado INT PRIMARY KEY IDENTITY(1,1) NOT NULL,
    Descripcion NVARCHAR(50) NOT NULL
);

-- Insertar los estados
INSERT INTO EstadoSala (Descripcion) VALUES ('Desocupado'), ('Ocupado');

-- Actualizar la tabla Sala para agregar la columna IDEstado
ALTER TABLE Sala
ADD IDEstado INT;

-- Establecer la llave foránea para IDEstado
ALTER TABLE Sala
ADD CONSTRAINT FK_Sala_EstadoSala
FOREIGN KEY (IDEstado) REFERENCES EstadoSala(IDEstado);

-- Equipo de las Salas
CREATE TABLE EquipoSala (
    IDEquipo INT PRIMARY KEY IDENTITY(1,1),
    IDSala INT FOREIGN KEY REFERENCES Sala(IDSala),
    CodigoSeriePC INT FOREIGN KEY REFERENCES EquipoPC(CodigoSeriePC),
    CodigoSerieMonitor INT FOREIGN KEY REFERENCES Monitor(CodigoSerieMonitor),
    CodigoSerieTeclado INT FOREIGN KEY REFERENCES Teclado(CodigoSerieTeclado),
    CodigoSerieMouse INT FOREIGN KEY REFERENCES Mouse(CodigoSerieMouse),
    CodigoSerieRegulador INT FOREIGN KEY REFERENCES Regulador(CodigoSerieRegulador)
);

-- Tabla Asistencia de Alumnos en la Sala
CREATE TABLE Asistencia (
    IDAsistencia INT PRIMARY KEY IDENTITY(1,1) NOT NULL,
    IDPrestamo INT FOREIGN KEY REFERENCES PrestamoSalas(IDPrestamo) NOT NULL,
    IDEstudiante NVARCHAR(9) FOREIGN KEY REFERENCES Estudiante(NumeroControl) NOT NULL,
    Asistio BIT NOT NULL,
    Observaciones VARCHAR(100) NULL
);


----------------------------------------------------------
-----|Tablas de Dispositivos, Equipos, etc| --------------
----------------------------------------------------------

CREATE TABLE EquipoPC (
    CodigoSeriePC INT PRIMARY KEY NOT NULL,
    IDProcesador INT FOREIGN KEY REFERENCES Procesador(IDProcesador),
    IDTarjetaMadre INT FOREIGN KEY REFERENCES TarjetaMadre(IDTarjetaMadre),
    IDMemoriaRAM INT FOREIGN KEY REFERENCES MemoriaRAM(IDMemoriaRAM),
    IDMemoriaSalida INT FOREIGN KEY REFERENCES MemoriaSalida(IDMemoriaSalida),
    IDTarjetaVideo INT FOREIGN KEY REFERENCES TarjetaVideo(IDTarjetaVideo),
    IDFuentePoder INT FOREIGN KEY REFERENCES FuentePoder(IDFuentePoder),
    IDGabinete INT FOREIGN KEY REFERENCES Gabinete(IDGabinete)
);


-- Tabla de MemoriaSalida
CREATE TABLE MemoriaSalida (
    IDMemoriaSalida INT PRIMARY KEY IDENTITY(1,1),
    IDMarca INT FOREIGN KEY REFERENCES Marcas(IDMarca),
    Velocidad VARCHAR(50) NOT NULL,
    Almacenamiento VARCHAR(50) NOT NULL,
    FOREIGN KEY (IDMarca) REFERENCES Marcas(IDMarca)
);

-- Tabla de Procesador
CREATE TABLE Procesador (
    IDProcesador INT PRIMARY KEY IDENTITY(1,1),
    IDMarca INT,
    NombreProcesador VARCHAR(100),
    Generacion VARCHAR(50),
    Modelo VARCHAR(50),
    Velocidad VARCHAR(50),
    FOREIGN KEY (IDMarca) REFERENCES Marcas(IDMarca)
);

-- Tabla de TarjetaMadre
CREATE TABLE TarjetaMadre (
    IDTarjetaMadre INT PRIMARY KEY IDENTITY(1,1),
    IDMarca INT,
    NombreTarjetaMadre VARCHAR(100),
    Modelo VARCHAR(50),
    FOREIGN KEY (IDMarca) REFERENCES Marcas(IDMarca)
);

-- Tabla de Gabinete
CREATE TABLE Gabinete (
    IDGabinete INT PRIMARY KEY IDENTITY(1,1),
    IDMarca INT,
    NombreGabinete VARCHAR(100),
    Dimensiones VARCHAR(50),
    Color VARCHAR(50),
    Caracteristicas TEXT,
    FOREIGN KEY (IDMarca) REFERENCES Marcas(IDMarca)
);

-- Tabla de FuentePoder
CREATE TABLE FuentePoder (
    IDFuentePoder INT PRIMARY KEY IDENTITY(1,1),
    IDMarca INT,
    NombreFuentePoder VARCHAR(100),
    Potencia VARCHAR(50),
    Caracteristicas TEXT,
    FOREIGN KEY (IDMarca) REFERENCES Marcas(IDMarca)
);

-- Tabla de Garantias
CREATE TABLE Garantias (
    IDGarantia INT PRIMARY KEY IDENTITY(1,1),
    TiempoDuracion VARCHAR(50),
    TipoGarantia VARCHAR(100)
);

CREATE TABLE TarjetaVideo (
    IDTarjetaVideo INT PRIMARY KEY IDENTITY(1,1),
    IDMarca INT FOREIGN KEY REFERENCES Marcas(IDMarca),
    NombreTarjetaVideo VARCHAR(100),
    Generacion VARCHAR(50),
    Modelo VARCHAR(50),
    MemoriaAlmacenamiento VARCHAR(50),
    IDGarantia INT FOREIGN KEY REFERENCES Garantias(IDGarantia)
);

CREATE TABLE Regulador (
    CodigoSerieRegulador INT PRIMARY KEY,
    IDMarca INT FOREIGN KEY REFERENCES Marcas(IDMarca),
    NombreRegulador VARCHAR(100),
    Dimensiones VARCHAR(50),
    Voltaje VARCHAR(50),
    Caracteristicas VARCHAR(255),
    IDGarantia INT FOREIGN KEY REFERENCES Garantias(IDGarantia)
);

CREATE TABLE Monitor (
    CodigoSerieMonitor INT PRIMARY KEY,
    IDMarca INT FOREIGN KEY REFERENCES Marcas(IDMarca),
    NombreMonitor VARCHAR(100),
    Dimensiones VARCHAR(50),
    Color VARCHAR(50),
    Fotogramas INT,
    Caracteristicas VARCHAR(255),
    Material VARCHAR(50),
    IDGarantia INT FOREIGN KEY REFERENCES Garantias(IDGarantia)
);

CREATE TABLE Teclado (
    CodigoSerieTeclado INT PRIMARY KEY,
    IDMarca INT FOREIGN KEY REFERENCES Marcas(IDMarca),
    NombreTeclado VARCHAR(100),
    Dimensiones VARCHAR(50),
    Color VARCHAR(50),
    Caracteristicas VARCHAR(255),
    Material VARCHAR(50),
    IDGarantia INT FOREIGN KEY REFERENCES Garantias(IDGarantia)
);

CREATE TABLE Mouse (
    CodigoSerieMouse INT PRIMARY KEY,
    IDMarca INT FOREIGN KEY REFERENCES Marcas(IDMarca),
    NombreMouse VARCHAR(100),
    Dimensiones VARCHAR(50),
    Color VARCHAR(50),
    Caracteristicas VARCHAR(255),
    Material VARCHAR(50),
    IDGarantia INT FOREIGN KEY REFERENCES Garantias(IDGarantia)
);

CREATE TABLE MemoriaRAM (
    IDMemoriaRAM INT PRIMARY KEY IDENTITY(1,1),
    IDMarca INT FOREIGN KEY REFERENCES Marcas(IDMarca),
    Velocidad VARCHAR(50),
    Almacenamiento VARCHAR(50)
);

CREATE TABLE InformacionSoftware (
    NumeroSerieSoftware INT PRIMARY KEY,
    NombreSoftware VARCHAR(100),
    VersionSoftware VARCHAR(50),
    EstadoLicencia VARCHAR(50),
    FechaAdquisicion DATE,
    FechaExpiracion DATE
);


-- Tabla de Marcas
CREATE TABLE Marcas (
    IDMarca INT PRIMARY KEY IDENTITY(1,1),
    NombreMarca VARCHAR(100)
);
------------------------------------------------
----------|Mobiliario de las Salas|-------------
------------------------------------------------

CREATE TABLE MobiliarioSala (
    IDMobiliario INT PRIMARY KEY IDENTITY(1,1),
    IDTipoMobiliario INT FOREIGN KEY REFERENCES MobiliarioEspecifico(IDTipoMobiliario) NOT NULL,
    Cantidad INT NOT NULL,
    IDSala INT FOREIGN KEY REFERENCES Sala(IDSala) NOT NULL
);


CREATE TABLE MobiliarioEspecifico (
    IDTipoMobiliario INT PRIMARY KEY IDENTITY(1,1),
    NombreMobiliario VARCHAR(100) NOT NULL,
    Descripcion VARCHAR(255) NULL,
    Marca VARCHAR(50) NULL,
    NoSerie VARCHAR(50) NULL,
    Estado VARCHAR(50) NULL
);


-------------------------------------
----------|Tablas Mantenimiento|-----
-------------------------------------


CREATE TABLE Mantenimiento (
    IDMantenimiento INT PRIMARY KEY IDENTITY(1,1),
    TipoMantenimiento VARCHAR(50) NOT NULL,
    IDMantenimientoSoftware INT FOREIGN KEY REFERENCES MantenimientoSoftware(IDMantenimientoSoftware) NULL,
    IDMantenimientoHardware INT FOREIGN KEY REFERENCES MantenimientoHardware(IDMantenimientoHardware) NULL,
    IDMantenimientoMobiliario INT FOREIGN KEY REFERENCES MantenimientoMobiliario(IDMantenimientoMobiliario) NULL,
    IDMantenimientoSala INT FOREIGN KEY REFERENCES MantenimientoSala(IDMantenimientoSala) NULL
);



CREATE TABLE MantenimientoSoftware (
    IDMantenimientoSoftware INT PRIMARY KEY IDENTITY(1,1),
    FechaMantenimiento DATE NOT NULL,
    DescripcionMantenimiento VARCHAR(255) NULL,
    NumeroSerieSoftware INT FOREIGN KEY REFERENCES InformacionSoftware(NumeroSerieSoftware) NOT NULL,
    IDEncargadoLaboratorio INT FOREIGN KEY REFERENCES EncargadoLaboratorio(IDEncargadoLaboratorio) NOT NULL
);


CREATE TABLE MantenimientoHardware (
    IDMantenimientoHardware INT PRIMARY KEY IDENTITY(1,1),
    FechaMantenimiento DATE NOT NULL,
    DescripcionMantenimiento VARCHAR(255) NULL,
    IDEquipo INT FOREIGN KEY REFERENCES EquipoSala(IDEquipo) NOT NULL,
    IDEncargadoLaboratorio INT FOREIGN KEY REFERENCES EncargadoLaboratorio(IDEncargadoLaboratorio) NOT NULL
);	


CREATE TABLE MantenimientoMobiliario (
    IDMantenimientoMobiliario INT PRIMARY KEY IDENTITY(1,1),
    FechaMantenimiento DATE NOT NULL,
    DescripcionMantenimiento VARCHAR(255) NULL,
    IDMobiliario INT FOREIGN KEY REFERENCES MobiliarioSala(IDMobiliario) NOT NULL,
    IDEncargadoLaboratorio INT FOREIGN KEY REFERENCES EncargadoLaboratorio(IDEncargadoLaboratorio) NOT NULL
);


CREATE TABLE MantenimientoSala (
    IDMantenimientoSala INT PRIMARY KEY IDENTITY(1,1),
    FechaMantenimiento DATE NOT NULL,
    DescripcionMantenimiento VARCHAR(255) NULL,
    IDSala INT FOREIGN KEY REFERENCES Sala(IDSala) NOT NULL,
    IDEncargadoLaboratorio INT FOREIGN KEY REFERENCES EncargadoLaboratorio(IDEncargadoLaboratorio) NOT NULL
);

---------------------------------


------|Tabla Usuarios|-------------------- ------------------------------------------------ 
CREATE TABLE Usuarios ( idUsuario INT PRIMARY KEY IDENTITY(1,1),--Numero de identificacion del usuario 
NombreUsuario NVARCHAR(50) NOT NULL UNIQUE, --nombre del usuario sera con el numero del control 
emailUsuario NVARCHAR(50) NOT NULL UNIQUE, --email sera correo institucional 
passsword NVARCHAR(255) NOT NULL --Contraseña del usuario ); 
------------------------------------------------

SELECT * FROM Usuarios WHERE NombreUsuario = 'jose';
-----------------------------------------------

-- Crear el trigger para actualizar el IDEstado en la tabla Sala
CREATE TRIGGER ActualizarEstadoSala
ON PrestamoSalas
AFTER INSERT
AS
BEGIN
    -- Actualizar el IDEstado en la tabla Sala basado en la nueva inserción en PrestamoSalas
    UPDATE Sala
    SET IDEstado = inserted.IDEstado
    FROM Sala
    INNER JOIN inserted ON Sala.IDSala = inserted.IDSala
    WHERE inserted.IDEstado IN (1, 2, 4, 5, 6);

    -- Si el nuevo IDEstado es 3, actualizar el IDEstado en la tabla Sala
    UPDATE Sala
    SET IDEstado = 3
    FROM Sala
    INNER JOIN inserted ON Sala.IDSala = inserted.IDSala
    WHERE inserted.IDEstado = 3;
END;
-------------------------------------------
CREATE TABLE HorariosSalas (
    IDHorario INT PRIMARY KEY IDENTITY(1,1) NOT NULL,
    IDSala INT FOREIGN KEY REFERENCES Sala(IDSala) NOT NULL,
    Fecha DATE NOT NULL,
    HoraInicio TIME NOT NULL,
    HoraFin TIME NOT NULL,
    IDEstado INT FOREIGN KEY REFERENCES EstadoSala(IDEstado) NOT NULL
);

INSERT INTO Carrera (NombreCarrera, DescripcionCarrera) VALUES
('Ingeniería en Sistemas Computacionales', 'Formación en desarrollo de software, redes y sistemas de información.'),
('Ingeniería Industrial', 'Formación en optimización de procesos y gestión de calidad.'),
('Ingeniería en Gestión Empresarial', 'Formación en administración y gestión de empresas.'),
('Ingeniería Civil', 'Formación en diseño y construcción de infraestructura.'),
('Ingeniería Electrónica', 'Formación en diseño y desarrollo de sistemas electrónicos.');


INSERT INTO TipoCredito (DescripcionCredito) VALUES
('Participación en eventos académicos'),
('Cursos extracurriculares'),
('Proyectos de investigación'),
('Servicio social'),
('Actividades deportivas');


INSERT INTO CreditosComplementarios (IDTipo, Total) VALUES
(1, 3.0),
(2, 2.5),
(3, 4.0),
(4, 5.0),
(5, 1.5);


INSERT INTO StatusAsignatura (Estado) VALUES
('Aprobada'),
('Reprobada'),
('En curso'),
('Pendiente'),
('Cancelada');

INSERT INTO Asignaturas (NombreAsignatura, DescripcionAsignatura, HorasTotales, Creditos) VALUES
('Matemáticas I', 'Fundamentos de álgebra y cálculo.', 60, 5.0),
('Programación I', 'Introducción a la programación en C.', 80, 6.0),
('Física I', 'Conceptos básicos de mecánica y termodinámica.', 70, 5.5),
('Química', 'Estudio de la estructura y propiedades de la materia.', 60, 5.0),
('Ingeniería de Software', 'Principios y prácticas de ingeniería de software.', 90, 7.0);

CREATE TABLE solicitudes_prestamo (
    id INT IDENTITY(1,1) PRIMARY KEY,
    NumeroControl NVARCHAR(9) NOT NULL,
    fecha_solicitud DATETIME NOT NULL,
    estado NVARCHAR(10) DEFAULT 'pendiente' CHECK (estado IN ('pendiente', 'aprobada', 'rechazada')),
    FOREIGN KEY (NumeroControl) REFERENCES Estudiante(NumeroControl)
);


CREATE TABLE Reportes (
    IDReporte INT PRIMARY KEY IDENTITY(1,1),
    Usuario NVARCHAR(50) NOT NULL,
    Fecha DATETIME NOT NULL DEFAULT GETDATE(),
    Descripcion TEXT NOT NULL
);