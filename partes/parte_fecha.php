<?php
include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";

include_once "app/Conexion.inc.php";

include_once "app/RepositorioProfesor.inc.php";
include_once "app/Profesor.inc.php";

include_once "app/RepositorioAlumno.inc.php";
include_once "app/Alumno.inc.php";

include_once "app/RepositorioSesion.inc.php";

include_once "app/ValidarParte.inc.php";
session_start();
if(!isset($_SESSION["usuario_login"])){
    header("Location: ../index.php?redirigido=true");
};
if (isset($_POST["parte_fecha"])) {
    RepositorioSesion::iniciarSesion();
    $validar_fecha = new ValidarParte;
    if ($_POST["fecha"] == "" || !$validar_fecha->validaFecha($_POST["fecha"])) {
        $_SESSION["error_fecha"] = "El formato de la fecha es dd-mm-aaaa";
    } else {
        if (!isset($_POST["hora"])) {
            $_SESSION["error_hora"] = $_POST["hora"];
        } else{
                $_SESSION["fecha"] = $_POST["fecha"];
                $_SESSION["hora"] = $_POST["hora"];
                $_SESSION["materia"] = ($_POST["materia"] == "")? "":$_POST["materia"];

                if ($_SESSION["tipo_parte"] == 0) {
                    header("Location: parte_puntos_incidencia.php");
                } else {
                    header("Location: parte_descripcion.php");
                }
            }
        }
    }
?>    

<div class="container">
    <div class="row mifondoGlow">
        <h3 class="text-center mifondo miversalita micoloretiqueta 
            mipaddingtitulo">Selección fecha hora y materia</h3>
        <form class=" mipadding form-inline" method="post" 
              action="<?php $_SERVER["PHP_SELF"] ?>">
                  <?php
                  if (!isset($_POST["parte_fecha"])) {
                      include_once "plantillas/formulario_partes_fecha_vacio.inc.php";
                  } else {
                      if (!isset($_POST["parte_curso"])) {
                          include_once "plantillas/formulario_partes_fecha_validado.inc.php";
                      }
                  }
                  ?>
        </form>
    </div>
</div>

<br>

<div class="container">
    <br>
    <div class="row mifondo">
        <h3 class="text-center mifondo miversalita micoloretiqueta mipaddingtitulo">
             Datos parte  <?php echo $_SESSION["identificador_parte"] ?>
        </h3>
        <?php
        RepositorioSesion::iniciarSesion();
        echo "<div class = 'row col-md-12'>";
        RepositorioSesion::mostrarDatosSesion("Profesor", $_SESSION["usuario_login"]["nombre"]." ". $_SESSION["usuario_login"]["apellidos"]);
        echo "</div>";

        echo "<div class = 'row col-md-4'>";
        RepositorioSesion::mostrarDatosSesion("Alumno", $_SESSION["nombre_alumno"]);
        echo "</div>";
        echo "<div class = 'col-md-8'> ";
        RepositorioSesion::mostrarDatosSesion("Grupo", $_SESSION["grupo"]);
        echo "</div>";
        ?> 
    </div>    
</div>

<?php
include_once "plantillas/pie.inc.php";
?>
