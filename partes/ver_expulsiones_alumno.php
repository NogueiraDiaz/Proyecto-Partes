<?php
include_once "app/RepositorioSesion.inc.php";

include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";

include_once "app/Conexion.inc.php";

include_once "app/RepositorioAlumno.inc.php";
include_once "app/ValidarParte.inc.php";
include_once "app/RepositorioParte_Expulsion.inc.php";

Conexion::abrirConexion();

if (isset($_POST["parte_grupo_nombre"])) {
    if (!isset($_POST["nombre"])) {
        $_SESSION["error_nombre"] = "Tienes que seleccionar el nombre del alumno";
    } 
}

$_SESSION["alumnos_grupo"] = RepositorioAlumno::getAlumnosGrupo(Conexion::getConexion()
                , $_SESSION["usuario_login"]["tutor_grupo"]);
  
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
if (isset($_POST["parte_grupo_nombre"])) {
    if (isset($_POST["nombre"])) {
        $nombre_apellidos = explode(",", $_POST["nombre"]);
        $_SESSION["nombre_alumno"] = $_POST["nombre"];
		$partes_alumno = RepositorioParte::getExpulsionesAlumno(Conexion::getConexion(), $_SESSION["nombre_alumno"]);
		$datos_alumno = RepositorioAlumno::getAlumnoCodigo(Conexion::getConexion(), $_SESSION["nombre_alumno"]);
        include_once("plantillas/tabla_alumnos_expulsiones.inc.php");
    }
}
Conexion::cerrarConexion();
include_once("plantillas/pie.inc.php");
?>




