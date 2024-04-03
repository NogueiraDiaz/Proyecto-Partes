<?php

include_once "app/RepositorioSesion.inc.php";
RepositorioSesion::borrarNombreProfesorSesion();
RepositorioSesion::borrarDatosSesion();

//if (session_id == "") {
 //   session_start();
//}

session_destroy();

header("Location: index.php");

