
<?php
// Iniciamos la sesion
session_start();
require_once("../archivosComunes/conexion.php");
// Para acceder a esta pagina hay que iniciar sesion previamente.
require_once('../archivosComunes/loginRequerido.php');
  $stmt = $db->prepare("DELETE FROM Alumnos");
  header('Location: gestionarAlumnos.php');
  exit();
    
?>