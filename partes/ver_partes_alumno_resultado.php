<?php
include_once "app/RepositorioSesion.inc.php";

include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";

include_once "app/Conexion.inc.php";

include_once "app/RepositorioAlumno.inc.php";
include_once "app/ValidarParte.inc.php";
include_once "app/RepositorioParte_Expulsion.inc.php";

Conexion::abrirConexion();
// obtengo las expulsiones y los datos del alumno
$partes_alumno = RepositorioParte::getPartesAlumnoCodigo
                (Conexion::getConexion(), $_SESSION["nombre_alumno"], $_SESSION["usuario_login"]["tutor_grupo"]);

$datos_alumno = RepositorioAlumno::getAlumnoCodigo(Conexion::getConexion(), $_SESSION["nombre_alumno"]);
// muestro el resultado por pantalla.
?>
<div class="container">
    <div class="col-md-12"> 
        <div class="panel panel-default" >
            <div class="panel-heading" >
                <h3 class="text-center mifuente minegrita miversalita micoloretiqueta ">
                <?php
                echo "Partes del alumno: " . $datos_alumno[2]
                 . " " . $datos_alumno[1];
                ?>
                </h3>
            </div>
            <?php if (empty($partes_alumno)) { ?>
                <h4 class="mifuente minegrita mimargen micolor miversalita">
                    No hay expulsiones. 
                </h4>
            <?php } else {
                ?>
                <div class="panel-body">
                    <table class="table table-responsive">
                        <tr>
                            <th class="mifuente  micoloretiqueta minegrita">Profesor</th>
                            <th class="mifuente  micoloretiqueta minegrita">fecha</th>
                            <th class="mifuente  micoloretiqueta minegrita">Incidencia</th>
                            <th class="mifuente  micoloretiqueta minegrita">Puntos</th>
                            <th class="mifuente  micoloretiqueta minegrita">Acciones</th>
                        </tr>
                        <tbody>
                        <?php
                        foreach ($partes_alumno as $parte) {
                            ?>
                                <tr>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo $parte["nombre"] . " " . $parte["apellidos"] ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo date("d-m-Y", strtotime($parte["fecha"])); ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo $parte["incidencia"] ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo $parte["puntos"] ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <form  method="post"  action="<?php $_SERVER['PHP_SELF'] ?>">
                                            <input type="hidden" name="codigo_parte" value="<?php echo $parte["cod_parte"] ?>">
                                            <button type="submit" class="btn micolor btn-primary miversalita" 
                                                    name="ver">
                                                <span class="glyphicon glyphicon-eye-open" aria-hidden="true">
                                                    Ver
                                                </span>
                                            </button> 
                                        </form>
                                    </td>
                                </tr>    
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php
if (isset($_POST['ver']) || isset($_POST['ver_expulsiones'])) {
    //cargo los datos del parte
    if (isset($_POST['ver'])) {
        $datos_parte = RepositorioParte::getDatosParte
                        (Conexion::getConexion(), $_POST["codigo_parte"]);
    } else {
        $datos_parte = RepositorioParte_Expulsion::getDatosParteExpulsion
                        (Conexion::getConexion(), $_POST["codigo_parte"]);
    }
    //muestro la información del parte seleccionado
    include_once("plantillas/datos_parte.inc.php");
}


include_once("plantillas/pie.inc.php");
Conexion::cerrarConexion();
?>
