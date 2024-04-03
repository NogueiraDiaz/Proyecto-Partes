<?php
include_once "app/RepositorioSesion.inc.php";

include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";

include_once "app/Conexion.inc.php";

include_once "app/RepositorioParte_Expulsion.inc.php";
include_once "app/RepositorioAlumno.inc.php";

Conexion::abrirConexion();
// Obtengo los partes del alumno que se ha seleccionado
$fechas = RepositorioParte_Expulsion::getFechasExpulsion(Conexion::getConexion(), $_SESSION["cod_alumno"]);
$datos_alumno = RepositorioAlumno::getAlumnoCodigo(Conexion::getConexion(), $_SESSION["cod_alumno"]);
if(!empty($fechas)){
    $expulsiones_alumno = RepositorioParte_Expulsion::getPartesExpulsionAlumnosCodigoExpulsion(Conexion::getConexion(), $_SESSION["cod_alumno"], $fechas[0][3]);
}
Conexion::cerrarConexion();
?>

<div class="container">
    <div class="col-md-12 text-right"> 
        <?php if (isset($_SESSION["jefatura_expulsiones"])) { ?>
            <a href="ver_expulsiones_jefatura_alumno.php" class="btn btn-success miversalita "> 
        <?php unset($_SESSION["jefatura_expulsiones"]);
        } else { ?>   
            <a href="gestion_alumnos.php" class="btn btn-success miversalita ">
        <?php } ?> 
            <span class="glyphicon glyphicon-menu-left" aria-hidden="true"> Volver</span>
            </a>
    </div> 
    <br> <br>

    <div class="col-md-12"> 
        <div class="panel panel-default" >
            <div class="panel-heading" >
                <h3 class="text-center mifuente minegrita miversalita micoloretiqueta ">
                    <?php echo "Expulsiones del alumno: " . $datos_alumno["nombre"] . " " . $datos_alumno["apellidos"]; ?>
                </h3>
            </div>
            <?php if (empty($fechas)) { ?>
            <h4 class="mifuente minegrita mimargen micolor miversalita">
                No hay expulsiones. 
            </h4>
            <?php } ?>
            <div class="panel-body">
                <table class="table table-responsive">
                    <?php foreach ($fechas as $fecha){ ?>
                        <tr class ="mifondo">
                            <td colspan="1" class="mifuente  micoloretiqueta minegrita">
                                <span class="micolor minegrita">Fecha Inicio: </span>
                                <?php echo date("d-m-Y", strtotime($fecha["fecha_Inicio"])); ?>
                                <span class="micolor minegrita">- Fecha Finalización: </span>
                                <?php echo date("d-m-Y", strtotime($fecha["fecha_Fin"])); ?>
                            </td>
                        </tr>
                  <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['ver'])) {
    // borro el parte que se ha seleccionado
    Conexion::abrirConexion();
    //cargo los datos del parte
    $datos_parte = RepositorioParte_Expulsion::getDatosParteExpulsion
                    (Conexion::getConexion(), $_POST["codigo_parte"]);
    Conexion::cerrarConexion();
    //muestro la información del parte seleccionado
    include_once("plantillas/datos_parte.inc.php");
}
include_once("plantillas/pie.inc.php");
?>