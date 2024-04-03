
<?php
// Iniciamos la sesion
session_start();
require_once("../archivosComunes/conexion.php");
// Para acceder a esta pagina hay que iniciar sesion previamente.
require_once('../archivosComunes/loginRequerido.php');
if (isset($_GET['cod_guardias'])) {
  $id = $_GET['cod_guardias'];
  $stmt = $db->prepare("DELETE FROM Guardias WHERE cod_guardias = ?");
  $stmt->execute([$id]);
  header('Location: guardias.php');
  exit();
    }
?>