<?php
    if(isset($_SESSION["usuario_login"])){
        header ("Location: ./archivosComunes/selector.php");
    }
?>