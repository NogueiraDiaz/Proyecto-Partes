<?php
session_start();
/**
 * Argumentos $_POST OBLIGATORIOS
 *      autor:  String|Integer     (userId)
 *      room: String
 *      date: String
 *      hora: String
 *      fdate: String   
 *      comment: String
 */

if (isset($_SESSION['usuario_login'])){
    $autor = isset($_POST['autor']) ? $_POST['autor'] : '';
    $room = isset($_POST['room']) ? $_POST['room'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    $idate = isset($_POST['hora']) ? $_POST['hora'] : '';
    $fdate = '';
    $comment = isset($_POST['comment']) ? $_POST['comment'] : '';

    // Calcular hora de finalización
    if(!empty($idate))
        $fdate = date("H:i", strtotime( ($idate=='11:15') ? '+30 minutes' : '+55 minutes', strtotime($idate)));

    include_once(__DIR__.'/../model/Reservas.php');
    $reservaApi = new Reservas();
    if( $reservaApi -> checkEmpty(array($autor,$room,$date,$idate,$fdate)) ){
        echo json_encode(array("isok"=>false,"error"=>"¡Debes rellenar todos los campos!"));
    } else if ( $reservaApi -> invalidHours($idate, $fdate) ){
        echo json_encode(array("isok"=>false,"error"=>"Horas no compatibles"));
    } else if( $reservaApi -> invalidDates($date)){
        echo json_encode(array("isok"=>false,"error"=>"Fecha no compatible"));
    } else {
        try{
            //echo json_encode(array("isok"=>true,"data"=>"DEBUG"));
            $reservaApi -> setReserva($autor,$room,$date,$idate,$fdate,$comment);
        } catch(Exception $e){
            echo json_encode(array("isok"=>false,"error"=>$e));
        } 
    }
} else {
    echo json_encode(array("isok"=>false,"error"=>"Permiso denegado"));
}