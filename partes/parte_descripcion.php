<?php
include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";

include_once "app/Conexion.inc.php";

include_once "app/RepositorioSesion.inc.php";

include_once "app/RepositorioIncidencia.inc.php";
include_once "app/Incidencia.inc.php";
session_start();
if(!isset($_SESSION["usuario_login"])){
    header("Location: ../index.php?redirigido=true");
};
RepositorioSesion::iniciarSesion();

if (isset($_POST["parte_descripcion"])) {
    // Si el usuario pulsa el boton de enviar
    // CUIDADO con required de html que da problemas con $_POST["enviar"]

    $_SESSION["descripcion_parte"] = $_POST["descripcion"];
    header("Location: parte_comunicacion.php");
}
?>    

<div class="container mifondoGlow">
    <div class="row mifondo">
        <h3 class="text-center mifondo miversalita micoloretiqueta 
            mipaddingtitulo">
            <?php if ($_SESSION["identificador_parte"] == "incidencia") { ?>
                Descripción de la incidencia
            <?php } else { ?>
                Descripción de los hechos y reflexión
            <?php } ?>
        </h3>
        <form class="center-block mipadding" method="post" 
              action="<?php $_SERVER["PHP_SELF"] ?>">
                  <?php
                  if (!isset($_POST["parte_descripcion"])) {
                      include_once "plantillas/formulario_partes_descripcion_vacio.inc.php";
                  } else {
                      include_once "plantillas/formulario_partes_descripcion.inc.php";
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
        echo "<div class = 'row col-md-12'> ";
        RepositorioSesion::mostrarDatosSesion("Profesor", $_SESSION["usuario_login"]["nombre"]." ". $_SESSION["usuario_login"]["apellidos"]);
        echo "</div>";

        echo "<div class = 'row col-md-4'> ";
        RepositorioSesion::mostrarDatosSesion("Alumno", $_SESSION["nombre_alumno"]);
        echo "</div>";
        echo "<div class = 'col-md-8'> ";
        RepositorioSesion::mostrarDatosSesion("Grupo", $_SESSION["grupo"]);
        echo "</div>";

        echo "<div class = 'row col-md-4'> ";
        RepositorioSesion::mostrarDatosSesion("Fecha", $_SESSION["fecha"]);
        echo "</div>";
        echo "<div class = 'col-md-8'> ";
        RepositorioSesion::mostrarDatosSesion("Hora", $_SESSION["hora"]);
        echo "</div>";

        echo "<div class = 'row col-md-12'> ";
        RepositorioSesion::mostrarDatosSesion("Materia", $_SESSION["materia"]);
        echo "</div>";
        
        if ($_SESSION["identificador_parte"] == "incidencia") {
            echo "<div class = 'row col-md-4'> ";
            RepositorioSesion::mostrarDatosSesion("Incidencia", $_SESSION["nombre_incidencia"]);
            echo "</div>";
            echo "<div class = 'col-md-8'> ";
            RepositorioSesion::mostrarDatosSesion("Puntos", $_SESSION["puntos_incidencia"]);
            echo "</div>";
        }
        ?> 
    </div>    
</div>

<?php
include_once "plantillas/pie.inc.php";
?>


