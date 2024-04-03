<?php
date_default_timezone_set('Europe/Madrid');
session_start();
/**
 * Argumentos $_POST OBLIGATORIOS
 *      autor:  Integer     (userId)
 *      room: String
 *      date: String
 *      hora: String  
 *      comment: String
 */

if (isset($_SESSION['usuario_login'])){

    $inicio = isset($_POST['inicio']) ? $_POST['inicio'] : '';
    $fin = isset($_POST['fin']) ? $_POST['fin'] : '';
    $dias = isset($_POST['dias']) ? $_POST['dias'] : '';

    $autor = isset($_POST['autor']) ? $_POST['autor'] : '';
    $room = isset($_POST['room']) ? $_POST['room'] : '';
    $idate = isset($_POST['hora']) ? $_POST['hora'] : '';
    $fdate = '';
    $comment = isset($_POST['comment']) ? $_POST['comment'] : '';

    // Calcular hora de finalización
    if(!empty($idate))
        $fdate = date("H:i", strtotime( ($idate=='11:15') ? '+30 minutes' : '+55 minutes', strtotime($idate)));

    include_once(__DIR__.'/../model/Reservas.php');
    $reservaApi = new Reservas();

    if( $reservaApi -> checkEmpty(array($dias,$inicio,$fin,$autor,$room,$idate,$fdate)) ){
        echo json_encode(array("isok"=>false,"error"=>"¡Debes rellenar todos los campos!"));
    } else if ( $reservaApi -> invalidHours($idate, $fdate) ){
        echo json_encode(array("isok"=>false,"error"=>"Horas no compatibles"));
    } else if( $reservaApi -> invalidDates($inicio, $fin)){
        echo json_encode(array("isok"=>false,"error"=>"Fechas no compatibles"));
    } else {
        try{
            $reservaApi -> reservaPeriodica($dias,$inicio,$fin, $autor,$room,$idate,$fdate,$comment);
        } catch(Exception $e){
            echo json_encode(array("isok"=>false,"error"=>$e));
        } 
    }
} else {
    echo json_encode(array("isok"=>false,"error"=>"Permiso denegado"));
}