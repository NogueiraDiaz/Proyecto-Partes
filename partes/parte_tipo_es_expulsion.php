<?php
include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";

include_once "app/Conexion.inc.php";
include_once "app/RepositorioSesion.inc.php";

include_once "app/RepositorioAlumno.inc.php";
include_once "app/Alumno.inc.php";

include_once "app/ValidarParte.inc.php";
session_start();
if(!isset($_SESSION["usuario_login"])){
    header("Location: ../index.php?redirigido=true");
};
RepositorioSesion::iniciarSesion();

// lo pongo aqui y no en el else, por si le da atras cuando tiene
// que seleccionar el nombre del alumno. Si lo pongo en el else
// Los alumnos no se cargarían en el select del formulario.
Conexion::abrirConexion();
$_SESSION["alumnos_grupo"] = RepositorioAlumno::getAlumnosGrupo(Conexion::getConexion()
                , $_SESSION["usuario_login"]["tutor_grupo"]);
// Falta esta sesión para sacar el alumno elegido en parte_nombre
$_SESSION["nom_alumno"] = RepositorioAlumno::getAlumnoNombre(Conexion::getConexion(), $_SESSION["grupo"], $_SESSION["nombre_alumno"]);

if (isset($_POST["parte_tipo_es_expulsion"])) {
    // Si el usuario pulsa el boton de enviar
    // CUIDADO con required de html que da problemas con $_POST["enviar"]

        if (!isset($_POST["tipo_es_expulsion"])) {
            // para controlar el error de que no haya seleccionado el curso o el grupo
            $_SESSION["error_tipo_es_expulsion"] = "Tienes que seleccionar tipo de expulsión";
        } else {
            $_SESSION["tipo_es_expulsion"] = $_POST["tipo_es_expulsion"];           
            header("Location: parte_fecha.php");
        }   
}
Conexion::cerrarConexion();
?> 

<div class="container">
    <div class="row mifondo">
        <h3 class='text-center mifondo miversalita micoloretiqueta 
            mipaddingtitulo'>Selección nombre alumno </h3>
        <form class="center-block mipadding form-inline" method="post" 
              action="<?php $_SERVER["PHP_SELF"] ?>">
                  <?php
                  if (!isset($_POST["tipo_es_expulsion"])) {
                      include_once "plantillas/formulario_parte_tipo_es_expulsion_vacio.inc.php";
                  } else {
                      include_once "plantillas/formulario_parte_tipo_es_expulsion_validado.inc.php";
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
