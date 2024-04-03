<?php

class RepositorioProfesor {

    public static function nuevoProfesor($conexion, $profesor) {
        if (isset($conexion)) {
            try {

                $sql = "INSERT INTO `Profesores`(`DNI`, `Nombre`, `Apellidos`, `Email`, `Contrasenia`, `Nivel_Acceso`, `Tutor_Grupo`)"
                ."VALUES (:DNI, :Nombre, :Apellidos, :Email, :Contrasenia, :Nivel_Acceso, :Tutor_Grupo)";

                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(":DNI", $profesor->getDNI(), PDO::PARAM_STR);
                $sentencia->bindParam(":Nombre", $profesor->getNombre(), PDO::PARAM_STR);
                $sentencia->bindParam(":Apellidos", $profesor->getApellidos(), PDO::PARAM_STR);
                $sentencia->bindParam(":Email", $profesor->getEmail(), PDO::PARAM_STR);
                $sentencia->bindParam(":Contrasenia", $profesor->getContrasenia(), PDO::PARAM_STR);
                $sentencia->bindParam(":Nivel_Acceso", $profesor->getNivel_Acceso(), PDO::PARAM_INT);
                $sentencia->bindParam(":Tutor_Grupo", $profesor->getTutor_Grupo(), PDO::PARAM_STR);

                return $sentencia->execute();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function getProfesorEmail($conexion, $email) {
        if (isset($conexion)) {
            try {

                $sql = "SELECT DNI, Nombre, Apellidos, Email, Contrasenia, Nivel_Acceso, Tutor_Grupo FROM Profesores WHERE Email = :email";

                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(":email", $email, PDO::PARAM_STR);

                $sentencia->execute();

                return $sentencia->fetch();
            } catch (PDOException $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function getProfesorCodigo($conexion, $cod_profesor) {
        if (isset($conexion)) {
            try {

                $sql = "SELECT * FROM Profesores WHERE DNI = :cod_profesor";

                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(":cod_profesor", $cod_profesor, PDO::PARAM_STR);

                $sentencia->execute();

                return $sentencia->fetch();
            } catch (PDOException $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function getProfesores($conexion) {
        if (isset($conexion)) {
            try {
                $sql = "SELECT * FROM Profesores ORDER BY Apellidos";
                $sentencia = $conexion->prepare($sql);
                $sentencia->execute();

                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function cambiarPasswordProfesor($conexion, $cod_profesor, $password) {
        if (isset($conexion)) {
            try {
                $sql = "UPDATE `Profesores` SET `Contrasenia`= :password "
                        . " WHERE `DNI`= :cod_profesor ";

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":cod_profesor", $cod_profesor, PDO::PARAM_STR);
                $sentencia->bindParam(":password", $password, PDO::PARAM_STR);

                return $sentencia->execute();
            } catch (PDOException $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function cambiarDatosProfesor($conexion, $profesor) {
        if (isset($conexion)) {
            try {
                $sql = "UPDATE `Profesores` SET "
                ."`DNI` = :DNI, "
                ."`Nombre` = :Nombre, "
                ."`Apellidos` = :Apellidos, "
                ."`Email` = :Email, "
                ."`Contrasenia` = :Contrasenia, "
                ."`Nivel_Acceso` = :Nivel_Acceso, "
                ."`Tutor_Grupo` = :Tutor_Grupo "
                ."WHERE `DNI` = :DNI ";

                $sentencia = $conexion->prepare($sql);
                
                $sentencia->bindParam(":DNI", $profesor->getDNI(), PDO::PARAM_STR);
                $sentencia->bindParam(":Nombre", $profesor->getNombre(), PDO::PARAM_STR);
                $sentencia->bindParam(":Apellidos", $profesor->getApellidos(), PDO::PARAM_STR);
                $sentencia->bindParam(":Email", $profesor->getEmail(), PDO::PARAM_STR);
                $sentencia->bindParam(":Contrasenia", $profesor->getContrasenia(), PDO::PARAM_STR);
                $sentencia->bindParam(":Nivel_Acceso", $profesor->getNivel_Acceso(), PDO::PARAM_INT);
                $sentencia->bindParam(":Tutor_Grupo", $profesor->getTutor_Grupo(), PDO::PARAM_INT);

                return $sentencia->execute();
            } catch (PDOException $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function activarProfesor($conexion, $cod_profesor) {
        if (isset($conexion)) {
            try {
                $sql = "UPDATE `Profesores` SET `Nivel_Acceso`= `Nivel_Acceso` * (-1) "
                        . "WHERE `DNI`= :DNI ";

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(":DNI", $cod_profesor, PDO::PARAM_STR);

                return $sentencia->execute();
            } catch (PDOException $ex) {
                echo "ERROR: " . $ex->getMessage();
            }
        }
    }

    public static function mensajeEdicionProfesor($comprobar, $texto) {
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

}
