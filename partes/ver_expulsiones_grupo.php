<?php
include_once "app/RepositorioSesion.inc.php";
include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";
include_once "app/Conexion.inc.php";
include_once "app/RepositorioParte_Expulsion.inc.php";
Conexion::abrirConexion();
$expulsiones_alumno = RepositorioParte_Expulsion::getExpulsionesGrupo
                (Conexion::getConexion(), $_SESSION["usuario_login"]["tutor_grupo"]);
Conexion::cerrarConexion();
?>

<div class="container">
    <div class="col-md-12"> 
        <div class="panel panel-default" >
            <div class="panel-heading" >
                <h3 class="text-center mifuente minegrita miversalita micoloretiqueta ">
                    <?php
                    echo "Expulsiones del grupo " . $_SESSION["usuario_login"]["tutor_grupo"]
                    ?>
                </h3>
            </div>
            <?php if (empty($expulsiones_alumno)) { ?>
                <h4 class="mifuente minegrita mimargen micolor miversalita">
                    No hay expulsiones. 
                </h4>
            <?php } else { ?>
                <div class="panel-body">
                    <table class="table table-responsive">
                        <?php foreach ($expulsiones_alumno as $parte) { ?>
							<tr class ="mifondo">
                            	<td colspan="3" class="mifuente  micoloretiqueta minegrita">
                                	<span class="   micolor minegrita">Alumno: </span>
                                    	<?php echo $parte["nombre"]. " ". $parte["apellidos"]; ?>
                                </td>
                                <td colspan="2" class="mifuente  micoloretiqueta minegrita">
                                    <span class="micolor minegrita">Fecha Inicio: </span>
                                    <?php echo date("d-m-Y", strtotime($parte["fecha_Inicio"])); ?>
                                    <span class="micolor minegrita">- Fecha Finalización: </span>
                                	<?php echo date("d-m-Y", strtotime($parte["fecha_Fin"])); ?>
                            	</td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php
if (isset($_POST['ver'])) {
    Conexion::abrirConexion();
    $datos_parte = RepositorioParte_Expulsion::getDatosParteExpulsion
                    (Conexion::getConexion(), $_POST["codigo_parte"]);
    Conexion::cerrarConexion();
    include_once("plantillas/datos_parte.inc.php");
}
include_once("plantillas/pie.inc.php");
?>




