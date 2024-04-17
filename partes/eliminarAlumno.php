
<?php
// Iniciamos la sesion
session_start();
require_once("../archivosComunes/conexion.php");
// Para acceder a esta pagina hay que iniciar sesion previamente.
require_once('../archivosComunes/loginRequerido.php');
if (isset($_GET['matricula'])) {
  $id = $_GET['matricula'];
  $stmt = $db->prepare("DELETE FROM Alumnos WHERE matricula = ?");
  $stmt->execute([$id]);
  header('Location: gestionarAlumnos.php');
  exit();
    }
?>