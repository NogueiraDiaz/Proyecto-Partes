<?php

include_once 'Alumno.inc.php';

class RepositorioAlumno {

    public static function getAlumnos($conexion) {
        if (isset($conexion)) {
            try {
                $sql = "SELECT * FROM AlumnosPartes";
                $sentencia = $conexion->prepare($sql);

                $sentencia->execute();

                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function getAlumnoCodigo($conexion, $codigo) {
        if (isset($conexion)) {
            try {
                $sql = "SELECT matricula, nombre, apellidos, grupo FROM AlumnosPartes WHERE matricula=:codigo ";


                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":codigo", trim($codigo), PDO::PARAM_STR);
                $sentencia->execute();
				
                return $sentencia->fetch();
            } catch (PDOException $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function getAlumnosGrupo($conexion, $grupo) {
        if (isset($conexion)) {
            try {
                $sql = "SELECT * FROM AlumnosPartes WHERE grupo=:grupo "
                        . "ORDER BY apellidos";


                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":grupo", $grupo, PDO::PARAM_STR);
                $sentencia->execute();

                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
    }
    public static function getAlumnoNombre($grupo, $nombre_alumno) {
        foreach ($grupo as $alumno) {
            if (($alumno["nombre"] . " " . $alumno["apellidos"]) === $nombre_alumno) {
                return $alumno;
            }
        }
    }

    public static function getAlumnoNombreyGrupo($conexion, $nombre, $apellidos, $grupo) {
        if (isset($conexion)) {
            try {

                $sql = 
"SELECT matricula "
. "FROM AlumnosPartes "
. "WHERE grupo = :grupo AND nombre = :nombre AND apellidos = :apellidos";
			
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":grupo", $grupo, PDO::PARAM_STR);
                $sentencia->bindParam(":nombre", $nombre, PDO::PARAM_STR);
                $sentencia->bindParam(":apellidos", $apellidos, PDO::PARAM_STR);
                $sentencia->execute();
                return $sentencia->fetch()[0];
            } catch (PDOException $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function getAlumnosNombreBusqueda($conexion, $nombre) {
        if (isset($conexion)) {
            try {
                $sql = "SELECT * FROM AlumnosPartes WHERE nombre like :nombre "
                        . "ORDER BY apellidos";

                $nombre = $nombre . "%";

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":nombre", $nombre, PDO::PARAM_STR);
                $sentencia->execute();

                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function getAlumnosApellidosBusqueda($conexion, $apellidos) {
        if (isset($conexion)) {
            try {
                $sql = "SELECT * FROM AlumnosPartes WHERE apellidos like :apellidos "
                        . "ORDER BY apellidos";
                $apellidos = "%" . $apellidos . "%";

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":apellidos", $apellidos, PDO::PARAM_STR);
                $sentencia->execute();

                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
    }
    public static function cargarAlumnosCurso($conexion, $grupo, $f_entrada) {
        if (($fichero = fopen(pathinfo($f_entrada), "r")) !== FALSE) {
            //lectura para quitar la primer linea con las cabeceras
            $salida = TRUE;
            fgetcsv($fichero, 1000, ",");
            while (($alumnos = fgetcsv($fichero, 1000, ",")) !== FALSE) {
                $alumno = new Alumno(
                    //Matricula
                    utf8_encode($alumno[0]),
                    //Nombre
                    explode(', ', $alumno[1])[1],
                    //Apellidos
                    explode(', ', $alumno[1])[0],
                    //Grupo
                    $grupo
                );
                if (!self::NuevoAlumno($conexion, $alumno)) {
                    $salida = FALSE;
                }
            }
        }
        fclose($fichero);
        return $salida;
    }
    public static function NuevoAlumno($conexion, $alumno) {
        if (isset($conexion)) {
            try {

                $sql = "INSERT INTO `AlumnosPartes`(`matricula`, `nombre`, `apellidos`, `grupo`) "
                ."VALUES (:Matricula, :Nombre, :Apellidos, :Grupo)";

                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(":Matricula",$alumno->getMatricula(), PDO::PARAM_STR);
                $sentencia->bindParam(":Nombre",$alumno->getNom_alumno(), PDO::PARAM_STR);
                $sentencia->bindParam(":Apellidos",$alumno->getApe_alumno(), PDO::PARAM_STR);
                $sentencia->bindParam(":Grupo",$alumno->getGrupo(), PDO::PARAM_STR);

                return $sentencia->execute();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }
    public static function cambiarDatosAlumno($conexion, $alumno, $matricula) {
        if (isset($conexion)) {
            try {
                $sql = "UPDATE `AlumnosPartes` "
                ."SET `matricula`=:Matricula, "
                ."`nombre`=:Nombre, "
                ."`apellidos`=:Apellidos, "
                ."`grupo`=:Grupo "
                ."WHERE `matricula` = :Matricula";

                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(":Matricula", $matricula, PDO::PARAM_STR);
                $sentencia->bindParam(":Nombre", $alumno->getNom_alumno(), PDO::PARAM_STR);
                $sentencia->bindParam(":Apellidos", $alumno->getApe_alumno(), PDO::PARAM_STR);
                $sentencia->bindParam(":Grupo", $alumno->getGrupo(), PDO::PARAM_STR);


                return $sentencia->execute();
            } catch (PDOException $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function mensajeEdicionAlumno($comprobar, $texto) {
        if ($comprobar == 1) {
            echo "<div class='alert alert-success text-center' role='alert'>"
            . $texto .
            "</div>";
        } else {
            echo "<div class='alert alert-danger text-center' role='alert'> 
                La operacion no se realiza correctamente.
             </div>";
        }
    }

    public static function getGrupos($conexion) {
        if (isset($conexion)) {
            try {
                $sql = "SELECT grupo FROM Cursos ";

                $sentencia = $conexion->prepare($sql);
                $sentencia->execute();

                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
    }
	
	public static function getAlumnosCurso($conexion, $curso) {
        if (isset($conexion)) {
            try {
                $sql = "SELECT A.nombre ANombre, A.apellidos AApellidos, PR.nombre PNombre, PR.apellidos PApellidos, P.incidencia, P.fecha, CONCAT(P.dni_Profesor,P.matricula_alumno,P.fecha,P.hora) cod_parte "
."FROM Partes P "
."	JOIN AlumnosPartes A ON P.matricula_Alumno = A.matricula "
."    JOIN Usuarios PR ON P.Dni_Profesor = PR.dni "
."WHERE A.grupo = :gr";

                $sentencia = $conexion->prepare($sql);
				$sentencia->bindParam(":gr", $curso, PDO::PARAM_STR);
                $sentencia->execute();
                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
    }

}
