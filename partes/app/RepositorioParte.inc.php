<?php

class RepositorioParte {
    
    public static function CaducarPartes($conexion, $matricula){
        if (isset($conexion)) {
            try {
                $sql = "UPDATE Partes "
                     . "SET caducado = Caducado + 1 "
                     . "WHERE matricula_Alumno = :matr AND caducado <> 1";

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":matr", $matricula, PDO::PARAM_STR);
                return $sentencia->execute();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }
	
	public static function CaducarParte($conexion, $parte){
		if (isset($conexion)) {
			try {
				$sql =
"UPDATE Partes "
. "SET caducado = caducado + 1 "
. "WHERE CONCAT(dni_Profesor,matricula_Alumno,fecha,hora) = :parte";
				$sentencia = $conexion->prepare($sql);
				$sentencia->bindParam(":parte", $parte, PDO::PARAM_STR);
				$sentencia->execute();
			}catch (PDOException $ex){
				print "ERROR: " . $ex->getMessage();
			}
		}
	}

    public static function nuevoParte($conexion, $parte) {
        if (isset($conexion)) {
            try {
                
                $sql = "INSERT INTO `Partes`(`dni_Profesor`, `matricula_Alumno`, `incidencia`, `puntos`, `materia`, `fecha`, `hora`, `descripcion`, `fecha_Comunicacion`, `via_Comunicacion`, `tipo_Parte`, `caducado`) "
                ."VALUES (:Dni_Profesor,:Matricula_Alumno,:Incidencia,:Puntos,:Materia,:Fecha,:Hora,:Descripcion,:Fecha_Comunicacion,:Via_Comunicacion,:Tipo_Parte,:Caducado)";
                
                $sentencia = $conexion->prepare($sql);
                 
                $sentencia->bindParam(":Dni_Profesor", $parte->getDni_Profesor(), PDO::PARAM_STR);
                $sentencia->bindParam(":Matricula_Alumno", $parte->getMatricula_Alumno(), PDO::PARAM_STR);
                $sentencia->bindParam(":Incidencia", $parte->getIncidencia(), PDO::PARAM_STR);
                $sentencia->bindParam(":Puntos", $parte->getPuntos(), PDO::PARAM_INT);
                $sentencia->bindParam(":Materia", $parte->getMateria(), PDO::PARAM_STR);
                $sentencia->bindParam(":Fecha", date("Y-m-d", strtotime($parte->getFecha())), PDO::PARAM_STR);
                $sentencia->bindParam(":Hora", date("H:i:s", strtotime($parte->getHora())), PDO::PARAM_STR);
                $sentencia->bindParam(":Descripcion", $parte->getDescripcion(), PDO::PARAM_STR);
                $sentencia->bindParam(":Fecha_Comunicacion", date("Y-m-d", strtotime($parte->getFecha_Comunicacion())), PDO::PARAM_STR);
                $sentencia->bindParam(":Via_Comunicacion", $parte->getVia_Comunicacion(), PDO::PARAM_STR);
                $sentencia->bindParam(":Tipo_Parte", $parte->getTipo_Parte(), PDO::PARAM_STR);
                $sentencia->bindParam(":Caducado", $parte->getCaducado(), PDO::PARAM_INT);
                
                return $sentencia->execute();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }
    
    public static function expulsadoParte($conexion, $alumno) {
        if (isset($conexion)) {
            try {
                
                $sql = "SELECT SUM(puntos) AS puntos FROM `Partes` WHERE matricula_Alumno= :matr AND caducado = 0";
                
                $sentencia = $conexion->prepare($sql);
                
                $sentencia->bindParam(":matr", $alumno, PDO::PARAM_STR);
                $sentencia->execute();
                return $sentencia->fetch()["puntos"];
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }
    
    public static function getPartesAlumno($conexion, $alumno) {
        if (isset($conexion)) {
            try {
                
                $sql = "SELECT * FROM `Partes` WHERE matricula_Alumno = :matr ";
                
                $sentencia = $conexion->prepare($sql);
                
                $sentencia->bindParam(":matr", $alumno, PDO::PARAM_STR);
                $sentencia->execute();
                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }
    
    public static function tresPartes($conexion, $alumno) {
        if (isset($conexion)) {
            try {
                $sql = "SELECT count(dni_Profesor+matricula_Alumno+fecha+hora) AS num_partes FROM Partes "
                . "WHERE matriculaAlumno = :matr ";
                
                $sentencia = $conexion->prepare($sql);
                
                $sentencia->bindParam(":matr", $alumno, PDO::PARAM_STR);
                $sentencia->execute();
                return $sentencia->fetch()["num_partes"];
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }
    
    public static function borrarTodosPartesAlumno($conexion, $partes) {
        if (isset($conexion)) {
            //recorro los partes del alumno, voy creando objetos partes_expulsion
            //para insertarlos en la tabla Parte_Expulsion
            foreach ($partes as $parte) {
                
                self::borrarParteCodigo($conexion, $parte->getDni_Profesor().$parte->getMatricula_Alumno().$parte->getFecha().$parte->getHora());
            }
        }
    }
    
    public static function borrarParteCodigo($conexion, $parte) {
        if (isset($conexion)) {
            try {
                
                $sql = "DELETE FROM `Partes` WHERE CONCAT(dni_Profesor,matricula_Alumno,fecha,hora) = :cod_parte";
                
                $sentencia = $conexion->prepare($sql);
                
                $sentencia->bindParam(":cod_parte", $parte, PDO::PARAM_STR);
                
                $sentencia->execute();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }
    
    public static function borrarParteCodigoTodo($conexion, $parte) {
        if (isset($conexion)) {
            try {
                
                self::borrarParteCodigo($conexion, $parte);

            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }
    
    #Esto no se usa pero lo voy a modificar igual por si acaso
    #Ahora borra todos los partes ya que no hay partes de convivencia
    public static function borrarPartesConvivencia($conexion, $alumno) {
        if (isset($conexion)) {
            try {
                
                self::borrarParteCodigo($conexion, $parte->getDni_Profesor().$parte->getMatricula_Alumno().$parte->getFecha().$parte->getHora());

            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }
    
    public static function getPartesCodigoAlumno($conexion, $codigo) {
        if (isset($conexion)) {
            try {
                
                $sql = "SELECT a.nombre NombreAlumno, a.apellidos ApellidosAlumno, p.fecha, p.puntos, pr.nombre, pr.apellidos, CONCAT(dni_Profesor,matricula_Alumno,fecha,hora) cod_parte, p.incidencia "
                ."from Partes p "
                ."join AlumnosPartes a on p.matricula_Alumno = a.matricula "
                ."join Usuarios pr on p.dni_Profesor = pr.dni "
                ."where a.matricula = :matr";
                
                $sentencia = $conexion->prepare($sql);
                
                $sentencia->bindParam(":matr", $codigo, PDO::PARAM_STR);
                
                $sentencia->execute();
                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }
    
    public static function getPartesGrupo($conexion, $grupo) {
        if (isset($conexion)) {
            try {
                
                $sql = "SELECT a.nombre nombreAlumno, a.apellidos apellidosAlumno, p.fecha, p.puntos, pr.nombre, pr.apellidos, CONCAT(dni_Profesor,matricula_Alumno,fecha,hora) cod_parte, p.incidencia "
                ."from Partes p "
                ."join AlumnosPartes a on p.matricula_Alumno = a.matricula "
                ."join Usuarios pr on p.dni_Profesor = pr.dni "
                ."where a.grupo = :grupo";
                
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":grupo", $grupo, PDO::PARAM_STR);
                $sentencia->execute();
                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }
    
    public static function getDatosParte($conexion, $codigo) {
        if (isset($conexion)) {
            try {
                
                $sql = "SELECT a.nombre nombreAlumno, a.apellidos apellidosAlumno, p.incidencia, p.fecha, p.hora, p.puntos, p.descripcion, p.fecha_Comunicacion, p.via_Comunicacion, pr.apellidos apellidosProfesor, pr.nombre nombreProfesor, a.grupo, p.materia, pr.dni, a.matricula "
                ."from Partes p "
                ."join AlumnosPartes a on p.matricula_Alumno = a.matricula "
                ."join Usuarios pr on p.dni_Profesor = pr.dni "
                ."where CONCAT(dni_Profesor,matricula_Alumno,fecha,hora) = :codigo";
                
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":codigo", $codigo, PDO::PARAM_STR);
                $sentencia->execute();
                
                return $sentencia->fetch();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }
    
    public static function getPartesProfesor($conexion, $codigo) {
        if (isset($conexion)) {
            try {
                
                $sql = "SELECT a.nombre aNombre, a.apellidos aApellidos, p.fecha, p.puntos, pr.nombre prNombre, pr.apellidos prApellidos, CONCAT(dni_Profesor,matricula_Alumno,fecha,hora) cod_parte, p.incidencia, p.descripcion, a.grupo, a.matricula "
                ."from Partes p "
                ."join AlumnosPartes a on p.matricula_Alumno = a.matricula "
                ."join Usuarios pr on p.dni_Profesor = pr.dni "
                ."where p.dni_Profesor = :dni";
                
                
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":dni", $codigo, PDO::PARAM_STR);
                $sentencia->execute();
                
                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }
    
    public static function getTotalNumeroPartesyPartesAlumno($conexion, $grupo) {
        if (isset($conexion)) {
            try {
                // Peazo consulta, para sacar todos los partes de un alumno, tanto los 
                // que pertenecen a una expulsion, como los que no pertenecen a ninguna
                // expulsion
                $sql = "select count(*) total_partes, sum(p.Puntos), a.nombre, a.apellidos "
                ."from Partes p "
                ."join AlumnosPartes a on p.Matricula_Alumno = a.matricula "
                ."where a.grupo = :grupo "
                ."group by matricula_Alumno";
                
                
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":grupo", $grupo, PDO::PARAM_STR);
                $sentencia->execute();
                
                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }
    
    public static function getNumeroPartesyPartesAlumnosinExpulsion($conexion, $grupo) {
        if (isset($conexion)) {
            try {
                $sql = "select count(*) total_partes, sum(p.puntos), a.nombre, a.apellidos, a.matricula "
                ."from Partes p "
                ."join AlumnosPartes a on p.matricula_Alumno = a.matricula "
                ."where a.grupo = :grupo and a.matricula not in (select matricula_Alumno from Expulsiones) "
                ."group by matricula_Alumno";
                
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":grupo", $grupo, PDO::PARAM_STR);
                $sentencia->execute();
                
                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }
    
    public static function getPartesAlumnosFecha($conexion, $fecha_inicio, $fecha_fin) {
        if (isset($conexion)) {
            try {
                
                $sql = "select a.nombre nombreAlumno, a.apellidos apellidosAlumno, a.grupo, p.fecha, p.puntos, pr.nombre nombreProfesor, pr.apellidos apellidosProfesor, CONCAT(dni_Profesor,matricula_Alumno,fecha,hora) cod_parte, p.incidencia "
                ."from Partes p "
                ."join AlumnosPartes a on p.matricula_Alumno = a.matricula " 
                ."join Usuarios pr on pr.dni = p.dni_Profesor "
                ."WHERE p.fecha BETWEEN :fecini and :fecfin";
                
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":fecini", date("Y-m-d", strtotime($fecha_inicio)), PDO::PARAM_STR);
                $sentencia->bindParam(":fecfin", date("Y-m-d", strtotime($fecha_fin)), PDO::PARAM_STR);
                $sentencia->execute();
                
                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }
    
    public static function getPartesAlumnoCodigo($conexion, $codigo, $grupo) {
        if (isset($conexion)) {
            try {
                
                $sql = "select a.nombre, a.apellidos, a.grupo, p.fecha, p.puntos, pr.nombre, pr.apellidos, p.caducado, CONCAT(dni_Profesor,matricula_Alumno,fecha,hora) cod_parte, p.incidencia "
                ."from Partes p "
                ."join AlumnosPartes a on p.matricula_Alumno = a.matricula "
                ."join Usuarios pr on pr.dni = p.dni_Profesor "
                ."WHERE a.matricula = :matr and a.grupo = :grupo";
                
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":matr", trim($codigo), PDO::PARAM_STR);
                $sentencia->bindParam(":grupo", trim($grupo), PDO::PARAM_STR);
                $sentencia->execute();
                
                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }
    public static function getExpulsionesAlumno($conexion, $codigo) {
        if (isset($conexion)) {
            try {
                
                $sql = "SELECT E.matricula_del_Alumno, A.nombre, A.apellidos, E.fecha_Inicio, E.fecha_Fin "
."FROM Expulsiones E "
."JOIN AlumnosPartes A ON E.matricula_del_Alumno = A.matricula "
."WHERE A.matricula = :matr AND E.fecha_Inicio IS NOT NULL AND E.fecha_Fin IS NOT NULL";
                
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":matr", trim($codigo), PDO::PARAM_STR);
                $sentencia->execute();
                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }
}
