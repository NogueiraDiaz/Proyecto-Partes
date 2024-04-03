<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Si se ha pulsado el botón de eliminar incidencia ...
    if (isset($_POST["eliminarInci"])) {
      // Capturamos el valor de $codTarea del campo oculto del formulario
      $codTarea = $_POST["codigoTarea"];
      // Borramos la tarea seleccionada
      require_once('../../archivosComunes/conexion.php');
      try {
        // Mostramos el cuadro de diálogo de confirmación antes de eliminar la incidencia
        echo "
          <script>
            var result = window.confirm('¿Seguro que quieres finalizar esta incidencia?');
            if (result) {
              // Si el usuario hace clic en 'Sí', se elimina la incidencia
              window.location = 'funciones/eliminar_incidencia.php?codTarea=$codTarea';
            } else {
              // Si el usuario hace clic en 'No', se redirige a la página admin.php sin eliminar la incidencia
              window.location = 'admin.php';
            }
          </script>";
        exit;
      } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
      }
    }
  }
?>

