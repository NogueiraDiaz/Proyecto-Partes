<?php
include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";

include_once "app/Conexion.inc.php";
include_once "app/RepositorioSesion.inc.php";

include_once "app/RepositorioAlumno.inc.php";
include_once "app/Alumno.inc.php";

include_once "app/ValidarParte.inc.php";
include_once "app/RepositorioGrupo.inc.php";
session_start();
if(!isset($_SESSION["usuario_login"])){
    header("Location: ../index.php?redirigido=true");
};
    
$_SESSION["tipo_parte"] = 0;
$_SESSION["identificador_parte"] = "incidencia";
Conexion::abrirConexion();
$_SESSION["grupos"] = RepositorioGrupo::getGrupos(Conexion::getConexion());
Conexion::cerrarConexion();
RepositorioSesion::iniciarSesion();
if (isset($_POST["parte_grupo"])) {
    // Si el usuario pulsa el boton de enviar
    // CUIDADO con required de html que da problemas con $_POST["enviar"]

    if (!isset($_POST["grupo"])) {
        // para controlar el error de que no haya seleccionado el curso o el grupo
        $_SESSION["error_curso_grupo"] = "Tienes que seleccionar el grupo del alumno";
    } else {
        Conexion::abrirConexion();
        $_SESSION["grupo"] = $_POST["grupo"];
        Conexion::cerrarConexion();
        header("Location: parte_nombre.php");
    }
}
?>    

<div class="container">
    <div class="row mifondoGlow">
        <h3 class='text-center mifondo miversalita micoloretiqueta 
            mipaddingtitulo'>Selección curso y grupo alumno </h3>
        <form class="center-block mipadding form-inline" method="post" 
              action="<?php $_SERVER["PHP_SELF"] ?>">
                  <?php
                  if (!isset($_POST["parte_grupo"])) {
                      include_once "plantillas/formulario_partes_grupo_vacio.inc.php";
                  } else {
                      include_once "plantillas/formulario_partes_grupo_validado.inc.php";
                  }
                  ?>
        </form>
    </div>
</div>

<br>

<!-- Salida por pantalla de los datos del parte-->
<div class="container">
    <br>
    <div class="row mifondo">
        <h3 class="text-center mifondo miversalita micoloretiqueta mipaddingtitulo">
            Datos parte <?php echo $_SESSION["identificador_parte"] ?>
        </h3>
        <?php
        RepositorioSesion::iniciarSesion();
        echo "<div class = 'row col-md-12'> ";
        RepositorioSesion::mostrarDatosSesion("Profesor", $_SESSION["usuario_login"]["nombre"]." ". $_SESSION["usuario_login"]["apellidos"]);
        echo "</div>";
        ?> 
    </div>    
</div>

<br>

<?php
include_once "plantillas/pie.inc.php";
?>

