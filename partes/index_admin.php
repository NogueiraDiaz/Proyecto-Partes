<?php
include_once "app/RepositorioSesion.inc.php";
include_once "app/RepositorioParte_Expulsion.inc.php";

include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";

include_once "app/Conexion.inc.php";

Conexion::abrirConexion();
$alumnos_expulsados = RepositorioParte_Expulsion::get_Expulsiones_Sin_Fecha
                (Conexion::getConexion());

if (isset($_POST["enviar_codigo"])) {
    $_SESSION["codigo_expulsion"] = $_POST["codigo_expulsion"];
}
?>
<div class="container">
    <div class="col-md-12"> 
        <div class="panel panel-default" >
            <div class="panel-heading" >
                <h3 class="text-center mifuente minegrita miversalita micoloretiqueta ">
                    Expulsiones Pendientes
                </h3>
            </div>
            <?php if (!empty($alumnos_expulsados)) { ?>
                <div class="panel-body">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th class="mifuente minegrita micoloretiqueta miversalita">
                                    Alumno
                                </th>
                                <th class="mifuente minegrita micoloretiqueta miversalita">
                                    Grupo
                                </th>
                                <th class="mifuente minegrita micoloretiqueta miversalita">
                                    Acción
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($alumnos_expulsados as $alumno) { ?>
                                <tr>
                                    <td class="mifuente micolor minegrita miversalita">
                                        <?php echo $alumno[1]. " " . $alumno[2] ?>
                                    </td>
                                    <td class="mifuente micolor minegrita miversalita">
                                        <?php echo $alumno["grupo"] ?>
                                    </td>
                                    <td >
                                        <form  method="post"  action="expulsiones_pendientes.php">
                                            <input type="hidden" name="codigo_expulsion" value="<?php echo $alumno['matricula'] ?>">
                                            <button type="submit" class="btn btn-sx micolor btn-primary miversalita"
                                                    name="enviar_codigo">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true">
                                                    ver
                                                </span>
                                            </button>  
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <h4 class="mifuente minegrita mimargen micolor miversalita">
                    No hay expulsiones pendientes.
                </h4>
            <?php } ?>
        </div>
    </div>
</div>
<?php
Conexion::cerrarConexion();

include_once("plantillas/pie.inc.php");
?>


