<?php
// Verificar si se ha proporcionado el parámetro codTarea en la URL
if (isset($_GET["codTarea"])) {
  $codTarea = $_GET["codTarea"];

  // Realizar la eliminación de la incidencia
  require_once('../../../archivosComunes/conexion.php');
  try {
    $insertarIncidencia = "INSERT INTO TareasFinalizadas SELECT * FROM Tareas WHERE cod_tarea = ?";
    $preparada = $db->prepare($insertarIncidencia);
    $preparada->execute(array($codTarea));

    $deleteIncidencia = "DELETE FROM Tareas WHERE cod_tarea = ?";
    $preparada = $db->prepare($deleteIncidencia);
    $preparada->execute(array($codTarea));

    // Redirigir a la página admin.php después de la eliminación exitosa
    header("Location: ../admin.php");
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


