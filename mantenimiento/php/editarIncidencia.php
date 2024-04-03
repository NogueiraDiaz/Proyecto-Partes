<?php
  error_reporting(E_ALL ^ E_WARNING);
  // Iniciamos la sesion
  session_start();
  // Para acceder a esta pagina hay que iniciar sesion previamente.
  require_once('funciones/loginRequerido.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/styles.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
  <title>Editar Incidencia</title>
</head>
<body>
<?php
    require_once("funciones/header.php");
  ?>
  <section>
    <article>
      <div class="container px-4 py-5" id="editarInci">
        <h2 class="pb-2 border-bottom titletable">Editar Incidencia</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

          <div class="row">
            <div class="col-md-12 p-3 ">
              <label class="form-label">Estado de la tarea</label>
              <select class="form-select" aria-label="Select estado de Tarea" name="estado">
                <option value="En Proceso">En proceso</option>
                <option value="Realizada">Realizada</option>
                <option value="Rechazada">Rechazada</option>
              </select>
            </div>
          </div>

          <div class="row">
          <label class="form-label">Añadir al comentario tu resolución</label>

            <div class="col-md-12 p-3 d-flex justify-content-center">

              <textarea placeholder="Comentario" class="w-100 h-100" name="comentario" required><?php echo  $_POST["comentario"]?></textarea>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 p-3">
              <input type='hidden' name='codigoTarea1' value='<?php echo $_POST["codigoTarea"]?>'>
              <input type='hidden' name='nombre' value='<?php echo $_POST["nombre"]?>'>
              <input type='hidden' name='apellidos' value='<?php echo $_POST["apellidos"]?>'>
              <input type='hidden' name='email' value='<?php echo $_POST["email"]?>'>
              <input type='hidden' name='descripcion' value='<?php echo $_POST["descripcion"]?>'>
              <button class="btn btn-secondary" name="editarInci" type="submit">Editar Incidencia</button>
            </div>
          </div>
        </form>
        <?php
        error_reporting(E_ALL ^ E_WARNING);
        // Asignamos a una variable el valor obtenido en el formulario
        $estado = $_POST['estado'];
        $descripcion = $_POST['descripcion'];
        $comentario = $_POST['comentario'];
        $codigoTarea1 = $_POST['codigoTarea1'];
        $nombre=$_POST['nombre'];
        $apellidos=$_POST['apellidos'];
        $email=$_POST['email'];
        require_once('../../archivosComunes/conexion.php');

        if($_SERVER["REQUEST_METHOD"] == "POST"){
          // Si se pulsa editar incidencia
          if (isset($_POST["editarInci"])) {
            $fechaActual = date("Y-m-d"); // Sacamos la fecha Actual
            try {
              // Consulta para actualizar las tareas que hayan sido seleccionadas
              $preparada = $db->prepare("UPDATE Tareas SET estado = ?, comentario = ? WHERE cod_tarea = ?");
              $preparada->execute(array($estado,$comentario,$codigoTarea1));
              // Si el estado de la tarea esta a realizada
              if($estado === 'Realizada'){
                // Actualizamos la fecha fin con la fecha actual
                $preparada = $db->prepare("UPDATE Tareas SET estado = ?, comentario = ?, fecha_fin = ? WHERE cod_tarea = ?");
                $preparada->execute(array($estado,$comentario,$fechaActual,$codigoTarea1));
              }
              // Cuando se ejecute la consulta...
               if ($preparada->rowCount() > 0){
                require_once('funciones/correo.php');
                require_once('../../archivosComunes/conexion.php');
                $subConsultaCreador = "SELECT email, nombre, apellidos FROM Usuarios WHERE cod_usuario = (SELECT cod_usuario_crea FROM Tareas WHERE cod_tarea = '$codigoTarea1')";
                $subConsultaCreador = $db->query($subConsultaCreador);
            
                foreach ($subConsultaCreador as $row2) {
                  $emailCreador = $row2["email"];
                  $nombreCreador = $row2["nombre"];
                  $apellidosCreador = $row2["apellidos"];

                }

                $subConsultaEditor = "SELECT email, nombre, apellidos FROM Usuarios WHERE cod_usuario = (SELECT cod_usuario_gestion FROM Tareas WHERE cod_tarea = '$codigoTarea1')";
                $subConsultaEditor = $db->query($subConsultaEditor);
            
                foreach ($subConsultaEditor as $row2) {
                  $emailEditor = $row2["email"];
                  $nombreEditor  = $row2["nombre"];
                  $apellidosEditor  = $row2["apellidos"];

                }
                $cuerpo =
                "Se ha editado el estado de la incidencia {$codigoTarea1} por el siguiente usuario:
                <ul>
                    <li>Nombre: {$nombreEditor}</li>
                    <li>Apellidos: {$apellidosEditor}</li>
                    <li>Email: {$emailEditor}</li>
          
                </ul>
                El estado de la tarea es el siguiente
                <ul>
                    <li>Estado: {$estado}</li>
                    <li>Descripción: {$descripcion}</li>
                    <li>Comentario: {$comentario}</li>
                    <li>Fecha Actual: {$fechaActual}</li>

        
                </ul>

                El usuario creador fue:
                <ul>
                <li>Nombre: {$nombreCreador}</li>
                <li>Apellidos: {$apellidosCreador}</li>
                <li>Email: {$emailCreador}</li>

        
                </ul>
                  ";
                if($estado === 'Realizada'){
                  enviarcorreo($emailCreador, "Tarea de mantenimiento acabada", "$cuerpo");

                }else if($estado === 'En Proceso'){
                  enviarcorreo($emailCreador, "Tarea de mantenimiento en proceso", "$cuerpo");

                }else if($estado === 'Rechazada'){
                  enviarcorreo($emailCreador, "Tarea de mantenimiento rechazada", "$cuerpo");

                }
        
                print "
                  <script>
                    alert('Incidencia editada con Éxito')
                      window.location = 'funciones/rolApp.php';
                  </script>";
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
</body>
</html>