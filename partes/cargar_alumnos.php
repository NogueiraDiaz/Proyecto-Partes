<?php
include_once "app/RepositorioSesion.inc.php";

include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";

include_once "app/Conexion.inc.php";

include_once "app/ValidarParte.inc.php";

include_once "app/RepositorioAlumno.inc.php";
include_once "app/RepositorioGrupo.inc.php";

Conexion::abrirConexion();
$_SESSION["grupos"] = RepositorioGrupo::getGrupos(Conexion::getConexion());
Conexion::cerrarConexion();

if (isset($_POST["cargar_alumnos"])) {
    // Si el usuario pulsa el boton de enviar
    // CUIDADO con required de html que da problemas con $_POST["enviar"]
    if (!isset($_POST["grupo"])) {
        $_SESSION["error_grupo"] = "Tienes que seleccionar un grupo";
    } else {
        if (empty($_POST["fichero"])) {
            $_SESSION["error_fichero"] = "Tienes que seleccionar un fichero";
        } else {
            $_SESSION["info_alta_grupo"] = $_POST["grupo"];
            Conexion::abrirConexion();
            if (RepositorioAlumno::cargarAlumnosCurso(Conexion::getConexion(), $_POST["grupo"], $_POST["fichero"])) {
                $_SERVER["alta_correcta"] = TRUE;
            } else {
                $_SERVER["alta_correcta"] = FALSE;
            }
            Conexion::cerrarConexion();
        }
    }
}
?>
<div class="container">
    <div class="row mifondoGlow">
        <h3 class='text-center mifondo miversalita micoloretiqueta 
            mipaddingtitulo'>Cargar alumnos grupo</h3>
        <form class="center-block mipadding form-inline" method="post" 
              action="<?php $_SERVER["PHP_SELF"] ?>">
                  <?php
                  if (!isset($_POST["cargar_alumnos"])) {
                      include_once "plantillas/formulario_carga_alumnos_vacio.inc.php";
                  } else {
                      include_once "plantillas/formulario_carga_alumnos_validado.inc.php";
                  }
                  ?>
        </form>
    </div>
</div>




<?php
include_once("plantillas/pie.inc.php");
?>


