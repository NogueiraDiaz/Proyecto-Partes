<?php

include_once 'app/RepositorioSesion.inc.php';
RepositorioSesion::iniciarSesion();

include_once "app/Conexion.inc.php";
include_once "app/RepositorioProfesor.inc.php";

Conexion::abrirConexion();
$_SESSION["activado_ok"] = 0;
if (RepositorioProfesor::activarProfesor(Conexion::getConexion(), $_SESSION["cod_profesor"])) {
    $_SESSION["activado_ok"] = 1;
    header('Location: gestion_profesores.php');
}
Conexion::cerrarConexion();




