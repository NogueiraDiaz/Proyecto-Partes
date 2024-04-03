<?php
    // Si no se ha hecho login redirigimos al login para que se haga login antes
    session_start();
    if(!isset($_SESSION["usuario_login"])){
        header("Location: ../../index.php?redirigido=true");
    };
    require_once('../../archivosComunes/conexion.php');

    // Guardamos el codigo del departamento que esta seleccionado
    $filtro_departamento = $_POST['filtro_departamento'];
    echo $_POST['filtro'];
    // Si el usuario es administrador podra filtrar por departamento y por fungibles, no fungible etc
    if($_SESSION['usuario_login']['rol'] == 0){
        // Si selecciona todos los articulos y el departamento es cero
        // se redirige a la lista para mostrar todos los articulos de todos los departamentos
        if($_POST['filtro'] == "todos" && $filtro_departamento == "0"){
            header("Location: lista.php?filtro=todos");
        // Si selecciona todos los articulos y el departamento es distinto de cero, es decir, se ha seleccionado algun departamento
        // se redirige a la lista para mostrar todos los articulos del departamento especifico
        } else if($_POST['filtro'] == "todos" && $filtro_departamento != "0"){
            header("Location: lista.php?filtro=todos&codigo=".$filtro_departamento);
        // Si selecciona los articulos fungibles y el departamento es cero
        // se redirige a la lista para mostrar todos los articulos fungibles de todos los departamentos
        } else if($_POST['filtro'] == "fungibles" && $filtro_departamento == "0"){
            header("Location: lista.php?filtro=fungibles");
        // Si selecciona los articulos fungibles y el departamento es distinto de cero
        // se redirige a la lista para mostrar todos los articulos fungibles del departamento especificado
        } else if($_POST['filtro'] == "fungibles" && $filtro_departamento != "0"){
            header("Location: lista.php?filtro=fungibles&codigo=".$filtro_departamento);
        // Si selecciona los articulos fungibles a pedir y el departamento es cero
        // se redirige a la lista para mostrar todos los articulos fungibles a pedir de todos los departamentos
        } else if($_POST['filtro'] == "fungiblespedir" && $filtro_departamento == "0"){
            header("Location: lista.php?filtro=fungiblespedir");
        // Si selecciona los articulos fungibles a pedir y el departamento es distinto de cero
        // se redirige a la lista para mostrar todos los articulos fungibles a pedir del departamento especificado
        } else if($_POST['filtro'] == "fungiblespedir" && $filtro_departamento != "0"){
            header("Location: lista.php?filtro=fungiblespedir&codigo=".$filtro_departamento);
        // Si selecciona los articulos no fungibles y el departamento es cero
        // se redirige a la lista para mostrar todos los articulos no fungibles de todos los departamentos
        } else if($_POST['filtro'] == "nofungibles" && $filtro_departamento == "0"){
            header("Location: lista.php?filtro=nofungibles");
        // Si selecciona los articulos no fungibles y el departamento es distinto de cero
        // se redirige a la lista para mostrar todos los articulos no fungibles del departamento especificado
        } else if($_POST['filtro'] == "nofungibles" && $filtro_departamento != "0"){
            header("Location: lista.php?filtro=nofungibles&codigo=".$filtro_departamento);
        } 
    
    // Si el usuario es un profesor
    } else if ($_SESSION['usuario_login']['rol'] == 1) {
        // Si se selecciona todos se redirige a lista para mostrar todos los articulos de su departamento
        if($_POST['filtro'] == "todos"){
            header("Location: lista.php?filtro=todos");
        // Si se selecciona fungibles se redirige a lista para mostrar todos los articulos fungibles de su departamento
        } else if($_POST['filtro'] == "fungibles" ){
            header("Location: lista.php?filtro=fungibles");
        // Si se selecciona fungibles a pedir se redirige a lista para mostrar todos los articulos fungibles a pedir de su departamento
        } else if($_POST['filtro'] == "fungiblespedir"){
            header("Location: lista.php?filtro=fungiblespedir");
        // Si se selecciona no fungibles se redirige a lista para mostrar todos los articulos no fungibles de su departamento
        } else if($_POST['filtro'] == "nofungibles" ){
            header("Location: lista.php?filtro=nofungibles");
        } 
    }
    
?>