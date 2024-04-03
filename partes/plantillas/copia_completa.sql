
USE b31_20609311_partesjulioverne;


CREATE TABLE profesores(
    cod_profesor INT NOT NULL AUTO_INCREMENT,
    ape_profesor VARCHAR(40)NOT NULL,
    nom_profesor VARCHAR(30)NOT NULL,
    email_profesor VARCHAR(75) NOT NULL UNIQUE,
    pas_profesor VARCHAR(255)NOT NULL,
    tipo_profesor TINYINT NOT NULL,
    PRIMARY KEY (cod_profesor)
);

CREATE TABLE incidencias(
    cod_incidencia INT NOT NULL AUTO_INCREMENT,
    nom_incidencia VARCHAR(100) NOT NULL,
    puntos_incidencia  TINYINT NOT NULL,
    descripcion_incidencia VARCHAR(255),
    PRIMARY KEY (cod_incidencia)
);

CREATE TABLE expulsiones(
    cod_expulsion INT NOT NULL AUTO_INCREMENT,
    fecha_inicio_expulsion DATE,
    fecha_fin_expulsion DATE,
    PRIMARY KEY(cod_expulsion)
);

CREATE TABLE alumnos(
    cod_alumno INT NOT NULL AUTO_INCREMENT,
    nom_alumno VARCHAR(30) NOT NULL,
    ape_alumno VARCHAR(40) NOT NULL,
    dni_nie_alumno VARCHAR(12) NOT NULL,
    grupo_alumno VARCHAR(20) NOT NULL,
    dir_alumno VARCHAR(200) NOT NULL,
    tutor1_alumno VARCHAR(70) NOT NULL,
    tutor2_alumno VARCHAR(70),
    tel1_fijo_tutor_alumno VARCHAR(10),
    tel2_fijo_tutor_alumno VARCHAR(10),
    tel1_movil_tutor_alumno VARCHAR(10),
    tel2_movil_tutor_alumno VARCHAR(10),
    email1_tutor_alumno VARCHAR(75),
    email2_tutor_alumno VARCHAR(75),
    PRIMARY KEY(cod_alumno) 
);

CREATE TABLE partes(
    cod_parte INT NOT NULL AUTO_INCREMENT,
    cod_profesor INT NOT NULL,
    cod_alumno INT NOT NULL,
    cod_incidencia INT NOT NULL,
    materia_parte VARCHAR(20),
    fecha_parte DATE, 
    hora_parte VARCHAR(20), 
    puntos_parte TINYINT NOT NULL,
    descripcion_profesor BLOB,
    fecha_comunicacion_familia DATE,
    via_comunicacion_familia VARCHAR(50),
    INDEX(cod_profesor),
    INDEX(cod_alumno),
    INDEX(cod_incidencia),
    PRIMARY KEY(cod_parte),
    FOREIGN KEY(cod_profesor) REFERENCES profesores(cod_profesor),
    FOREIGN KEY(cod_alumno) REFERENCES alumnos(cod_alumno),
    FOREIGN KEY (cod_incidencia) REFERENCES incidencias(cod_incidencia)
);

CREATE TABLE partes_expulsion(
    cod_parte_expulsion INT NOT NULL AUTO_INCREMENT,
    cod_expulsion INT NOT NULL,    
    cod_profesor INT NOT NULL,
    cod_alumno INT NOT NULL,
    cod_incidencia INT NOT NULL,
    materia_parte VARCHAR(20),
    fecha_parte DATE, 
    hora_parte VARCHAR(20), 
    puntos_parte TINYINT NOT NULL,
    descripcion_profesor BLOB,
    fecha_comunicacion_familia DATE,
    via_comunicacion_familia VARCHAR(50),
    INDEX(cod_expulsion),
    INDEX(cod_profesor),
    INDEX(cod_alumno),
    INDEX(cod_incidencia),
    PRIMARY KEY(cod_parte_expulsion),
    FOREIGN KEY (cod_expulsion) REFERENCES expulsiones(cod_expulsion),
    FOREIGN KEY(cod_profesor) REFERENCES profesores(cod_profesor),
    FOREIGN KEY(cod_alumno) REFERENCES alumnos(cod_alumno),
    FOREIGN KEY (cod_incidencia) REFERENCES incidencias(cod_incidencia)
);

INSERT INTO profesores(ape_profesor, nom_profesor, email_profesor,
pas_profesor, tipo_profesor) VALUES
("ape profesor1","nprofesor1","profesor1@bargas.es","qwerty1",1),
("ape profesor2","nprofesor2","profesor2@bargas.es","qwerty2",1),
("ape profesor3","nprofesor3","profesor3@bargas.es","qwerty3",1),
("ape profesor4","nprofesor4","profesor4@bargas.es","qwerty4",1),
("ape profesor5","nprofesor5","profesor5@bargas.es","qwerty5",1),
("ape profesor6","nprofesor6","profesor6@bargas.es","qwerty6",0);



INSERT INTO incidencias(nom_incidencia, puntos_incidencia, 
descripcion_incidencia) VALUES
("Comer y beber en aulas o pasillos.",1,""),
("Comer chicles o caramelos en aulas o pasillos.",1,""),
("Interrumpir la clase.",1,""),
("Ensuciar el centro.",1,""),
("Postura inadecuada.",1,""),
("Desordenar material y mobiliario.",1,""),
("Llegar tarde a primera hora.",1,""),
("Cambiarse de sitio sin permiso.",1,""),
("No traer el material.",1,""),
("Estar en el pasillo.",1,""),
("Otros.",1,""),

("Llegar tarde a clase.",2,""),
("Falta injustificada de asistencia.",2,""),
("No realizar las tareas de manera reiterada.",2,""),
("No traer la agenda firmada por los padres.",2,""),
("Estar en otra aula que no corresponde.",2,""),
("Formar alboroto en los cambios de clase.",2,""),
("Estar en los pasillos o aulas durante el recreo.",2,""),
("Otros.",2,""),

("Insultar a un compañero.",3,""),
("Desobedecer al profesor o personal del centro.",3,""),
("Reincidencia en una conducta negativa.",3,""),
("Formar alboroto durante las clases.",3,""),
("No realizar las tareas de expulsión.",3,""),
("Uso de vocabulario inapropiado.",3,""),
("Acumular 3 partes de Convivencia.",3,""),
("Otros.",3,""),

("Faltar el respeto gravemente.",5,""),
("Reincidencia en una misma falta. (3 veces)",5,""),
("Romper, inutilizar y/o perder material de forma premeditada.",5,""),
("No reponer o reparar el material inutilizado.",5,""),
("Otros.",5,""),

("Agresión.",10,""),
("Robo.",10,""),
("Falta de respeto al profesor o personal del centro.",10,""),
("Incumplimiento de una sanción.",10,""),
("Fumar en el centro.",10,""),
("Vandalismo.",10,""),
("Utilizar el móvil en el centro.",10,""),
("Suplantación de personalidad.",10,""),
("Salir del centro sin permiso.",10,""),
("Otros.",10,"");

INSERT INTO expulsiones(fecha_inicio_expulsion, fecha_fin_expulsion) VALUES
("2017-04-02", "2017-04-08"),
("2017-03-20", "2017-04-22"),
("2016-12-19", "2017-01-12"),
("2017-04-01", "2017-04-04"),
("2017-04-01", "2017-04-04"),
("2017-04-01", "2017-04-04"),
("2017-04-01", "2017-04-04"),
("2017-04-01", "2017-04-04");

INSERT INTO alumnos(nom_alumno, ape_alumno,dni_nie_alumno, grupo_alumno,
dir_alumno, tutor1_alumno, tutor2_alumno,tel1_fijo_tutor_alumno,
tel2_fijo_tutor_alumno, tel1_movil_tutor_alumno, tel2_movil_tutor_alumno, 
email1_tutor_alumno, email2_tutor_alumno) VALUES
("nalumno1","ape alumno1","12345678y","1ºA","calle del alumno1","nombre padre alumno1",
  "nombre_madre alumno1","555555555","555555555", "666666666","666666666","alumno1@bargas.es",
"alumno1@bargas.es"),
("nalumno2","ape alumno2","12345678y","1ºB","calle del alumno2","nombre padre alumno2",
  "nombre_madre alumno2","555555555","555555555","666666666","666666666", "alumno2@bargas.es",
"alumno2@bargas.es"),
("nalumno3","ape alumno3","12345678y","2ºC","calle del alumno3","nombre padre alumno3",
  "nombre_madre alumno3","555555555","555555555","666666666","666666666", "alumno3@bargas.es", 
"alumno3@bargas.es"),
("nalumno4","ape alumno4","12345678y","2ºD","calle del alumno4","nombre padre alumno4",
  "nombre_madre alumno4","555555555","555555555","666666666","666666666", "alumno4@bargas.es",
 "alumno4@bargas.es"),
("nalumno5","ape alumno5","12345678y","3ºA","calle del alumno5","nombre padre alumno5",
  "nombre madre alumno5","555555555","555555555","666666666","666666666", "alumno5@bargas.es", 
"alumno5@bargas.es"),
("nalumno6","ape alumno6","12345678y","3ºB","calle del alumno6","nombre padre alumno6",
  "nombre_madre alumno6","555555555","555555555","666666666","666666666", "alumno6@bargas.es",
 "alumno6@bargas.es"),
("nalumno7","ape alumno7","12345678y","1ºA","calle del alumno7","nombre padre alumno7",
  "nombre_madre alumno7","555555555","555555555","666666666","666666666", "alumno7@bargas.es",
 "alumno7@bargas.es"),
("nalumno8","ape alumno8","12345678y","1ºB","calle del alumno8","nombre padre alumno8",
  "nombre_madre alumno8","555555555","555555555","666666666","666666666", "alumno8@bargas.es",
 "alumno8@bargas.es"),
("nalumno9","ape alumno9","12345678y","4ºC","calle del alumno9","nombre padre alumno9",
  "nombre_madre alumno9","555555555","555555555", "666666666","666666666","alumno9@bargas.es",
 "alumno9@bargas.es");



INSERT INTO partes(cod_profesor, cod_alumno, cod_incidencia, materia_parte, 
fecha_parte, hora_parte, puntos_parte, descripcion_profesor,  fecha_comunicacion_familia, 
via_comunicacion_familia ) VALUES
("1","1","1","matemáticas","2017-04-08","1ª hora",1,"Lorem ipsum dolor sit amet,
 consectetuer adipiscing elit. Aenean commodo ligula eget dolor. 
Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, 
nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, 
pretium quis, sem. Nulla consequat massa", "2017-04-09", "teléfono"),
("1","2","2","matemáticas","2017-04-08","1ª hora",2,"Lorem ipsum dolor sit amet,
 consectetuer adipiscing elit. Aenean commodo ligula eget dolor. 
Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, 
nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, 
pretium quis, sem. Nulla consequat massa", "2017-04-09", "teléfono"),
("2","2","2","matemáticas","2017-04-08","1ª hora",2,"Lorem ipsum dolor sit amet,
 consectetuer adipiscing elit. Aenean commodo ligula eget dolor. 
Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, 
nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, 
pretium quis, sem. Nulla consequat massa", "2017-04-09", "teléfono"),
("1","9","3","matemáticas","2017-04-08","2ª hora",3,"Lorem ipsum dolor sit amet,
 consectetuer adipiscing elit. Aenean commodo ligula eget dolor. 
Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, 
nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, 
pretium quis, sem. Nulla consequat massa", "2017-04-09", "teléfono"),
("4","5","2","matemáticas","2017-04-08","2ª hora",5,"Lorem ipsum dolor sit amet,
 consectetuer adipiscing elit. Aenean commodo ligula eget dolor. 
Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, 
nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, 
pretium quis, sem. Nulla consequat massa", "2017-04-09", "teléfono"),
("5","1","1","matemáticas","2017-04-08","3ª hora",5,"Lorem ipsum dolor sit amet,
 consectetuer adipiscing elit. Aenean commodo ligula eget dolor. 
Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, 
nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, 
pretium quis, sem. Nulla consequat massa", "2017-04-09", "teléfono"),
("5","4","3","matemáticas","2017-04-08","4ª hora",10,"Lorem ipsum dolor sit amet,
 consectetuer adipiscing elit. Aenean commodo ligula eget dolor. 
Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, 
nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, 
pretium quis, sem. Nulla consequat massa", "2017-04-09", "teléfono"),
("1","9","5","matemáticas","2017-04-08","5ª hora",10,"Lorem ipsum dolor sit amet,
 consectetuer adipiscing elit. Aenean commodo ligula eget dolor. 
Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, 
nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, 
pretium quis, sem. Nulla consequat massa", "2017-04-09", "teléfono"); 





