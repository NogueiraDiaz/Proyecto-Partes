<?php
include_once "app/RepositorioSesion.inc.php";

include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";

include_once "app/Conexion.inc.php";

include_once "app/RepositorioAlumno.inc.php";
include_once "app/ValidarParte.inc.php";
include_once "app/RepositorioParte_Expulsion.inc.php";

Conexion::abrirConexion();
if ($_SESSION["usuario_login"]["tutor_grupo"] != "No."){
    $_SESSION["alumnos_grupo"] = RepositorioAlumno::getAlumnosGrupo(Conexion::getConexion(), $_SESSION["usuario_login"]["tutor_grupo"]);
}
if (isset($_POST["parte_grupo_nombre"])) {
    // Si el usuario pulsa el boton de enviar
    // CUIDADO con required de html que da problemas con $_POST["enviar"]

    if (!isset($_POST["nombre"])) {
        // para controlar el error de que no haya seleccionado el alumno
        $_SESSION["error_nombre"] = "Tienes que seleccionar el nombre del alumno";
    }
    else{
        $_SESSION["nombre_alumno"] = $_POST["nombre"];
        header("Location: ver_partes_alumno_resultado.php");
    }
}

?>

<div class="container">
    <div class="row mifondo">
        <h3 class='text-center mifondo miversalita micoloretiqueta 
            mipaddingtitulo'>Selección nombre alumno </h3>
        <form class="center-block mipadding form-inline" method="post" 
              action="<?php $_SERVER["PHP_SELF"] ?>">
                  <?php
                  if (!isset($_POST["parte_grupo_nombre"])) {
                      include_once "plantillas/formulario_ver_expulsiones_alumno_vacio.inc.php";
                  } else {
                      include_once "plantillas/formulario_ver_expulsiones_alumno_validado.inc.php";
                  }
                  ?>
        </form>
    </div>
</div>
<br>

<?php
include_once("plantillas/pie.inc.php");
Conexion::cerrarConexion();
?>







