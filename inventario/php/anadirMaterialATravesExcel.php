<?php
require_once "interpretarExcel.php";
if(!isset($_SESSION["usuario_login"])){
    header("Location: ../../index.php?redirigido=true");
};

//Comprobamos que nos haya llegado el fichero para añadirlo a la base de datos.
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST["btn-cargar"]) && isset($_FILES["fichero"]) && !empty($_FILES['fichero']['tmp_name'])) {
        $excelFile = $_FILES["fichero"]["tmp_name"];
        header("Location: lista.php");
        if (!validarExcel($excelFile)) {
            echo 'error';
        } else {
            interpretarExcel($excelFile);            
            exit();
        }
       //Si la operación no es exitosa,no redirigimos a la lista con todo el contenido.s 
    } else {
        header("Location: cargarExcel.php");
    }
    
}
?>