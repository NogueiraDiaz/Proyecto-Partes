<?php
session_start();

if ($_SESSION['usuario_login']['rol'] == '0'){
    include_once(__DIR__.'/../model/Reservas.php');
    $reservasApi = new Reservas();
    if(($r = $reservasApi -> backup()) === true)
        echo json_encode(array("isok"=>true,"data"=>"Correcto"));
    else
        echo json_encode(array("isok"=>false,"error"=>"Error al crear volcado."));

} else {
    echo json_encode(array("isok"=>false,"error"=>"Permiso denegado"));
}
