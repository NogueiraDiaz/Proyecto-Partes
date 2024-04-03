DROP DATABASE IF EXISTS Proyectodaw;
CREATE DATABASE Proyectodaw;
USE Proyectodaw;

-- tabla departamento
CREATE TABLE Departamentos (
codigo SMALLINT PRIMARY KEY AUTO_INCREMENT,
referencia VARCHAR(4),
nombre VARCHAR(100)  NOT NULL,
jefe VARCHAR(50),
ubicacion VARCHAR(5)
);

-- tabla usuarios
CREATE TABLE Usuarios (
cod_usuario INTEGER PRIMARY KEY AUTO_INCREMENT,
dni VARCHAR(9) UNIQUE NOT NULL,
nombre VARCHAR(50) NOT NULL,
apellidos VARCHAR(100) NOT NULL,
email VARCHAR(50) NOT NULL UNIQUE,
clave VARCHAR(20) NOT NULL,
rol VARCHAR(2) NOT NULL,
cod_delphos INTEGER,
validar VARCHAR(2) NOT NULL,
departamento SMALLINT,
tutor_grupo varchar(20),
FOREIGN KEY (departamento) REFERENCES Departamentos(codigo) ON DELETE SET NULL
);

-- tabla tareas
CREATE TABLE Tareas (
cod_tarea INTEGER PRIMARY KEY AUTO_INCREMENT,
estado VARCHAR(50) NOT NULL,
nivel_tarea VARCHAR(50) NOT NULL,
descripcion VARCHAR(255) NOT NULL,
comentario VARCHAR(255),
imagen LONGBLOB,
localizacion VARCHAR(60) NOT NULL,
fecha_inicio DATE NOT NULL,
fecha_fin DATE,
cod_usuario_gestion INTEGER,
cod_usuario_crea INTEGER,
tipo_incidencia VARCHAR(50),
FOREIGN KEY (cod_usuario_gestion) REFERENCES Usuarios(cod_usuario),
FOREIGN KEY (cod_usuario_crea) REFERENCES Usuarios(cod_usuario)
);

-- tabla tareas Finalizadas
CREATE TABLE TareasFinalizadas (
cod_tarea INTEGER PRIMARY KEY,
estado VARCHAR(50) NOT NULL,
nivel_tarea VARCHAR(50) NOT NULL,
descripcion VARCHAR(255) NOT NULL,
comentario VARCHAR(255),
imagen LONGBLOB,
localizacion VARCHAR(60) NOT NULL,
fecha_inicio DATE NOT NULL,
fecha_fin DATE,
cod_usuario_gestion INTEGER,
cod_usuario_crea INTEGER,
tipo_incidencia VARCHAR(50),
FOREIGN KEY (cod_usuario_gestion) REFERENCES Usuarios(cod_usuario),
FOREIGN KEY (cod_usuario_crea) REFERENCES Usuarios(cod_usuario)
);
-- tabla articulo
CREATE TABLE Articulos (
codigo INTEGER PRIMARY KEY AUTO_INCREMENT,
fecha_alta DATE,
num_serie VARCHAR(20),
nombre VARCHAR(50) NOT NULL,
descripcion VARCHAR(255) NOT NULL,
unidades INT(5) NOT NULL,
localizacion VARCHAR(50) NOT NULL,
procedencia_entrada VARCHAR(200),
motivo_baja VARCHAR(200),
fecha_baja DATE,
ruta_imagen LONGBLOB
);

-- tabla articulo
CREATE TABLE Fungibles (
codigo INTEGER PRIMARY KEY,
pedir VARCHAR(2),
FOREIGN KEY (codigo) REFERENCES Articulos(codigo)
);

-- tabla articulo
CREATE TABLE Nofungibles (
codigo INTEGER PRIMARY KEY,
fecha INT(4),
FOREIGN KEY (codigo) REFERENCES Articulos(codigo)
);

-- tabla tiene
CREATE TABLE Tiene (
cod_articulo INTEGER,
cod_departamento SMALLINT,
PRIMARY KEY (cod_articulo, cod_departamento),
FOREIGN KEY (cod_articulo) REFERENCES Articulos(codigo),
FOREIGN KEY (cod_departamento) REFERENCES Departamentos(codigo)
);

-- tabla alumno
CREATE TABLE Alumnos(
   cod_alumno INTEGER PRIMARY KEY AUTO_INCREMENT,
    dni_alumno VARCHAR(10) NOT NULL,
    nombre VARCHAR(20) NOT NULL,
    apellidos VARCHAR(50) NOT NULL,
    genero VARCHAR(20) NOT NULL,
    correo_alumno VARCHAR(100) NOT NULL,
    telefono_alumno VARCHAR(11) NOT NULL,
    fecha_nac DATE NOT NULL,
    lugar_nac VARCHAR(40) NOT NULL,
	localidad_alumno VARCHAR(100) NOT NULL, 
    provincia_alumno VARCHAR(100) NOT NULL, 
    domicilio_alumno VARCHAR(100) NOT NULL, 
    cp_alumno VARCHAR(5) NOT NULL,
    ciclo VARCHAR(5) NOT NULL,
    anio VARCHAR(4) NOT NULL
);

-- tabla empresa
CREATE TABLE Empresas(
    cod_empresa VARCHAR(30) PRIMARY KEY,
    tipo VARCHAR(30),
    respo_empresa VARCHAR(50),
    dni_responsable VARCHAR(10),
    nombre_empresa VARCHAR(150),
    localidad_empresa VARCHAR(60),
    provincia_empresa VARCHAR(11),
    direcc_empresa VARCHAR(100),
    cp_empresa VARCHAR(5), 
    cif_empresa VARCHAR(11),
    localidad_firma VARCHAR(40),
    fecha_firma DATE,
    anexo_0 VARCHAR(200),
	anexo_0a VARCHAR(200),
    anexo_0b VARCHAR(200),
    anexo_xvi VARCHAR(200)

);

-- tabla mail_empresas
CREATE TABLE Mail_empresas (
    cod_empresa VARCHAR(30),
    email VARCHAR(100),
    PRIMARY KEY(cod_empresa, email),
    FOREIGN KEY(cod_empresa) REFERENCES Empresas(cod_empresa)
);

-- tabla ciclo_empresas
CREATE TABLE Ciclo_empresas (
    cod_empresa VARCHAR(30),
    ciclo VARCHAR(6),
    PRIMARY KEY(cod_empresa, ciclo),
    FOREIGN KEY(cod_empresa) REFERENCES Empresas(cod_empresa)
);

-- tabla telefono_empresas
CREATE TABLE Telefono_empresas (
    cod_empresa VARCHAR(30),
    telefono VARCHAR(9),
    PRIMARY KEY(cod_empresa, telefono),
    FOREIGN KEY(cod_empresa) REFERENCES Empresas(cod_empresa)
); 

-- tabla pertenece
CREATE TABLE Pertenece(
    cod_empresa VARCHAR(30) NOT NULL,
    cod_usuario INTEGER NOT NULL,
    cod_alumno INTEGER NOT NULL,
    f_inicio_beca DATE NOT NULL,
    f_fin_beca DATE NOT NULL,
    tutor_practicas VARCHAR(40) NOT NULL,
    ciclo VARCHAR(6) NOT NULL,
    anexo_i VARCHAR(200),
    anexo_ii VARCHAR(200),
    anexo_iv VARCHAR(200),
    anexo_v VARCHAR(200),
    anexo_vi VARCHAR(200),
    anexo_vibis VARCHAR(200),
    anexo_vii VARCHAR(200),
    anexo_ix VARCHAR(200),
    anexo_xi VARCHAR(200),
    anexo_xii VARCHAR(200),
    anexo_xv VARCHAR(200),
    PRIMARY KEY(cod_empresa, cod_usuario, cod_alumno),
    FOREIGN KEY(cod_empresa) REFERENCES Empresas(cod_empresa),
    FOREIGN KEY(cod_usuario) REFERENCES Usuarios(cod_usuario),
    FOREIGN KEY(cod_alumno) REFERENCES Alumnos(cod_alumno)
);

-- tabla anexoiii_pertenece
CREATE TABLE Anexoiii_pertenece (
    cod_empresa VARCHAR(30) NOT NULL,
    cod_usuario INTEGER NOT NULL,
    cod_alumno INTEGER NOT NULL,
    anexo_iii VARCHAR(200),
    PRIMARY KEY(cod_empresa, cod_usuario, cod_alumno, anexo_iii),
    FOREIGN KEY(cod_empresa, cod_usuario, cod_alumno) REFERENCES Pertenece(cod_empresa, cod_usuario, cod_alumno)
);


-- tabla periodos
CREATE TABLE Periodos (
cod_periodo INTEGER PRIMARY KEY,
inicio time NOT NULL,
fin time NOT NULL

);

-- tabla guardias
CREATE TABLE Guardias (
cod_guardias INTEGER PRIMARY KEY AUTO_INCREMENT,
fecha DATE NOT NULL,
observaciones VARCHAR(255),
periodo INTEGER(2) NOT NULL,
cod_usuario INTEGER NOT NULL,
FOREIGN KEY (cod_usuario) REFERENCES Usuarios(cod_usuario),
FOREIGN KEY (periodo) REFERENCES Periodos (cod_periodo),
UNIQUE(fecha, periodo, cod_usuario)
);

-- tabla horarios
CREATE TABLE Horarios(
cod_horario INTEGER PRIMARY KEY AUTO_INCREMENT,
nombre VARCHAR(50),
apellidos VARCHAR(50),
dia VARCHAR(15),
inicio time,
fin time,
clase VARCHAR(100),
cod_usuario INTEGER,
FOREIGN KEY (cod_usuario) REFERENCES Usuarios(cod_usuario)
);


-- valores de las tabla departamentos
INSERT INTO Departamentos(referencia, nombre, jefe, ubicacion)
VALUES('fra', 'DPTO Francés', 'x', 'xxx');

INSERT INTO Departamentos(referencia, nombre, jefe, ubicacion)
VALUES('ing', 'DPTO Inglés', 'x', 'xxx');

INSERT INTO Departamentos(referencia, nombre, jefe, ubicacion)
VALUES('tec', 'DPTO Tecnología', 'x', 'xxx');

INSERT INTO Departamentos(referencia, nombre, jefe, ubicacion)
VALUES('rel', 'DPTO Religión', 'x', 'xxx');

INSERT INTO Departamentos(referencia, nombre, jefe, ubicacion)
VALUES('mat', 'DPTO Matemáticas', 'x', 'xxx');

INSERT INTO Departamentos(referencia, nombre, jefe, ubicacion)
VALUES('ef', 'DPTO Educación física', 'x', 'xxx');

INSERT INTO Departamentos(referencia, nombre, jefe, ubicacion)
VALUES('dib', 'DPTO Dibujo', 'x', 'xxx');

INSERT INTO Departamentos(referencia, nombre, jefe, ubicacion)
VALUES('inf', 'DPTO Informática', 'x', 'xxx');

INSERT INTO Departamentos(referencia, nombre, jefe, ubicacion)
VALUES('len', 'DPTO Lengua', 'x', 'xxx');

INSERT INTO Departamentos(referencia, nombre, jefe, ubicacion)
VALUES('fil', 'DPTO Filosofía', 'x', 'xxx');

INSERT INTO Departamentos(referencia, nombre, jefe, ubicacion)
VALUES('geh', 'DPTO Geografía e historia', 'x', 'xxx');

INSERT INTO Departamentos(referencia, nombre, jefe, ubicacion)
VALUES('ori', 'DPTO Orientación', 'x', 'xxx');

INSERT INTO Departamentos(referencia, nombre, jefe, ubicacion)
VALUES('fyq', 'DPTO Física y química', 'x', 'xxx');

INSERT INTO Departamentos(referencia, nombre, jefe, ubicacion)
VALUES('mus', 'DPTO Música', 'x', 'xxx');

INSERT INTO Departamentos(referencia, nombre, jefe, ubicacion)
VALUES('bio', 'DPTO Biología y geología', 'x', 'xxx');

INSERT INTO Departamentos(referencia, nombre, jefe, ubicacion)
VALUES('gri', 'DPTO Griego', 'x', 'xxx');

INSERT INTO Departamentos(referencia, nombre, jefe, ubicacion)
VALUES('eco', 'DPTO Economía', 'x', 'xxx');

INSERT INTO Departamentos(referencia, nombre, jefe, ubicacion)
VALUES('fol', 'DPTO FOL', 'x', 'xxx');

-- valores de las tabla usuarios
INSERT INTO Usuarios(dni,nombre, apellidos, email, clave, rol, validar, departamento)
VALUES('11111111a', 'administrador', 'administrador', 'incidenciasiesbargas@gmail.com','appincidencias',0,'si', (SELECT codigo FROM Departamentos WHERE nombre = "DPTO informática"));

-- valores de las tabla periodos
INSERT INTO Periodos (cod_periodo, inicio, fin) VALUES(1, '8:30', '9:25');
INSERT INTO Periodos (cod_periodo, inicio, fin) VALUES(2, '9:25', '10:20');
INSERT INTO Periodos (cod_periodo, inicio, fin) VALUES(3, '10:20', '11:15');
INSERT INTO Periodos (cod_periodo, inicio, fin) VALUES(4, '11:45', '12:40');
INSERT INTO Periodos (cod_periodo, inicio, fin) VALUES(5, '12:40', '13:35');
INSERT INTO Periodos (cod_periodo, inicio, fin) VALUES(6, '13:35', '14:25');
INSERT INTO Periodos (cod_periodo, inicio, fin) VALUES(7, '15:15', '16:10');
INSERT INTO Periodos (cod_periodo, inicio, fin) VALUES(8, '16:10', '17:05');
INSERT INTO Periodos (cod_periodo, inicio, fin) VALUES(9, '17:05', '18:00');
INSERT INTO Periodos (cod_periodo, inicio, fin) VALUES(10, '18:30', '19:25');
INSERT INTO Periodos (cod_periodo, inicio, fin) VALUES(11, '19:25', '20:20');
INSERT INTO Periodos (cod_periodo, inicio, fin) VALUES(12, '20:20', '21:15');



--Reservas 
CREATE TABLE Reservas(
    id INT PRIMARY KEY AUTO_INCREMENT,
    autor INTEGER NOT NULL,
    aula VARCHAR(150) NOT NULL,
    fecha DATE NOT NULL, inicio TIME NOT NULL, fin TIME NOT NULL,
    comentario VARCHAR(255),
    FOREIGN KEY (autor) REFERENCES usuarios(cod_usuario),
    UNIQUE uniqueCombination (aula, fecha, inicio, fin));

--Partes
CREATE TABLE AlumnosPartes (
  matricula varchar(20) NOT NULL,
  nombre varchar(30) NOT NULL,
  apellidos varchar(50),
  grupo varchar(20),
  PRIMARY KEY(matricula, grupo)
);


CREATE TABLE Cursos (
  grupo varchar(20) NOT NULL PRIMARY KEY,
  aula varchar(20)
);

CREATE TABLE Expulsiones (
  matricula_del_Alumno varchar(20) NOT NULL,
  fecha_Inicio date DEFAULT NULL,
  Fecha_Fin date DEFAULT NULL,
  fecha_Insercion timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (matricula_del_Alumno, fecha_Insercion)
);

CREATE TABLE Incidencias (
  nombre varchar(100) NOT NULL,
  puntos int(11) NOT NULL,
  descripcion text,
  PRIMARY KEY (nombre, puntos);
);

CREATE TABLE Partes (
  dni_Profesor varchar(12) NOT NULL,
  matricula_Alumno varchar(20) NOT NULL,
  incidencia varchar(100) NOT NULL,
  puntos int(11) NOT NULL,
  materia varchar(40) DEFAULT NULL,
  fecha date NOT NULL,
  hora time NOT NULL,
  descripcion text,
  fecha_Comunicacion date NOT NULL,
  via_Comunicacion varchar(25) NOT NULL,
  tipo_Parte varchar(20) NOT NULL,
  caducado tinyint(1) NOT NULL,
  PRIMARY KEY (dni_Profesor,matricula_Alumno,incidencia, fecha, hora)
);

