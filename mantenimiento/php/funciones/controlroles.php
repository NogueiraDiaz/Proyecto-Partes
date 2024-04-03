<?php
// Con esta funcion controlamos el rol para saber rol tiene al iniciar sesion
    function controlarrol($rango){
        error_reporting(E_ALL ^ E_NOTICE);
        if($rango != $_SESSION["usuario_login"]["rol"]){
            header("Location: ../../archivosComunes/selector.php");
        }
    }
