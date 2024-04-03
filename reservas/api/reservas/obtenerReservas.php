<?php
session_start();
/**
 * Para obtener TODAS las reservas filtradas por fecha
 * Argumento $_POST obligatorio:
 *      fecha: String formato AAAA-mm-dd
 */


$fecha = isset($_POST['fecha']) ? $_POST['fecha'] : '';

if ($_SESSION['usuario_login']['rol'] == '0'){
    include_once(__DIR__.'/../model/Reservas.php');
    $reservasApi = new Reservas();
    if(empty($fecha))
        echo json_encode(array("isok"=>false,"error"=>"Debes introducir una fecha"));
    else
        $reservasApi -> getReservasByFecha($fecha);
} else {
    echo json_encode(array("isok"=>false,"error"=>"Permiso denegado"));
}
