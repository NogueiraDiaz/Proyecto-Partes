<?php
//funcion que crea una carpeta con el nombre del alumno
    function creaCarpeta($carpeta, $nombre, $ciclo, $nombreAnexo){
        $ruta = "../../anexos/$carpeta/" . $nombre . $ciclo . "/";

        if($nombreAnexo == "anexo3")  $ruta .= "anexosIII/";

        if (!file_exists($ruta)) {
            /* si la función no puede crear la ruta, retorna false */
            if (mkdir($ruta, 0777, true)) return $ruta ;
            else return false;
        }
        else return $ruta;
    }


    // Función para almacenar un archivo dentro de la carpeta de usuario
    function subirAnexo($ruta, $nombre, $ciclo, $nombreAnexo, $archivoBorrar = null) {
        //primero crea una carpeta y retorno la ruta completa
        $rutaArchivo = creaCarpeta($ruta,$nombre, $ciclo, $nombreAnexo);
        
        if(!$rutaArchivo) return false; //Luego compruebo que ha creado la carpeta antes de hacer nada

        //aqui miro si hay un archivo que tengo que borrar, el cual le paso su nombre por parámetro
        if($archivoBorrar != null && $archivoBorrar != " ") unlink($rutaArchivo . $archivoBorrar);

        //al final recojo el nombre del archivo dentro de la variable que contiene la ruta de la carpeta y lo intento insertar dentro de la carpeta
        $rutaArchivo .= $_FILES[$nombreAnexo]["name"];
        if(move_uploaded_file($_FILES[$nombreAnexo]["tmp_name"], $rutaArchivo )) return $rutaArchivo;
        else return false;
    }

    function subirAnexo3($nombre, $ciclo, $name, $tmpName){

        $rutaArchivo = creaCarpeta("alumnos",$nombre, $ciclo, "anexo3");
        
        if(!$rutaArchivo) return false; //Luego compruebo que ha creado la carpeta antes de hacer nada
    
        //al final recojo el nombre del archivo dentro de la variable que contiene la ruta de la carpeta y lo intento insertar dentro de la carpeta
        $rutaArchivo .= $name;
        if(move_uploaded_file($tmpName, $rutaArchivo )) return $rutaArchivo;
        else return false;
    }



    //funcion para imprimir por pantalla los anexos 3 de cada alumno
    function sacarAnexos($db){
        $cod_empresa = $_GET["cod_empresa"];
        $cod_alumno = $_GET["cod_alumno"];
    
        try{
            $anexos = $db->query("SELECT anexo_iii FROM Anexoiii_pertenece WHERE cod_alumno ='$cod_alumno' AND cod_empresa = '$cod_empresa' ORDER BY cod_empresa ASC");
    
            $i = 1;
            $resultado = "<div class='row'>";
            //recorro los registros
            foreach($anexos as $anexo){
                $resultado .= "<div class='col-lg-4 col-md-6 col-sm-12'>
                        <label for='formGroupExampleInput' class='form-label datos'>Anexo_III - $i:</label>".
                        imprimeInputAnexo($anexo["anexo_iii"], "anexo3_$i") ."
                        <input type='file' class='form-control inputAnexos' name='anexo3_$i'>
                    </div>
                ";
                $i++;
            }
    
            //variable que utilizaré para poder recorrer todos los anexos a la hora de actualizar
            $_SESSION["n_Anexos3"] = $i-1;
    
            $resultado .= "</div>";
    
        }
        catch (PDOException $e) {//en caso de fallo devuelve el mensaje de error de BBDD
            return 'Error en la base de datos '.$e->getMessage();
        }
    
        return $resultado;
    
    }
    
    //metodo que genera una etiqueta para descargar el contenido de dicho anexo
    function imprimeInputAnexo($ruta, $n_anexo){
        //compruebo que la ruta no está vacia para retornar un link en vez de un input vacio
        if($ruta != " " || $ruta != null) return "
                    <input type='hidden' class='form-control' name='$n_anexo' value= '" . basename($ruta) . "'>
                    <a href='../Funciones/descargarAnexo.php?rutaAnexo=../paginas/$ruta' class='form-control deselected'>" . basename($ruta) . "<span class='texto-deselected'>Pulsa para descargar archivo</span></a>
                    ";
            
        else return " <input type='text' class='form-control inputAnexos' name='$n_anexo' value= '" . basename($ruta) . "' readonly>";
    }

?>