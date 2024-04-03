<?php
    function creaCarpeta($nombre_alumno, $ciclo, $nombreAnexo){
        $ruta = "archivos/alumnos/" . $nombre_alumno . $ciclo . "/";

        // Mover el archivo a la carpeta recién creada
        $tmp_name = $_FILES[$nombreAnexo]["tmp_name"];
        $archivo = $_FILES[$nombreAnexo]["name"];

        if (!file_exists($ruta)) {
            /* si la función no puede crear la ruta, retorna false */
            if (mkdir($ruta, 0777, true)) {
                return $ruta . $archivo;
            }
            else{
                return false;
            }
        }
        else{
            return $ruta . $archivo;
        }
    } 


    // Función, para guardar la ruta :)
    function obtenerRutaArchivo($nombre_alumno, $ciclo, $nombreAnexo) {
        $tmp_name = $_FILES[$nombreAnexo]["tmp_name"];
        $rutaArchivo = creaCarpeta($nombre_alumno, $ciclo, $nombreAnexo);
        if(!$rutaArchivo) return false; //concicional que se asegura que se ha creado la carpeta antes de hacer nada


        if(move_uploaded_file($tmp_name, $rutaArchivo)) return $rutaArchivo;
        else return false;
    }
?>