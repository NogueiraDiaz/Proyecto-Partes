<?php
session_start();
/**
 * Para obtener TODAS las reservas filtradas por fecha y usuario (disponibilidad)
 * Argumento $_GET obligatorio:
 *      usuario: String Nombre del usuario
 *      start: String Fecha de inicio
 *      end: String Fecha límite final
 */


$usuario = isset($_GET['usuario']) ? urldecode($_GET['usuario']) : '';
$start = isset($_GET['start']) ? urldecode($_GET['start']) : '';
$end = isset($_GET['end']) ? urldecode($_GET['end']) : '';


if (isset($_SESSION['usuario_login'])){
    include_once(__DIR__.'/../model/Reservas.php');
    $reservasApi = new Reservas();
    if($reservasApi -> checkEmpty(array($usuario,$start,$end)))
        echo json_encode(array());
    else
        $reservasApi -> getAsCalendarEventsUsuario($usuario,$start,$end);
} else {
    echo json_encode(array());
}
