<?php
include_once "app/RepositorioSesion.inc.php";

include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";

include_once "app/Conexion.inc.php";

include_once "app/RepositorioParte.inc.php";

include_once "app/Parte.inc.php";
Conexion::abrirConexion();
// Obtengo los partes del grupo
echo $_SESSION["usuario_login"]["tutor_grupo"];
$partes_alumno = RepositorioParte::getPartesGrupo
                (Conexion::getConexion(), $_SESSION["usuario_login"]["tutor_grupo"]);
Conexion::cerrarConexion();
?>

<div class="container">
    <div class="col-md-12"> 
        <div class="panel panel-default" >
            <div class="panel-heading" >
                <h3 class="text-center mifuente minegrita miversalita micoloretiqueta ">
                    Partes actuales.
                </h3>
            </div>
            <?php if (empty($partes_alumno)) { ?>
                <h4 class="mifuente minegrita mimargen micolor miversalita">
                    Actualmente no hay ningún parte. 
                </h4>

            <?php } else {
                ?>
                <div class="panel-body">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th class="mifuente  micoloretiqueta minegrita">Profesor</th>
                                <th class="mifuente  micoloretiqueta minegrita">Alumno</th>
                                <th class="mifuente  micoloretiqueta minegrita">Fecha</th>
                                <th class="mifuente  micoloretiqueta minegrita">Incidencia</th>
                                <th class="mifuente  micoloretiqueta minegrita">Puntos</th>
                                <th class="mifuente  micoloretiqueta minegrita">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($partes_alumno as $parte) {
                                ?>
                                <tr>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo $parte["nombre"] . " " . $parte["apellidos"] ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo $parte["nombreAlumno"] . " " . $parte["apellidosAlumno"] ?>
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
                            <?php }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php
if (isset($_POST['ver'])) {
    // borro el parte que se ha seleccionado
    Conexion::abrirConexion();
    //cargo los datos del parte
    $datos_parte = RepositorioParte::getDatosParte
                    (Conexion::getConexion(), $_POST["codigo_parte"]);
    Conexion::cerrarConexion();

    //muestro la información del parte seleccionado

    include_once("plantillas/datos_parte.inc.php");
}
include_once("plantillas/pie.inc.php");
?>




