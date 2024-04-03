<?php
  // Conectamos con la Base de Datos
  require_once('../../archivosComunes/conexion.php');
    // Mostramos el mensaje de Bienvenida con el nombre de usuario
    echo "Bienvenido " . $_SESSION["usuario_login"]["nombre"];
