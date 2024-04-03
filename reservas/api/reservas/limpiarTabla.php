<?php
session_start();

if ($_SESSION['usuario_login']['rol'] == '0'){
    include_once(__DIR__.'/../model/Reservas.php');
    $reservasApi = new Reservas();
    $reservasApi -> cleanReservas(true);

} else {
    echo json_encode(array("isok"=>false,"error"=>"Permiso denegado"));
}


