<?php
session_start();
/**
 * Argumentos $_POST aceptados.
 * OBLIGATORIO UNO, AL MENOS
 *      uid:  int
 *      email: String
 */
    include_once(__DIR__.'/../model/Reservas.php');

    if (isset($_SESSION['usuario_login'])){
        $rid = isset($_POST['rid']) ? $_POST['rid'] : '';

        $reservasApi = new Reservas();
        try{
            if(!empty($rid)) $reservasApi -> deleteById($rid);

        } catch(Exception $e){
            echo json_encode(array("isok"=>false,"error"=>$e));
        }
    } else{
        echo json_encode(array("isok"=>false,"error"=>"Permiso denegado"));
    }