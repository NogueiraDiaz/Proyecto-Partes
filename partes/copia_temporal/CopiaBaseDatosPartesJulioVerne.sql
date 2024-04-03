SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
--
-- Nombre Ejecutor: Direccion JulioVerne
-- Database: `9383564_partes`
--




CREATE TABLE IF NOT EXISTS `Alumnos` (
  `Matricula` varchar(20) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `Apellidos` varchar(50) NOT NULL,
  `Dni` varchar(12) DEFAULT NULL,
  `Puntos_Actuales` int(11) DEFAULT NULL,
  `Puntos_Acumulados` int(11) DEFAULT NULL,
  `Telefono` varchar(15) DEFAULT NULL,
  `Telefono_fijo` varchar(12) DEFAULT NULL,
  `Direccion` varchar(100) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Nombre_Tutor1` varchar(30) DEFAULT NULL,
  `Nombre_Tutor2` varchar(30) DEFAULT NULL,
  `Movil_Tutor1` varchar(15) DEFAULT NULL,
  `Movil_Tutor2` varchar(15) DEFAULT NULL,
  `Fijo_Tutor1` varchar(15) DEFAULT NULL,
  `Fijo_Tutor2` varchar(15) DEFAULT NULL,
  `Email_Tutor1` varchar(50) DEFAULT NULL,
  `Email_Tutor2` varchar(50) DEFAULT NULL,
  `Grupo` varchar(20) NOT NULL,
  PRIMARY KEY (`Matricula`,`Grupo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE IF NOT EXISTS `Cursos` (
  `Grupo` varchar(20) NOT NULL,
  PRIMARY KEY (`Grupo`),
  UNIQUE KEY `fk_Grupo` (`Grupo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE IF NOT EXISTS `Expulsiones` (
  `Matricula_del_Alumno` varchar(20) NOT NULL,
  `Fecha_Inicio` date DEFAULT NULL,
  `Fecha_Fin` date DEFAULT NULL,
  `Fecha_Insercion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Matricula_del_Alumno`,`Fecha_Insercion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE IF NOT EXISTS `Incidencias` (
  `Nombre` varchar(100) NOT NULL,
  `Puntos` int(11) NOT NULL,
  `Descripcion` text,
  PRIMARY KEY (`Puntos`,`Nombre`),
  KEY `Nombre` (`Nombre`,`Puntos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE IF NOT EXISTS `Partes` (
  `Dni_Profesor` varchar(12) NOT NULL,
  `Matricula_Alumno` varchar(20) NOT NULL,
  `Incidencia` varchar(100) NOT NULL,
  `Puntos` int(11) NOT NULL,
  `Materia` varchar(40) DEFAULT NULL,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Descripcion` text,
  `Fecha_Comunicacion` date NOT NULL,
  `Via_Comunicacion` varchar(25) NOT NULL,
  `Tipo_Parte` varchar(20) NOT NULL,
  `Caducado` tinyint(1) NOT NULL,
  PRIMARY KEY (`Dni_Profesor`,`Matricula_Alumno`,`Incidencia`,`Fecha`,`Hora`),
  KEY `Matricula_Alumno` (`Matricula_Alumno`),
  KEY `Incidencia` (`Incidencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE IF NOT EXISTS `Profesores` (
  `DNI` varchar(12) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `Apellidos` varchar(50) NOT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Contrasenia` varchar(255) NOT NULL,
  `Nivel_Acceso` tinyint(4) NOT NULL,
  `Tutor_Grupo` varchar(20) NOT NULL,
  PRIMARY KEY (`DNI`,`Tutor_Grupo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

















INSERT INTO Profesores VALUES
("00000000a","Direccion","JulioVerne","direccion@iesbargas.com","$2y$10$pL.qZgws6JFLZyd5RM9Uz.SgzNnLrMP8hBf9IqCtSzV9FdqAOD9/y","0","");




/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;