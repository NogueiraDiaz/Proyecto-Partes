<?php

function asignarCicloAnio(){
    //primero miro si la variable está inicializado
    //sino lo está compruebo el campo $_POST[CICLO] y si tiene valor se lo asigno
    if(!isset($_SESSION["ciclo"])) $_SESSION["ciclo"] = isset($_POST["ciclo"]) && $_POST["ciclo"]!= "todos" ? $_POST["ciclo"] : "";
    //aqui hago algo parecido pero sino tiene valor le asigno el valor que ya tenia
    else $_SESSION["ciclo"] = isset($_POST["ciclo"]) && $_POST["ciclo"]!= "todos"? $_POST["ciclo"] : $_SESSION["ciclo"];

    //esto es lo mismo pero con la otra variable
    if(!isset($_SESSION["anio"])) $_SESSION["anio"] = isset($_POST["anio"]) && $_POST["anio"]!= "todos" ? $_POST["anio"] : "";
    else $_SESSION["anio"] = isset($_POST["anio"]) && $_POST["anio"]!= "todos" ? $_POST["anio"] : $_SESSION["anio"];
}


//funcion para retornar los diferentes ciclos/años dentro de la base de datos a un desplegable, tambien comprueba si está activo alguno de los dos filtros: $_SESSION["CICLO"]/$_SESSION["ANIO"];
function obtenerCiclosAnios($db, $filtro){
    //dependiendo del filtro retorna una cosa u otra
    try{
        $valorInicial = $filtro == "anio" ? "año" : "ciclo";
        echo '<option value="todos">'. $valorInicial .'</option>';
        // Consulta para obtener las categorías de productos
        $result = $db->query("SELECT DISTINCT $filtro FROM Alumnos ORDER BY $filtro DESC");
        // Iterar a través de los resultados de la consulta y agregarlos como opciones en el select
        foreach ($result as $row) {
            if(isset($_SESSION[$filtro]) && $_SESSION[$filtro] == $row[$filtro]) echo '<option value="'.$row[$filtro].'" selected>'.$row[$filtro].'</option>';  //si la opcion coincide con el filtro activo la marco para que se muestre por defecto
            else echo '<option value="'.$row[$filtro].'">'.$row[$filtro].'</option>';
        }
    }
    catch (PDOException $e) {//en caso de fallo devuelve el mensaje de error de BBDD
        return "Error en la base de datos ".$e->getMessage();
    }
}


//funcion que quita los filtros Ciclo y Año
function resetFiltros(){
    unset($_SESSION["ciclo"]);
    unset($_SESSION["anio"]);
}


/*  Adrian Navarro Vivar
    Metodo que retorna parte de una consulta según sus parametros, si no tiene no retorna nada
*/
function consultaCicloAnio($ciclo = "", $anio = ""){
    $sql = '';

    if($ciclo != ""){
        if($anio != "")$sql = " ciclo = '$ciclo' AND anio = '$anio'";
        else $sql = " ciclo = '$ciclo'";
    }
    elseif($anio != "") $sql = " anio = '$anio'";

    return $sql;
}



?>