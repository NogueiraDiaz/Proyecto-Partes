<?php
session_start();
/**
 * Para obtener TODAS las reservas filtradas por fecha y aula (disponibilidad)
 * Argumento $_GET obligatorio:
 *      aula: String Nombre del aula
 *      start: String Fecha de inicio
 *      end: String Fecha límite final
 */


$aula = isset($_GET['aula']) ? urldecode($_GET['aula']) : '';
$start = isset($_GET['start']) ? urldecode($_GET['start']) : '';
$end = isset($_GET['end']) ? urldecode($_GET['end']) : '';


if (isset($_SESSION['usuario_login'])){
    include_once(__DIR__.'/../model/Reservas.php');
    $reservasApi = new Reservas();
    if($reservasApi -> checkEmpty(array($aula,$start,$end)))
        echo json_encode(array());
    else
        $reservasApi -> getAsCalendarEvents($aula,$start,$end);
} else {
    echo json_encode(array());
}
