<?php
include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";

include_once "app/Conexion.inc.php";
include_once "app/RepositorioSesion.inc.php";

include_once "app/RepositorioAlumno.inc.php";
include_once "app/Alumno.inc.php";

include_once "app/ValidarParte.inc.php";

RepositorioSesion::iniciarSesion();

// lo pongo aqui y no en el else, por si le da atras cuando tiene
// que seleccionar el nombre del alumno. Si lo pongo en el else
// Los alumnos no se cargarían en el select del formulario.
Conexion::abrirConexion();
$_SESSION["alumnos_grupo"] = RepositorioAlumno::getAlumnosGrupo(Conexion::getConexion()
                , $_SESSION["grupo"]);

if (isset($_POST["parte_grupo_nombre"])) {
    // Si el usuario pulsa el boton de enviar
    // CUIDADO con required de html que da problemas con $_POST["enviar"]
    if (!isset($_POST["nombre"])) {
        // para controlar el error de que no haya seleccionado el nombre
        $_SESSION["error_nombre"] = "Tienes que seleccionar el nombre del alumno";
    } else {
        // Pongo primero el nombre y luego el apellido para mostrarlo 
        $nombre_apellidos = explode(",", $_POST["nombre"]);
        $_SESSION["nombre_alumno"] = ($nombre_apellidos[1] . " " . $nombre_apellidos[0]);

        // el trim es para quitar el blanco que he puesto al mostrarlos separdos
        // por coma. CUIDADOOOOOOOOOOOOOOO
        $_SESSION["codigo_alumno"] = RepositorioAlumno::getAlumnoNombreyGrupo(Conexion::getConexion(), trim($nombre_apellidos[1]), $nombre_apellidos[0], $_SESSION["grupo"]);

        // *********** El unset no sé si es porque en el flujo al pasar a una nueva ventana con parte_fecha hay que destruirlo, o ahora al seguir en la misma ventana con
        // parte_tipo_es_expulsión no hay que borrarla     
        //unset($_SESSION["alumnos_grupo"]);
        // header("Location: parte_fecha.php");
        header("Location: parte_tipo_es_expulsion.php");
    }
}
Conexion::cerrarConexion();
?> 

<div class="container">
    <div class="row mifondoGlow">
        <h3 class='text-center mifondo miversalita micoloretiqueta 
            mipaddingtitulo'>Selección nombre alumno </h3>
        <form class="center-block mipadding form-inline" method="post" 
              action="<?php $_SERVER["PHP_SELF"] ?>">
                  <?php
                  if (!isset($_POST["parte_grupo_nombre"])) {
                      include_once "plantillas/formulario_partes_nombre_vacio.inc.php";
                  } else {
                      include_once "plantillas/formulario_partes_nombre_validado.inc.php";
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
        RepositorioSesion::mostrarDatosSesion("Profesor", $_SESSION["usuario_login"]["nombre"]." ".$_SESSION["usuario_login"]["apellidos"]);
        echo "</div>";
        ?> 
    </div>    
</div>

<br>

<?php
include_once "plantillas/pie.inc.php";
?>

