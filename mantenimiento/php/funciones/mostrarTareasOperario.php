<?php
// Ficheros necesarios para acceder aqui. Login y conexion a la BBDD
require_once('../php/funciones/loginRequerido.php');
require_once('../../archivosComunes/conexion.php');
$contador = 0;
try {
  // Seleccionamos las tareas que sean de centro
  $incidencias = "SELECT * FROM Tareas where tipo_incidencia='centro' ORDER BY fecha_inicio ASC";
  $incidencias = $db->query($incidencias);
  echo ('<div id="tablaScript" class="tablaInci table-responsive-lg"> <table class="table table-striped table-hover text-center">');
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
      <td>Editar</td>
    </tr>
  </thead>");

  foreach ($incidencias as $row) {
    // Sacamos todos los elementos de la tabla Tareas
    $estadoTarea = $row["estado"];
    $codTarea = $row["cod_tarea"];
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
    $contador++;

  // Subconsulta para sacar el nombre del cod usuarui gestion de la tabla tareas.
  $subConsultaNombre = "SELECT nombre, apellidos FROM Usuarios WHERE cod_usuario = (SELECT cod_usuario_gestion FROM Tareas WHERE cod_tarea = '$codTarea')";
  $subConsultaNombre = $db->query($subConsultaNombre);
  $nombreAsignado = "";
  foreach($subConsultaNombre as $row2){
    $nombreAsignado = $row2["nombre"];
    $apellidoAsignado = $row2["apellidos"];

  }

  // Subconsulta para sacar el nombre del cod usuario que ha creado la tarea
  $subConsultaNombreCrea = "SELECT nombre, apellidos FROM Usuarios WHERE cod_usuario = (SELECT cod_usuario_crea FROM Tareas WHERE cod_tarea = '$codTarea')";
  $subConsultaNombreCrea = $db->query($subConsultaNombreCrea);
  foreach($subConsultaNombreCrea as $row2){
    $nombreCrea = $row2["nombre"];
    $apellidoCrea = $row2["apellidos"];

  }
   echo " <tbody>";
  //  Condicional para pintar las filas dependiendo del estado de la Tarea
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
      <img src=data:image/jpg;base64,<?php echo base64_encode($imagen)?> class="zoom"  style="width: 50px;"/>
    <?php
    echo "</td>
      <td class='comentario'>$descripcion</td>
      <td class='comentario'>$comentario</td>
      <td>$nombreCrea $apellidoCrea</td>
      <td>$nombreAsignado $apellidoAsignado</td>
      <td>$tipo_inci</td>";
      if($estadoTarea === "Realizada"){
        echo " 
           <form method='post' action='editarIncidencia.php'>
            <input type='hidden' name='codigoTarea' value='$codTarea'>
            <td><button class='btn disabled' name='asignarInci'><span class='material-symbols-outlined'>edit_note</span></button></td>
          </form>
        </tr>
      </tbody>";
      }else{
        echo " 
           <form method='post' action='editarIncidencia.php'>
            <input type='hidden' name='codigoTarea' value='$codTarea'>
            <td><button class='btn' name='asignarInci'><span class='material-symbols-outlined'>edit_note</span></button></td>
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



