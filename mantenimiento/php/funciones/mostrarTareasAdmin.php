<?php
// Ficheros necesarios para acceder . Login y la conexion a la BBDD
require_once('../php/funciones/loginRequerido.php');
require_once('../../archivosComunes/conexion.php');
$contador = 0;
try {
  $incidencias = "SELECT * FROM Tareas ORDER BY fecha_inicio DESC";
  $incidencias = $db->query($incidencias);
  echo ('<div class="tablaInci table-responsive-lg"> <table id="tablaScript" class="table table-striped table-hover text-center">');
  echo ("<thead>
     <tr> 
       <th scope='col'>#</th>
       <td>Estado Tarea</td>
       <td>Nivel Tarea</td>
       <td>Localización</td>
       <td>Fecha Inicio</td>
       <td>Fecha Fin</td>
       <td>Imagen</td>
       <td>Descripción</td>
       <td>Comentario</td>
       <td>Tarea creada por</td>
       <td>Tarea asignada a</td>
       <td>Tipo</td>
       <td>Asignar</td>
        <td>Finalizar</td>
      </tr>
      </thead>");

  echo " <tbody>";

  foreach ($incidencias as $row) {
    // Sacamos todos los elementos de la tabla Tareas
    $codTarea = $row["cod_tarea"];
    $estadoTarea = $row["estado"];
    $nivel_tarea = $row["nivel_tarea"];
    $descripcion = $row["descripcion"];
    $comentario = $row["comentario"];
    $imagen = $row["imagen"];
    $localizacion = $row["localizacion"];
    $fecha_inicio  = $row["fecha_inicio"];
    $fecha_fin = $row["fecha_fin"];
    $cod_usuario_gestion = $row["cod_usuario_gestion"];
    $cod_usuario_crea = $row["cod_usuario_crea"];
    $tipo_inci = $row["tipo_incidencia"];
    $nombreAsignado = "";
    $apellidoAsignado = "";

    $contador++;
    $nombreAsignadoCreador = "";
    $apellidoAsignadoCreador = "";
    // Subconsulta para sacar el nombre del cod usuarui gestion de la tabla tareas.
    $subConsultaNombre = "SELECT nombre, apellidos FROM Usuarios WHERE cod_usuario = (SELECT cod_usuario_gestion FROM Tareas WHERE cod_tarea = '$codTarea')";
    $subConsultaNombre = $db->query($subConsultaNombre);

    foreach ($subConsultaNombre as $row2) {
      $nombreAsignado = $row2["nombre"];
      $apellidoAsignado = $row2["apellidos"];

    }
      // Subconsulta para sacar el nombre del cod usuarui gestion de la tabla tareas.
      $subConsultaNombreCreador = "SELECT nombre, apellidos FROM Usuarios WHERE cod_usuario = (SELECT cod_usuario_crea FROM Tareas WHERE cod_tarea = '$codTarea')";
      $subConsultaNombreCreador = $db->query($subConsultaNombreCreador);
  
      foreach ($subConsultaNombreCreador as $row3) {
        $nombreAsignadoCreador = $row3["nombre"];
        $apellidoAsignadoCreador = $row3["apellidos"];

      }
    // Condicionales para saber el estado de la tarea, dependiendo de que estado tenga, se pintará de un color.
    if($estadoTarea === "Realizada"){
      echo "<tr class='table-success fila-tabla' data-fila='$contador'>";
    }else if ($estadoTarea === "En Proceso") {
      echo "<tr class='table-warning fila-tabla' data-fila='$contador'>";
    } else if($estadoTarea === "Asignada") {
        echo "<tr class='table-primary fila-tabla' data-fila='$contador'>";
    }else if($estadoTarea === "Rechazada"){
      echo "<tr class='table-danger fila-tabla' data-fila='$contador'>";
    } else{
        echo "<tr class='fila-tabla' data-fila='$contador'>";
    }
    echo "<th scope='row'>$contador</th>
      <td>$estadoTarea</td>
      <td>$nivel_tarea</td>
      <td style='width: 120px;'>$localizacion</td>
      <td style='width: 120px;'>$fecha_inicio</td>
      <td style='width: 120px;'>$fecha_fin</td>
      <td>";
?>
    <img src=data:image/jpg;base64,<?php echo base64_encode($imagen) ?> class="zoom" style="width: 50px;" />
<?php
    echo "</td>
    <td class='comentario'>$descripcion</td>
     <td class='comentario'>$comentario</td>
     <td>$nombreAsignadoCreador $apellidoAsignadoCreador</td>
      <td>$nombreAsignado $apellidoAsignado</td>
      <td id='tipo_incidencia'>$tipo_inci</td>";
      
      if($estadoTarea === "Realizada"){
        echo "
          <form method='POST' action='asignarInciAdmin.php' >
            <input type='hidden' name='codigoTarea' value='$codTarea'>
            <td><button class='btn disabled' name='asignarInci'><span class='material-symbols-outlined'>assignment_add</span></button></td>
          </form>";

        echo "<form method='POST' >
            <input type='hidden' name='codigoTarea' value='$codTarea'>
            <td><button class='btn'  name='eliminarInci'><span class='material-symbols-outlined'>check_small</span></button></td>
            </form>
          </tr>
          </tbody>";
      }else {
        echo "
          <form method='POST' action='asignarInciAdmin.php' >
            <input type='hidden' name='codigoTarea' value='$codTarea'>
            <td><button class='btn' name='asignarInci'><span class='material-symbols-outlined'>assignment_add</span></button></td>
          </form>";

        echo "<form method='POST' >
            <input type='hidden' name='codigoTarea' value='$codTarea'>
            <td><button class='btn'  name='eliminarInci'><span class='material-symbols-outlined'>check_small</span></button></td>
            </form>
          </tr>
          </tbody>";
      } 

      

  }
  echo "</table></div>";
} catch (PDOException $e) {
  echo 'Error con la base de datos ' . $e->getMessage();
}

?>