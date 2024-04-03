<?php
include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";

include_once "app/Conexion.inc.php";

include_once "app/RepositorioSesion.inc.php";

include_once "app/ValidarParte.inc.php";

include_once "app/RepositorioIncidencia.inc.php";
include_once "app/Incidencia.inc.php";
session_start();
if(!isset($_SESSION["usuario_login"])){
    header("Location: ../index.php?redirigido=true");
};
RepositorioSesion::iniciarSesion();

Conexion::abrirConexion();
$_SESSION["incidencias"] = RepositorioIncidencia::getIncidenciasPuntos
                (Conexion::getConexion(), $_SESSION["puntos_incidencia"]);
Conexion::cerrarConexion();

if (isset($_POST["parte_incidencia"])) {
    if (!isset($_POST["nombre"])) {
        $_SESSION["error_incidencia"] = "Tienes que seleccionar una incidencia";
    } else {
        $_SESSION["nombre_incidencia"] = $_POST["nombre"];
        $_SESSION["codigo_incidencia"] = RepositorioIncidencia::getCodigoIncidencia
                        ($_SESSION["incidencias"], $_POST["nombre"], $_POST["puntos_incidencia"]);
        unset($_SESSION["incidencias"]);
        header("Location: parte_descripcion.php");
    }
} 
?>  

<div class="container">
    <div class="row mifondoGlow">
        <h3 class='text-center mifondo miversalita micoloretiqueta 
            mipaddingtitulo'>Selección descripción incidencia </h3>
        <form class="center-block mipadding form-inline" method="post" 
              action="<?php $_SERVER["PHP_SELF"] ?>">
                  <?php
                  if (!isset($_POST["parte_incidencia"])) {
                      include_once "plantillas/formulario_partes_incidencia_vacio.inc.php";
                  } else {
                      include_once "plantillas/formulario_partes_incidencia_validado.inc.php";
                  }
                  ?>
        </form>
    </div>
</div>

<br>

<!-- Salida por pantalla información puntos parte incidencia-->

<div class="container">
    <br>
    <div class="row mifondo mitama miversalita" >
        <h3 class="text-center mifondo miversalita micoloretiqueta mipaddingtitulo">
            Información selección puntos incidencia
        </h3>
        <?php
        include_once 'plantillas/puntos_incidencias.inc.php';
        ?>
    </div>
</div>

<?php
include_once "plantillas/pie.inc.php";
?>