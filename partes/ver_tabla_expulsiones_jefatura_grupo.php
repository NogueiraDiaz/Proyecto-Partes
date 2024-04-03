<?php
include_once "app/RepositorioSesion.inc.php";

include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";

include_once "app/Conexion.inc.php";

include_once "app/RepositorioParte_Expulsion.inc.php";

Conexion::abrirConexion();

// Obtengo los partes del alumno que se ha seleccionado
$expulsiones_grupo = RepositorioParte_Expulsion::getPartesExpulsionAlumnosGrupo
                (Conexion::getConexion(), $_SESSION["grupo"]);
                echo print_r($expulsiones_grupo);

Conexion::cerrarConexion();
?>

<div class="container">
    <div class="col-md-12 text-right"> 
            <a href="ver_expulsiones_jefatura_grupo.php" class="btn btn-success miversalita "> 
            <span class="glyphicon glyphicon-menu-left" aria-hidden="true">
                Volver
            </span>
        </a>
    </div> 
    <br> <br>

    <div class="col-md-12"> 
        <div class="panel panel-default mifondoGlow" >
            <div class="panel-heading" >
                <h3 class="text-center mifuente minegrita miversalita micoloretiqueta ">
                    <?php
                    echo "Expulsiones del grupo: " . $_SESSION["grupo"];
                    ?>
                </h3>
            </div>
            <?php if (empty($expulsiones_grupo)) { ?>
                <h4 class="mifuente minegrita mimargen micolor miversalita">
                    No hay expulsiones. 
                </h4>
            <?php } else {
                ?>

                <div class="panel-body">
                    <table class="table table-responsive">
                        <?php
                        $cod_expulsion = -1;
                        foreach ($expulsiones_grupo as $expulsion) {
                            if ($cod_expulsion != $expulsion["cod_parte_expulsion"]) {
                                ?>
                                 <tr class ="mifondo">
                                    <td colspan="3" class="mifuente  micoloretiqueta minegrita">
                                        <span class="  micolor minegrita">Alumno: </span>
                                        <?php echo $expulsion["nombreAlumno"]. " ". $expulsion["apellidosAlumno"]; ?>
                                    </td>
                                    <td colspan="2" class="mifuente  micoloretiqueta minegrita">
                                        <span class="micolor minegrita">Fecha Inicio: </span>
                                        <?php echo date("d-m-Y", strtotime($expulsion["fecha_Inicio"])); ?>
                                        <span class="micolor minegrita">- Fecha Finalización: </span>
                                        <?php echo date("d-m-Y", strtotime($expulsion["fecha_Fin"])); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="mifuente  micoloretiqueta minegrita">Profesor</th>
                                    <th class="mifuente  micoloretiqueta minegrita">fecha</th>
                                    <th class="mifuente  micoloretiqueta minegrita">Incidencia</th>
                                    <th class="mifuente  micoloretiqueta minegrita">Puntos</th>
                                    <th class="mifuente  micoloretiqueta minegrita">Acciones</th>
                                </tr>

                                <?php
                                $cod_expulsion = $expulsion["cod_parte_expulsion"];
                            }
                            ?>
                            <tbody>
                                <tr>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo $expulsion["nombreProfesor"] . " " . $expulsion["apellidosProfesor"] ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo date("d-m-Y", strtotime($expulsion["fecha"])); ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo $expulsion["incidencia"] ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo $expulsion["puntos"] ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <form  method="post"  action="<?php $_SERVER['PHP_SELF'] ?>">
                                            <input type="hidden" name="codigo_parte" value="<?php echo $expulsion["cod_parte_expulsion"] ?>">
                                            <button type="submit" class="btn btn-sx micolor btn-primary miversalita" 
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




