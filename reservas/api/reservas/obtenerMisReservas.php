<?php
session_start();
/**
 * Para obtener TODAS las reservas filtradas por autor
 */

if (isset($_SESSION['usuario_login'])){

    $uid = isset($_SESSION['usuario_login']) ? $_SESSION['usuario_login'] : '';
    include_once(__DIR__.'/../model/Reservas.php');
    $reservasApi = new Reservas();

    if(empty($uid))
        echo json_encode(array("isok"=>false,"error"=>"ID de usuario obligatorio"));
    else
        $reservasApi -> getReservasByAutor($uid);
} else {
    echo json_encode(array("isok"=>false,"error"=>"Permiso denegado"));
}
