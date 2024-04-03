<?php
    session_start();
    include_once(__DIR__.'/../model/Reservas.php');

    $rid = isset($_POST['rid']) ? $_POST['rid'] : '';

    $reservasApi = new Reservas();
    try{
        $data = $reservasApi -> getByAutor($_SESSION['usuario_login']['cod_usuario']);
        echo json_encode($data);
    } catch(Exception $e){
        echo [];
    }


