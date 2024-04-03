<?php
session_start();
/**
 * Para obtener TODAS las reservas filtradas por fecha y aula (disponibilidad)
 * Argumento $_POST obligatorio:
 *      fecha: String formato AAAA-mm-dd
 *      aula: String Nombre del aula
 */


$fecha = isset($_POST['fecha']) ? $_POST['fecha'] : '';
$aula = isset($_POST['aula']) ? $_POST['aula'] : '';
$hora = isset($_POST['hora']) ? $_POST['hora'] : '';

if (isset($_SESSION['usuario_login'])){
    include_once(__DIR__.'/../model/Reservas.php');
    $reservasApi = new Reservas();
    if(empty($aula) && !empty($fecha)){
        if($reservasApi -> checkEmpty(array($fecha, $hora)))
            echo json_encode(array("isok"=>false,"error"=>"Debes introducir, <strong>como mínimo</strong>, una fecha y una hora"));
        else 
            $reservasApi -> getReservasByFechaHora($fecha,$hora);
    }
    else if($reservasApi -> checkEmpty(array($fecha, $aula)))
        echo json_encode(array("isok"=>false,"error"=>"Debes introducir, <strong>como mínimo</strong>, una fecha y un aula"));
    else
        $reservasApi -> getReservasByFechaAula($fecha,$aula);
} else {
    echo json_encode(array("isok"=>false,"error"=>"Permiso denegado"));
}

