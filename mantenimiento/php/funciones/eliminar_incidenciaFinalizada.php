<?php
// Verificar si se ha proporcionado el parámetro codTarea en la URL
if (isset($_GET["codTarea"])) {
  $codTarea = $_GET["codTarea"];

  // Realizar la eliminación de la incidencia
  require_once('../../../archivosComunes/conexion.php');
  try {
    $deleteIncidencia = "DELETE FROM TareasFinalizadas WHERE cod_tarea = ?";
    $preparada = $db->prepare($deleteIncidencia);
    $preparada->execute(array($codTarea));

    // Redirigir a la página admin.php después de la eliminación exitosa
    header("Location: ../adminFinalizadas.php");
    exit;
  } catch (Exception $e) {
    echo "Error: " . $e->getMessage();
  }
} else {
  // Si no se proporcionó el parámetro codTarea, redirigir a la página admin.php sin realizar ninguna acción
  header("Location: ../admin.php");
  exit;
}
?>


