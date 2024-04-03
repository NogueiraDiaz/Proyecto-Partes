<?php
class RepositorioExpulsion {
	
	public static function recalcExpulsionAlumno($conexion, $matricula){
		if(isset($conexion)){
			try{
				$sql = 
"DELETE FROM Expulsiones "
. "WHERE matricula_del_Alumno = '$matricula' AND fecha_Inicio IS NULL AND 10 > ("
			. "SELECT SUM(p.puntos) Puntos "
			. "FROM Partes p "
			. "WHERE p.matricula_Alumno = '$matricula' AND p.caducado = 1)";
				$sentencia = $conexion->query($sql);
			}catch(PDOException $ex){
				print "ERROR: " . $ex->getMessage();
			}
		}
	}

    public static function nuevaExpulsion($conexion, $matricula, $fecha_inicio, $fecha_fin) {
        if (isset($conexion)) {
            try {

                $sql = "INSERT INTO `Expulsiones`(`matricula_del_Alumno`, `fecha_Inicio`, `fecha_Fin`) VALUES (:Matricula,:Fecha_Inicio,:Fecha_Fin)";

                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(":Fecha_Inicio", $fecha_inicio, PDO::PARAM_NULL);
                $sentencia->bindParam(":Fecha_Fin", $fecha_fin, PDO::PARAM_NULL);
                $sentencia->bindParam(":Matricula", $matricula, PDO::PARAM_STR);

                $sentencia->execute();

                return self::ultimaExpulsion($conexion);
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function ultimaExpulsion($conexion) {
        if (isset($conexion)) {
            try {

                $sql = "SELECT max(cod_expulsion) AS ultima_expulsion FROM Expulsiones ";

                $sentencia = $conexion->prepare($sql);

                $sentencia->execute();

                return $sentencia->fetch()["ultima_expulsion"];
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function anadirfechaExpulsion($conexion, $matr, $fecha_fin, $fecha_inicio) {
        if (isset($conexion)) {
            try {
                if ($fecha_fin)

                $sql = "UPDATE Expulsiones E "
. "	JOIN Partes P ON E.matricula_del_Alumno = P.matricula_Alumno "
. "SET fecha_Inicio = :Fecha_Inicio, fecha_Fin = :Fecha_Fin "
. "WHERE E.matricula_del_Alumno = :Matricula AND P.caducado = 1 AND E.fecha_Inicio IS NULL AND E.fecha_Fin IS NULL";

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":Matricula", $matr, PDO::PARAM_STR);
                $sentencia->bindParam(":Fecha_Inicio", date("Y-m-d", strtotime($fecha_fin)), PDO::PARAM_STR);
                $sentencia->bindParam(":Fecha_Fin", date("Y-m-d", strtotime($fecha_inicio)), PDO::PARAM_STR);
                $sentencia->execute();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function getExpulsionesAlumnos($conexion, $grupo, $fecha_inicio, $fecha_fin) {
        if (isset($conexion)) {
            try {
                
                $sql="select a.nombre, a.apellidos, e.fecha_Inicio, e.fecha_Fin "
                ."from Expulsiones e "
                ."join AlumnosPartes a on a.matricula = e.matricula_del_Alumno "
                ."where a.grupo = :Grupo and e.fecha_Inicio BETWEEN :FechaIni and :FechaFin";

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":Grupo", $grupo, PDO::PARAM_STR);
                $sentencia->bindParam(":FechaIni", date("Y-m-d", strtotime($fecha_inicio)), PDO::PARAM_STR);
                $sentencia->bindParam(":FechaFin", date("Y-m-d", strtotime($fecha_fin)), PDO::PARAM_STR);
                $sentencia->execute();

                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }
    
    #TODO: MUY IMPORTANTE MODIFICAR TODAS LAS LLAMADAS A ESTE METODO Y LA OBTENCION DE SUS PARAMETROS
        public static function borrarExpulsionCodigo($conexion, $Matricula, $FechaIns) {
        if (isset($conexion)) {
            try {

                $sql = "delete from Expulsiones "
                ."where matricula_del_Alumno = :Matricula and fecha_Insercion = :FechaIns";

                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(":Matricula", $Matricula, PDO::PARAM_STR);
                $sentencia->bindParam(":FechaIns", date("Y-m-d", strtotime($FechaIns)), PDO::PARAM_STR);

                $sentencia->execute();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }
        public static function getdatosExpulsionCodigo($conexion, $Matricula) {
        if (isset($conexion)) {
            try {

                $sql = "SELECT * FROM Expulsiones WHERE matricula_del_Alumno = :Matricula";

                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(":Matricula", $Matricula, PDO::PARAM_STR);

                $sentencia->execute();
                 return $sentencia->fetch();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }

}
