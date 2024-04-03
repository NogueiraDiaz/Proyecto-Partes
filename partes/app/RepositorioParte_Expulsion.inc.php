<?php

include_once "app/Parte.inc.php";
include_once "app/RepositorioParte.inc.php";

class RepositorioParte_Expulsion {
	
	public static function CaducarAlExpulsar($conexion, $matricula){
        if (isset($conexion)) {
            try {
                $sql = "UPDATE Partes "
                     . "SET caducado = Caducado + 1 "
                     . "WHERE matricula_Alumno = :matr AND caducado = 1";

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":matr", $matricula, PDO::PARAM_STR);
                return $sentencia->execute();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }

    // Esto tendría que ir en Expulsiones!!!!
    public static function get_Expulsiones_Sin_Fecha($conexion) {
        if (isset($conexion)) {
            try {

                $sql = "select distinct a.matricula, a.nombre NombreAlumno, a.apellidos ApellidosAlumno, e.fecha_Inicio, e.fecha_Fin, e.fecha_Insercion, pr.dni, pr.nombre NombreProfesor, pr.apellidos ApellidosProfesor, a.grupo "
."from Expulsiones e "
."join AlumnosPartes a on e.matricula_del_Alumno = a.matricula "
."join Partes p on p.matricula_Alumno = a.matricula "
."join Usuarios pr on pr.dni = p.dni_Profesor "
."where fecha_inicio is null or fecha_Fin is null "
."group by a.matricula";

                $sentencia = $conexion->prepare($sql);

                $sentencia->execute();
                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                print "ERROR: $sql " . $ex->getMessage();
            }
        }
    }
#TODO: BUSCAR LA IMPLEMENTACION DE ESTO Y MODIFICAR LOS PARAMETROS QUE SE LE PASAN AL METODO
# ADEMAS DE TODOS LOS VALORES QUE SE UTILIZEN A RAIZ DE ESTE
# ESTO TIENE JALEO DE LA HOSTIA
    public static function get_Expulsiones_Codigo($conexion, $matr) {
        if (isset($conexion)) {
            try {
                $sql = "SELECT A.nombre nombreAlumno, A.apellidos apellidosAlumno, PR.nombre nombreProfesor, PR.apellidos apellidosProfesor, P.fecha, P.incidencia, P.puntos, P.descripcion, A.matricula "
."FROM Partes P "
.  "JOIN AlumnosPartes A ON P.matricula_Alumno = A.matricula "
.  "JOIN Usuarios PR ON P.dni_Profesor = PR.dni "
."WHERE A.matricula = :matr AND P.caducado = 1";

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":matr", $matr, PDO::PARAM_STR);
                $sentencia->execute();
                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function borrarParteCodigo($conexion, $matricula, $FechaInser) {
        if (isset($conexion)) {
            try {

                $sql = "DELETE FROM Partes WHERE matricula = :matr AND fecha";

                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(":cod_parte", $parte, PDO::PARAM_INT);

                $sentencia->execute();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function getDatosParteExpulsion($conexion, $matr) {
        if (isset($conexion)) {
            try {

                $sql = "select a.nombre nombreAlumno, a.apellidos apellidoAlumno, pr.apellidos ApellidosProfesor, pr.nombre NombreProfesor, a.grupo, p.incidencia, p.fecha, "
                ."p.puntos, p.materia, p.descripcion, p.fecha_Comunicacion, p.via_Comunicacion, "
                ."CONCAT(dni_Profesor,matricula_Alumno,fecha,hora) cod_parte_expulsion "
                ."from Partes p "
                ."join Usuarios pr on p.dni_Profesor = pr.dni "
                ."join Alumnos a on a.matricula = p.matricula_Alumno "
                ."where a.matricula = :matr and p.tipo_Parte = 'Expulsion'";

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":matr", $matr, PDO::PARAM_STR);
                $sentencia->execute();

                return $sentencia->fetch();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }
    public static function getDatosExpulsion($conexion, $dni, $matr, $fec, $hora) {
        if (isset($conexion)) {
            try {

                $sql = "select a.nombre, a.apellidos, pr.apellidos, pr.nombre, a.grupo, p.incidencia, p.fecha, "
                ."p.hora, p.puntos, p.materia, p.descripcion, p.fecha_Comunicacion, p.via_Comunicacion, "
                ."CONCAT(p.dni_Profesor,p.matricula_Alumno,p.fecha,p.hora) cod_parte_expulsion "
                ."from Partes p "
                ."join AlumnosPartes a on p.matricula_Alumno = a.matricula " 
                ."join Usuarios pr on pr.dni = p.dni_Profesor "
                ."join Expulsiones e on e.matricula_del_Alumno = a.matricula "
                ."where p.dni_Profesor = :dni and p.matricula_Alumno = :matr and p.fecha = :fecha and p.hora = :hora and p.tipo_Parte = 'Expulsion'";

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":dni", $dni, PDO::PARAM_STR);
                $sentencia->bindParam(":matr", $matr, PDO::PARAM_STR);
                $sentencia->bindParam(":fecha", $fec, date( "Y-m-d", strtotime($fec)), PDO::PARAM_STR);
                $sentencia->bindParam(":hora", date( "H:i:s", strtotime($hora)), PDO::PARAM_STR);
                $sentencia->execute();

                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function getPartesExpulsionAlumnosCodigo($conexion, $matr) {
        if (isset($conexion)) {
            try {

                $sql = "select a.nombre NAlumno, a.apellidos AAlumno, e.fecha_Inicio, e.fecha_Fin, p.incidencia, e.matricula_del_Alumno+e.fecha_Insercion cod_expulsion, p.puntos, pr.apellidos PApellidos, "
                ."pr.nombre PNombre, p.fecha, CONCAT(p.dni_Profesor,p.matricula_Alumno,p.fecha,p.hora) cod_parte_expulsion, p.caducado "
                ."from Expulsiones e "
                ."join AlumnosPartes a on a.matricula = e.matricula_del_Alumno "
                ."join Partes p on p.matricula_Alumno = a.matricula "
                ."join Usuarios pr on pr.dni = p.dni_Profesor "
                ."where p.matricula_Alumno = :matr AND p.caducado <> 0 AND e.fecha_Inicio IS NOT NULL AND e.fecha_Fin IS NOT NULL";

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":matr", $matr, PDO::PARAM_STR);
                $sentencia->execute();
                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function getPartesExpulsionAlumnosCodigoExpulsion($conexion, $matr, $codigos) {
        if (isset($conexion)) {
            try {

                $sql = "select a.nombre nAlumno, a.apellidos aAlumno, e.fecha_Inicio, e.fecha_Fin, p.incidencia, e.matricula_del_Alumno+e.fecha_Insercion cod_expulsion, p.puntos, pr.apellidos pApellidos, "
                ."pr.nombre pNombre, p.fecha, CONCAT(p.dni_Profesor,p.matricula_Alumno,p.fecha,p.hora) cod_parte_expulsion, p.caducado "
                ."from Expulsiones e "
                ."join AlumnosPartes a on a.matricula = e.matricula_del_Alumno "
                ."join Partes p on p.matricula_Alumno = a.matricula "
                ."join Usuarios pr on pr.dni = p.dni_Profesor "
                ."where p.matricula_Alumno = :matr AND p.caducado <> 0 AND e.matricula_del_Alumno = :matr1 AND e.fecha_Insercion= :codigos";

               /* if ($codigos){
                    $i = 0;
                    while ($i < count($codigos) -1) {
                        $codigos[$i] = "'$codigos[$i]'";
                    }
                    $sql .= " AND e.matricula_del_Alumno+e.fecha_Insercion IN (" . implode(",", $codigos) . ")";
                } else {
                    $sql .= " AND 1 = 0";
                }*/

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":matr", $matr, PDO::PARAM_STR);
                $sentencia->bindParam(":matr1", $matr, PDO::PARAM_STR);
                $sentencia->bindParam(":codigos", $codigos, PDO::PARAM_STR);

                $sentencia->execute();
                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function getFechasExpulsion($conexion, $matricula){
        if (isset($conexion)) {
            try {

                $sql = "SELECT fecha_Inicio, fecha_Fin, matricula_del_Alumno, fecha_Insercion "
                . "FROM Expulsiones "
                . "WHERE matricula_del_Alumno = :matr AND fecha_Inicio IS NOT NULL AND fecha_Fin IS NOT NULL";

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":matr", $matricula, PDO::PARAM_STR);
                $sentencia->execute();
                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function getPartesExpulsionAlumnosGrupo($conexion, $grupo) {
        if (isset($conexion)) {
            try {

                $sql = "select a.nombre nombreAlumno, a.apellidos apellidosAlumno, pr.apellidos apellidosProfesor, pr.nombre nombreProfesor, a.grupo, p.incidencia, p.fecha, "
                ."p.hora, p.puntos, p.materia, p.descripcion, p.fecha_Comunicacion, p.via_Comunicacion, "
                ."CONCAT(p.dni_Profesor,p.matricula_Alumno,p.fecha,p.hora) cod_parte_expulsion, e.fecha_Inicio, e.fecha_Fin "
                ."from Partes p "
                ."join AlumnosPartes a on p.matricula_Alumno = a.matricula "
                ."join Usuarios pr on pr.dni = p.dni_Profesor "
                ."join Expulsiones e on e.matricula_del_Alumno = a.matricula "
                ."where p.tipo_Parte = 'Expulsion' and a.grupo = :grupo";

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":grupo", $grupo, PDO::PARAM_STR);

                $sentencia->execute();
                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function getPartesExpulsionAlumnos($conexion, $matricula) {
        if (isset($conexion)) {
            try {

                $sql = "select a.nombre, a.apellidos, e.fecha_Inicio, e.fecha_Fin, e.matricula_del_Alumno+e.fecha_Insercion cod_expulsion, "
                ."p.incidencia, CONCAT(p.dni_Profesor,p.matricula_Alumno,p.fecha,p.hora) cod_parte_expulsion, "
                ."p.puntos, pr.apellidos, pr.nombre, e.fecha_Insercion "
                ."from Expulsiones e "
                ."join AlumnosPartes a on a.matricula = e.matricula_del_Alumno "
                ."join Partes p on a.matricula = p.matricula_Alumno "
                ."join Usuarios pr on pr.dni = p.dni_Profesor "
                ."WHERE e.matricula_del_Alumno = :matr";

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":matr", $matricula, PDO::PARAM_STR);

                $sentencia->execute();
                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function getPartesExpulsionGrupo($conexion, $grupo) {
        if (isset($conexion)) {
            try {

                $sql = "select a.nombre, a.apellidos, e.fecha_Inicio, e.fecha_Fin, e.matricula_del_Alumno+e.fecha_Insercion cod_expulsion, "
                ."p.incidencia, CONCAT(p.dni_Profesor,p.matricula_Alumno,p.fecha,p.hora) cod_parte_expulsion, "
                ."p.puntos, pr.apellidos, pr.nombre, e.fecha_Insercion "
                ."from Expulsiones e "
                ."join AlumnosPartes a on a.matricula = e.matricula_del_Alumno "
                ."join Partes p on a.matricula = p.matricula_Alumno "
                ."join Usuarios pr on pr.dni = p.dni_Profesor "
                ."WHERE a.grupo = :grupo";

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":grupo", $grupo, PDO::PARAM_STR);

                $sentencia->execute();
                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function sumarPuntosPartesExpulsion($conexion, $matr) {
        if (isset($conexion)) {
            try {
                $sql = "select sum(puntos) suma_puntos_partes_expulsion "
                ."from Partes "
                ."where matricula_Alumno = :expulsion and tipo_Parte = 'Expulsion'";

                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(":expulsion", $matr, PDO::PARAM_STR);
                $sentencia->execute();
                return $sentencia->fetch()["suma_puntos_partes_expulsion"];
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function getPartesExpulsion($conexion, $expulsion) {
        if (isset($conexion)) {
            try {
                $sql = "select a.nombre NombreAlumno, a.apellidos ApellidosAlumno, pr.nombre NombreProfesor, pr.apellidos ApellidosProfesor, p.puntos, p.incidencia, p.fecha, p.hora, e.fecha_Insercion, a.matricula"
                        ."from Partes p "
                        ."join Expulsiones e on e.matricula_Alumno = a.matricula "
                        ."join AlumnosPartes a on p.matricula_Alumno = a.matricula "
                        ."join Usuarios pr on pr.dni = p.dni_Profesor "
                        ."where P.matricula_Alumno = :expulsion and p.tipo_Parte = 'Expulsion'";

                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(":expulsion", $expulsion, PDO::PARAM_STR);
                $sentencia->execute();
                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function getPartesProfesor($conexion, $dni) {
        if (isset($conexion)) {
            try {

                $sql = "select a.nombre, a.apellidos, pr.apellidos, pr.nombre, p.incidencia, e.fecha_Inicio, p.fecha, "
                ."p.puntos, a.grupo, CONCAT(p.dni_Profesor,p.matricula_Alumno,p.fecha,p.hora) cod_parte_expulsion, "
                ."e.matricula_del_Alumno+e.fecha_Insercion cod_expulsion "
                ."from Partes p "
                ."join AlumnosPartes a on p.matricula_Alumno = a.matricula "
                ."join Usuarios pr on pr.dni = p.dni_Profesor "
                ."join Expulsiones e on e.matricula_del_Alumno = a.matricula "
                ."where p.tipo_Parte = 'Expulsion' and pr.dni = :Dni";


                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":Dni", $dni, PDO::PARAM_STR);
                $sentencia->execute();

                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function getPartesAlumnoCodigo($conexion, $matricula, $grupo) {
        if (isset($conexion)) {
            try {

                $sql = "select a.nombre, a.apellidos, p.fecha, p.puntos, pr.nombre, pr.apellidos, "
                ."CONCAT(p.dni_Profesor,p.matricula_Alumno,p.fecha,p.hora) cod_parte_expulsion, p.incidencia "
                ."from Partes p "
                ."join AlumnosPartes a on p.matricula_Alumno = a.matricula "
                ."join Usuarios pr on p.dni_Profesor = pr.dni "
                ."where a.grupo = :grupo and a.matricula = :matricula and p.tipo_Parte = 'Expulsion'";

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":matricula", $matricula, PDO::PARAM_STR);
                $sentencia->bindParam(":grupo", $grupo, PDO::PARAM_STR);
                $sentencia->execute();

                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function getPartesAlumnosExpulsionFecha($conexion, $fecha_inicio, $fecha_fin) {
        if (isset($conexion)) {
            try {

                $sql ="select a.nombre nombreAlumno, a.apellidos apellidosAlumno, a.grupo, e.fecha_Inicio, p.incidencia, p.fecha, p.puntos, pr.apellidos, "
                ."pr.nombre, e.matricula_del_Alumno+e.fecha_Insercion cod_expulsion, "
                ."CONCAT(p.dni_Profesor,p.matricula_Alumno,p.fecha,p.hora) cod_parte_expulsion "
                ."from Partes p "
                ."join AlumnosPartes a on p.matricula_Alumno = a.matricula "
                ."join Usuarios pr on p.dni_Profesor = pr.dni "
                ."join Expulsiones e on e.matricula_del_Alumno = a.matricula "
                ."where p.fecha BETWEEN :fecini and :fecfin";
                $sentencia = $conexion->prepare($sql);
                        Conexion::abrirConexion();
                        $alumnos_expulsados = RepositorioParte_Expulsion::get_Expulsiones_Sin_Fecha
                                        (Conexion::getConexion());

                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }
    public static function getExpulsionesGrupo($conexion, $codigo) {
        if (isset($conexion)) {
            try {
                
                $sql = "SELECT E.matricula_del_Alumno, A.nombre, A.apellidos, E.fecha_Inicio, E.fecha_Fin "
                            ."FROM Expulsiones E "
                            ."JOIN AlumnosPartes A ON E.matricula_del_Alumno = A.matricula "
                            ."WHERE A.grupo = :matr AND E.fecha_Inicio IS NOT NULL AND E.fecha_Fin IS NOT NULL";
                                            
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
