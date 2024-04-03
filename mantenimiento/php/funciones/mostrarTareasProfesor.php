<?php
// Ficheros necesarios para acceder. Login y conexion a BBDD
require_once('../php/funciones/loginRequerido.php');
require_once('../../archivosComunes/conexion.php');
$contador = 0;
try {
  $dep_usu = $_SESSION["usuario_login"]["departamento"]; //Cogemos el departamento del usuario
  $nomb_usu = $_SESSION["usuario_login"]["cod_usuario"]; //Cogemos el cod_usu del usuario
  // Consulta para sacar todos los usuuarios cuyo departamento sea = 1
  $consulta_dep = "SELECT cod_usuario, nombre FROM Usuarios WHERE departamento = (SELECT codigo FROM Departamentos WHERE referencia = 'inf')";
  $consulta_dep = $db->prepare($consulta_dep);
  $consulta_dep->execute();

  if ($consulta_dep->rowCount() > 0) {
    $incidencias = "SELECT * FROM Tareas where tipo_incidencia='informatica' AND cod_usuario_gestion = '$nomb_usu' ORDER BY fecha_inicio ASC";
    $incidencias = $db->query($incidencias);
    if ($consulta_dep = "informatica") {
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
      $cod_Tarea = $row["cod_tarea"];
      $nivel_tarea = $row["nivel_tarea"];
      $comentario = $row["comentario"];
      $descripcion = $row["descripcion"];
      $imagen = $row["imagen"];
      $localizacion = $row["localizacion"];
      $fecha_inicio  = $row["fecha_inicio"];
      $fecha_fin = $row["fecha_fin"];
      $cod_usuario_gestion = $row["cod_usuario_gestion"];
      $cod_usuario_crea = $row["cod_usuario_crea"];
      $tipo_inci = $row["tipo_incidencia"];
      $contador++;
      // Subconsulta para sacar el nombre del cod usuarui gestion de la tabla tareas.
      $subConsultaNombre = "SELECT nombre, apellidos FROM Usuarios WHERE cod_usuario = (SELECT cod_usuario_gestion FROM Tareas WHERE cod_tarea = '$cod_Tarea')";
      $subConsultaNombre = $db->query($subConsultaNombre);
      foreach ($subConsultaNombre as $row2) {
        $nombreAsignado = $row2["nombre"];
        $apellidoAsignado = $row2["apellidos"];

      }
      // Subconsulta para sacar el nombre del cod usuario que ha creado la tarea
      $subConsultaNombreCrea = "SELECT nombre, apellidos FROM Usuarios WHERE cod_usuario = (SELECT cod_usuario_crea FROM Tareas WHERE cod_tarea = '$cod_Tarea')";
      $subConsultaNombreCrea = $db->query($subConsultaNombreCrea);
      foreach ($subConsultaNombreCrea as $row2) {
        $nombreCrea = $row2["nombre"];
        $apellidoCrea = $row2["apellidos"];

      }
      echo " <tbody>";
      // Condicional para pintar las segun el estado de la tarea
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
        <img src=data:image/jpg;base64,<?php echo base64_encode($imagen) ?> class="zoom" style="width:50px; " />
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
         <input type='hidden' name='codigoTarea' value='$cod_Tarea'>
         <td><button class='btn disabled' name='asignarInci'><span class='material-symbols-outlined'>edit_note</span></button></td>
       </form>
     </tr>
   </tbody>";
      }else{
        $nombre=$_SESSION["usuario_login"]["nombre"];
        $apellidos=$_SESSION["usuario_login"]["apellidos"];
        $email=$_SESSION["usuario_login"]["email"];

        echo " 
        <form method='post' action='editarIncidencia.php'>
         <input type='hidden' name='codigoTarea' value='$cod_Tarea'>
         <input type='hidden' name='nombre' value='$nombre'>
         <input type='hidden' name='apellidos' value='$apellidos' />
         <input type='hidden' name='email' value='$email' />

         <td><button class='btn' name='asignarInci'><span class='material-symbols-outlined'>edit_note</span></button></td>
       </form>
     </tr>
   </tbody>";
      }
    }
      echo "</table></div>";
    }
  } 
} catch (PDOException $e) {
  echo 'Error con la base de datos ' . $e->getMessage();
}
?>




