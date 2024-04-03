<?php
//Iniciamos la sesión:
session_start();

/*Para crear la sesión es necesario borrar todas las variables de la sesión, para ello se
inicializa el array $_SESSION */
$_SESSION = array();

/*Además, se debe utilizar la funcion session_destroy()*/
session_destroy();

/*Por ultimo, se debe eliminar la cookie*/
setcookie(session_name(),123,time()-1000);

/*Finalmente el script lleva de nuevo al login:*/
header("Location: ../index.php");
?>  