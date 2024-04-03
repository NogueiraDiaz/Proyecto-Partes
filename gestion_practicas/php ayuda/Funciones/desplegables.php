<?php
    // Realizo la conexión a la base de datos:
    require_once("../../../archivosComunes/conexion.php");

    // Función para mostrar las empresas que hay a través de un desplegable:
    function desplegableEmpresas($db, $opcion = " "){
        try{
            // Realizamos la consulta para acceder a los datos de las empresas:
            $empresas = $db->query("SELECT DISTINCT * FROM Empresas");

            // Añado a una variable los datos a mostrar a partir de un foreach,
            // que añadirá opciones al select si encuentra valores en la base de datos:
            $resultados = "<select class=form-select name=empresas>";
            if($empresas->rowCount() > 0){
                if($opcion = " "){
                    foreach($empresas as $empresa){
                        $resultados .= "
                        <option value=".$empresa["cod_empresa"].">".$empresa["nombre_empresa"]."</option>
                        "; 
                    }
                }
                else{
                    foreach($empresas as $empresa){
                        if($opcion = $empresa["cod_empresa"]){
                            $resultados .= "<option value=".$empresa["cod_empresa"]." selected>".$empresa["nombre_empresa"]."</option>";
                        }
                        else{
                            $resultados .= "<option value=".$empresa["cod_empresa"]." >".$empresa["nombre_empresa"]."</option>";
                        }
                    }
                }
            }
            // Mostramos un mensaje en caso de que no se encuentre nada:
            else{
                $resultados = "No se ha encontrado ningún alumno que esté en esa empresa";
            }

            // Añadimos a la varialbe la etiqueta de cierre una vez se han añadido las opciones
            // y retornamos el resultado:
            $resultados .= "</select>";
            return $resultados;
        }
        // En caso de fallo devuelve el mensaje de error de BBDD:
        catch (PDOException $e) {
            return "Error en la base de datos ".$e->getMessage();
        }
    }


    //funcion que devuelve un desplegable con las empresas que coincidan con el ciclo que le pase por parametro
    function obtenerEmpresaCiclo($db, $ciclo, $codEmpresa = ""){

        try{
            //primero tengo que hacer una consulta para sacar una lista de todos los códigos de empresa que coincidan con el 
            $consultaCiclos = $db->query("SELECT * FROM Ciclo_empresas WHERE ciclo = '$ciclo'");

            if($consultaCiclos->rowCount() > 0){
                //Almaceno los ids
                $listaIds = ""; //string que le paso a la consulta
                $i = 1;         //variable de control
                foreach($consultaCiclos as $row){
                    $listaIds .= "'".$row["cod_empresa"]."'";
                    if($consultaCiclos->rowCount() != $i) $listaIds .= ' OR COD_EMPRESA = ';    //compruebo si es el ultimo dato para no escribir el or
                    $i++;
                }

                // Consulta para obtener las categorías de productos
                $empresas = $db->query("SELECT DISTINCT cod_empresa, nombre_empresa FROM Empresas WHERE cod_empresa = $listaIds");   

                //miro si hay resultados para mostrar una cosa u otra
                if($empresas->rowCount() > 0){
                    $resultado = '<select name="empresas" class="form-select">';
                    // Iterar a través de los resultados de la consulta y agregarlos como opciones en el select
                    foreach ($empresas as $row){                                    //aqui añado un condicional que pone por defecto la empresa seleccionada
                        $selected = $codEmpresa == $row["cod_empresa"] ? "selected" : "";
                        $resultado .= "<option value='".$row["cod_empresa"] ."' $selected >".$row["nombre_empresa"] . "</option>";
                    }
                    $resultado .= '</select>';
                }
                else $resultado = "<input value='No hay empresa disponible' class='form-control' readonly></input>";
                
            }
            else $resultado = "<input value='No hay empresa disponible' class='form-control' readonly></input>";  

            return $resultado;

        }
        catch (PDOException $e) {//en caso de fallo devuelve el mensaje de error de BBDD
            return "Error en la base de datos ".$e->getMessage();
        }
    }


?>

