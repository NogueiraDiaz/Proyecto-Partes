<?php
error_reporting(E_ALL ^ E_WARNING);
// Iniciamos la sesion
session_start();
// Para acceder a esta pagina hay que iniciar sesion previamente.
require_once('../php/funciones/loginRequerido.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
  <title>Administrador</title>
  <style>
    #selectProfesor{
      display: none;
    }
  </style>
</head>

<body>
  <?php
  // Funcion Header
    require_once("funciones/header.php")
  ?>

  <section>
    <article>
      <div class="container px-4 py-5" id="asignarInci">
        <h2 class="pb-2 border-bottom titletable">Asignar Incidencia</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <div class="row">
            <div class="col-md-6 p-3 ">
              <label for="tipoIncidencia" class="form-label">Tipo de Incidencia</label>
              <br>
              <input type="radio" id="InformáticaRadio" name="tipo_Incidencia" value="informatica" class="mb-3">Incidencia Informática<br>
              <input type="radio" id="CentroRadio" name="tipo_Incidencia" value="centro">Incidencia Centro<br>
              <input type="hidden" name="asignada" value="Asignada">
            </div>

            <div id="selectProfesor">
                <select name="asignarUsuario" id="selectusuario" class="form-control">
                <option name=""> - Seleccione usuario - </option>
              <?php
                require_once('../../archivosComunes/conexion.php');
                // Sacamos el nombre y el codigo de todos los profesores que sean de informatica y los añadimos al select
                $consultaProfesor = "SELECT cod_usuario, nombre, apellidos FROM Usuarios WHERE departamento = (SELECT codigo FROM Departamentos WHERE referencia = 'inf') ORDER BY nombre";
                $mostrarProfesor = $db->query($consultaProfesor);

                // Mostramos los resultados de la consulta en un select
                foreach ($mostrarProfesor as $row) {
                  $nombre = $row["nombre"];
                  $apellidos = $row["apellidos"];
                  $codigo2 = $row["cod_usuario"];
                  echo "<option value=".$codigo2.">" . $nombre." ".$apellidos. "</option>";
                }
                echo "</select></div>";
              ?>
            </select>
            </div>

            <div class="row">
              <div class="col-md-12 p-3">
                <input type='hidden' name='codigoTarea' value='<?php echo $_POST["codigoTarea"] ?>'>
                <button class="btn btn-secondary" name="asignarInci" type="submit">Asignar Incidencia</button>
              </div>
            </div>
        </form>

        <?php
        error_reporting(E_ALL ^ E_WARNING);
        // Asignamos a una variable el valor obtenido en el formulario
        $tipo_Incidencia = $_POST['tipo_Incidencia'];
        $asignarUsuario = $_POST['asignarUsuario'];
        $codigoTarea = $_POST['codigoTarea'];
        $asignada = $_POST['asignada'];
        
        // Consulta para sacar el codigo del usuario que ha sido seleccionado en el select
        $consultaCodigoSeleccion = "SELECT cod_usuario, nombre, apellidos, email FROM Usuarios WHERE cod_usuario = '$asignarUsuario'";
        $mostrarCodigo = $db->query($consultaCodigoSeleccion);

        foreach ($mostrarCodigo as $row) {
          $codigoUsuario = $row["cod_usuario"];
          $nombre = $row["nombre"];
          $email = $row["email"];
          $apellidos = $row["apellidos"];
        }
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          // Cuando se pulse el boton de asignar Incidencia
          if (isset($_POST["asignarInci"])) {
            require_once('../../archivosComunes/conexion.php');
            try {
              // Si el tipo de incidencia selecciona es de centro se asigna al operario
              if($tipo_Incidencia === "centro"){
                $consultaOperario = "SELECT cod_usuario, nombre FROM Usuarios WHERE rol = 2";
                $mostrarOperario = $db->query($consultaOperario);

                foreach ($mostrarOperario as $row) {
                  $nombreOperario = $row["nombre"];
                  $codigoOperario = $row["cod_usuario"];
                }

                $codigoUsuarioGestion = $_SESSION["usuario_login"]["cod_usuario"];
                
                $consultaCodigoOperario = "SELECT cod_usuario FROM Usuarios WHERE cod_usuario = $codigoOperario";
                $mostrarCodigoOperario = $db->query($consultaCodigoOperario);

                foreach ($mostrarCodigoOperario as $row) {
                  $codigoOperario = $row["cod_usuario"];
                }

                $preparada = $db->prepare("UPDATE Tareas set estado = ?, tipo_incidencia = ?,cod_usuario_gestion = ? WHERE cod_tarea = ?");
                $preparada->execute(array($asignada, $tipo_Incidencia, $codigoOperario, $codigoTarea));

                  require_once('funciones/correo.php');
                  require_once('../../archivosComunes/conexion.php');

                  $consultaComentario = "SELECT t.descripcion, t.localizacion, u.nombre nombre, u.apellidos apellidos, u.email email, ua.nombre nombreA, ua.apellidos apellidosA, ua.email emailA  FROM Tareas t, Usuarios u, Usuarios ua WHERE t.cod_tarea = $codigoTarea AND t.cod_usuario_crea = u.cod_usuario  AND t.cod_usuario_gestion = ua.cod_usuario";
                 
                  $mostrarComentario = $db->query($consultaComentario);

                  foreach ($mostrarComentario as $row) {
                    $descripcion = $row["descripcion"];
                    $nombreCrea = $row["nombre"];
                    $apellidoCrea = $row["apellidos"];
                    $emailCrea = $row["email"];
                    $nombreA = $row["nombreA"];
                    $apellidosA = $row["apellidosA"];
                    $emailA = $row["emailA"];
                    $localizacion = $row["localizacion"];
                  }
                  $cuerpo =
                  "Se ha asignado la tarea con código {$codigoTarea} al siguiente usuario:
  
                  <ul>
                      <li>Nombre: {$nombreA}</li>
                      <li>Apellidos: {$apellidosA}</li>
                      <li>Email: {$emailA}</li>
            
                  </ul>
                  El estado de la tarea es el siguiente
                  <ul>
                      <li>Estado: {$asignada}</li>
                      <li>Tipo de incidencia: {$tipo_Incidencia}</li>
                      <li>Localización: {$localizacion}</li>
                      <li>Descripción: {$descripcion}</li>
                      <li>Tarea creada por:{$nombreCrea} {$apellidoCrea}</li>
                      <li>Email: {$emailCrea}</li>

                  </ul>
                      ";
                    
                  enviarcorreo($emailA, "Nueva tarea de mantenimiento asignada", "$cuerpo");
                  print "
                    <script>
                      alert('Incidencia asignada correctamente');
                      window.location = 'admin.php';
                    </script>";

                
                // si se selecciona informatica, se selecciona a los profesores de informatica
              } else{
                $preparada = $db->prepare("UPDATE Tareas set estado = ?, tipo_incidencia = ?,cod_usuario_gestion = ? WHERE cod_tarea = ?");
                $preparada->execute(array($asignada, $tipo_Incidencia, $codigoUsuario,  $codigoTarea));
        
                if ($preparada->rowCount() > 0) {
                  require_once('funciones/correo.php');
                  require_once('../../archivosComunes/conexion.php');

                  $consultaComentario = "SELECT t.descripcion, t.localizacion, u.nombre nombre, u.apellidos apellidos, u.email email, ua.nombre nombreA, ua.apellidos apellidosA, ua.email emailA  FROM Tareas t, Usuarios u, Usuarios ua WHERE t.cod_tarea = $codigoTarea AND t.cod_usuario_crea = u.cod_usuario  AND t.cod_usuario_gestion = ua.cod_usuario";
                 
                  $mostrarComentario = $db->query($consultaComentario);
                 
                  foreach ($mostrarComentario as $row) {
                    $descripcion = $row["descripcion"];
                    $nombreCrea = $row["nombre"];
                    $apellidoCrea = $row["apellidos"];
                    $emailCrea = $row["email"];
                    $nombreA = $row["nombreA"];
                    $apellidosA = $row["apellidosA"];
                    $emailA = $row["emailA"];
                    $localizacion = $row["localizacion"];
                  }
                  $cuerpo =
                  "Se ha asignado la tarea con código {$codigoTarea} al siguiente usuario:
  
                  <ul>
                      <li>Nombre: {$nombreA}</li>
                      <li>Apellidos: {$apellidosA}</li>
                      <li>Email: {$emailA}</li>
            
                  </ul>
                  El estado de la tarea es el siguiente
                  <ul>
                      <li>Estado: {$asignada}</li>
                      <li>Tipo de incidencia: {$tipo_Incidencia}</li>
                      <li>Localización: {$localizacion}</li>
                      <li>Descripción: {$descripcion}</li>
                      <li>Tarea creada por:{$nombreCrea} {$apellidoCrea}</li>
                      <li>Email: {$emailCrea}</li>

                  </ul>
                      ";
                    
                  enviarcorreo($email, "Nueva tarea de mantenimiento asignada", "$cuerpo");
                  print "
                    <script>
                      alert('Incidencia asignada correctamente');
                      window.location = 'admin.php';
                    </script>";
                }

              }
            } catch (PDOException $e) {
              echo "Error en la base de datos " . $e->getMessage();
            }
          }
        }
        ?>
      </div>
    </article>
  </section>
  <script src="../js/bootstrap.bundle.min.js"></script>
  <script src="../js/asignarUsuario.js"></script>