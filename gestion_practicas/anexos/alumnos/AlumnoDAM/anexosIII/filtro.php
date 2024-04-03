<?php
function filtrarEmpresa($empresa){
    try {
        $db = require_once "conexion.php";

        $alumnosEmpresa = $db->query("SELECT * FROM alumno, empresa, pertenece WHERE alumno.COD_ALUMNO = pertenece.COD_ALUMNO AND empresa.COD_EMPRESA = pertenece.COD_EMPRESA AND COD_EMPRESA = '$empresa'"); 

        $resultados = "";
        if($alumnosEmpresa->rowCount() > 0){
            foreach($alumnosEmpresa as $alumnoEmpresa){
                $resultados .= 
                    "<tr>
                    <td> " .  $alumnoEmpresa["COD_ALUMNO"]  . "</td><br>" .
                    "<td>" .  $alumnoEmpresa["DNI_ALUMNO"] . "</td><br>" .
                    "<td>" .  $alumnoEmpresa["NOMBRE"] . "</td><br>" . 
                    "<td>" .  $alumnoEmpresa["APELLIDOS"] . "</td><br>" . 
                    "<td>" .  $alumnoEmpresa["GENERO"] . "</td><br>" . 
                    "<td>" .  $alumnoEmpresa["CORREO_ALUMNO"] . "</td><br>" . 
                    "<td>" .  $alumnoEmpresa["TELEFONO_ALUMNO"] . "</td><br>" . 
                    "<td>" .  $alumnoEmpresa["FECHA_NAC"] . "</td><br>" . 
                    "<td>" .  $alumnoEmpresa["LUGAR_NAC"] . "</td><br>" . 
                    "<td>" .  $alumnoEmpresa["LOCALIDAD_ALUMNO"] . "</td><br>" . 
                    "<td>" .  $alumnoEmpresa["PROVINCIA_ALUMNO"] . "</td><br>" . 
                    "<td>" .  $alumnoEmpresa["DOMICILIO_ALUMNO"] . "</td><br>" . 
                    "<td>" .  $alumnoEmpresa["CP_ALUMNO"] . "</td><br>" . 
                    "<td>" .  $alumnoEmpresa["CICLO"] . "</td><br>" .
                    "<td>" .  $alumnoEmpresa["ANIO"] . "</td><br>" . 
                    "</tr>" ;
            }
        }
        //sino lo hace muestro este mensaje por pantalla
        else{
            $resultados = "No se ha encontrado ningun usuario";
        }

        return $resultados;
    } catch (PDOException $e) {
        echo "Error con la base de datos: " . $e->getMessage();
    }
    }

    // Redireccionar a los alumnos:
    echo filtrarEmpresa($_POST["empresas"]);
?>