<?php
// Iniciamos la sesion
session_start();
// Para acceder a esta pagina hay que iniciar sesion previamente.
require_once('./funciones/loginRequerido.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../css/bootstrap.min.css">
  <link rel="stylesheet" href="../../css/styles.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
  <title>Crear Incidencia</title>
</head>

<body>
  <?php
  require_once("funciones/header.php");
  ?>
  <section>
    <article>
      <div class="container px-4 py-5" id="editarPerfil">
        <h2 class="pb-2 border-bottom">Crear Incidencia</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6 p-3">
              <label class="form-label">Nivel de tarea</label>
              <select class="form-select" aria-label="Select Nivel de Tarea" name="nvl_Tarea">
                <option value="Bajo">Bajo</option>
                <option value="Medio">Medio</option>
                <option value="Alto">Alto</option>
              </select>
              <input type="hidden" name="estado" value="No Asignada" />
              <input type="hidden" name="nombre" value="<?php echo  $_SESSION["usuario_login"]["nombre"]; ?>" />
              <input type="hidden" name="apellidos" value="<?php echo  $_SESSION["usuario_login"]["apellidos"]; ?>" />
              <input type="hidden" name="email" value="<?php echo  $_SESSION["usuario_login"]["email"]; ?>" />

            </div>

            <div class="col-md-6 mt-3">
              <label class="form-label">Selecciona la imagen</label>
              <input class="form-control" type="file" name="image" />
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 p-3 ">
              <label for="fechaini" class="form-label">Fecha Inicio</label>
              <input type="date" class="form-control" id="fechaini" name="fechaini" required>
            </div>

            <div class="col-md-6 p-3 ">
              <label for="localizacion" class="form-label">Localización</label>
              <input type="text" class="form-control" id="localizacion" name="localizacion" required>

            </div>
          </div>

          <div class="row">
            <div class="col-md-12 p-3 d-flex justify-content-center">
              <textarea placeholder="Descripción" class="w-100 h-100" name="descripcion" required></textarea>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 p-3">
              <button class="btn float" name="crearInci" type="submit" style="background-color: rgba(0, 0, 0, 0.2);">Crear Incidencia</button>
            </div>
          </div>
        </form>

        <?php
          require_once("funciones/crearIncidenciaFuncion.php");
        ?>
        
      </div>
    </article>
  </section>
  <script src="../js/bootstrap.min.js"></script>
  <?php
    require_once("funciones/footer.php");
  ?>
