
<?php
// Iniciamos la sesion
session_start();
require_once("../archivosComunes/conexion.php");
// Para acceder a esta pagina hay que iniciar sesion previamente.
require_once('../archivosComunes/loginRequerido.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $db->prepare("DELETE FROM Horarios");
  $stmt->execute();
  header('Location: guardias.php');
  exit();
    }
?>