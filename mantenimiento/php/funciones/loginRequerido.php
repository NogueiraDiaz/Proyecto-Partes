<?php
// Condicional en el que obliga al usuario a iniciar sesion para entrar a otros ficheros.
    if(!isset($_SESSION["usuario_login"]["email"])){
        header("Location: ../../index.php?redirigido=true");
    }
