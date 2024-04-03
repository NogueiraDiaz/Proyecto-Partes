<?php
include_once "app/RepositorioSesion.inc.php";

include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";

include_once "app/Conexion.inc.php";
include_once "app/RepositorioParte.inc.php";
include_once "app/RepositorioParte_Expulsion.inc.php";
include_once "app/RepositorioExpulsion.inc.php";

Conexion::abrirConexion();

if (isset($_POST['borrar'])) {

    // borro el parte que se ha seleccionado
    RepositorioParte::borrarParteCodigo
            (Conexion::getConexion(), $_POST["codigo_parte"]);
}

if (isset($_POST['borrar_parte_expulsion'])) {
    // separo la cadena 0->cod_parte_expulsion 1->cod_expulsion
    $datos_borrado = explode("-", $_POST["datos"]);

    // borro el parte que se ha seleccionado
    RepositorioParte_Expulsion::borrarParteCodigo(Conexion::getConexion(), $datos_borrado[0]);

    if ($valor = RepositorioParte_Expulsion::sumarPuntosPartesExpulsion(Conexion::getConexion()
                    , $datos_borrado[1]) < 10) {

        // vuelvo a realizar la consulta para que no me salgan los que he borrado
        $partes_expulsion_borrar = RepositorioParte_Expulsion::getPartesExpulsion
                        (Conexion::getConexion(), $datos_borrado[1]);

        // paso los partes de la tabla expulsiones_parte a la tabla de partes
        // y los borro de la tabla de expulsiones parte
        foreach ($partes_expulsion_borrar as $parte_borrar) {
            // creo un objeto parte
            $parte_aux = new Parte(
                    $parte_borrar["cod_profesor"], $parte_borrar["cod_alumno"]
                    , $parte_borrar["cod_incidencia"], $parte_borrar["materia_parte"]
                    , $parte_borrar["fecha_parte"], $parte_borrar["hora_parte"]
                    , $parte_borrar["puntos_parte"], $parte_borrar["descripcion_profesor"]
                    , $parte_borrar["fecha_comunicacion_familia"]
                    , $parte_borrar["via_comunicacion_familia"]);

            // Añado el nuevo parte a la tabla de partes
            RepositorioParte::nuevoParte(Conexion::getConexion(), $parte_aux);

            //borro el parte de la tabla de expulsiones partes
            RepositorioParte_Expulsion::borrarParteCodigo(Conexion::getConexion()
                    , $parte_borrar["cod_parte_expulsion"]);
        }

        // borro la expulsion
        RepositorioExpulsion::borrarExpulsionCodigo(Conexion::getConexion()
                , $datos_borrado[1]);
    }

    // compruebo que los partes retantes sumen 10 puntos, si no suma 10 puntos significa que se quiere
    // quitar la expulsión y los tengo que pasar todos a la tabla de partes

    header("Location: ver_mis_partes.php");
}


// Obtengo los partes del profesor que se ha seleccionado
$partes_profesor = RepositorioParte::getPartesProfesor
                (Conexion::getConexion(), $_SESSION["usuario_login"]["dni"]);
/*$partes_profesor_expulsion = RepositorioParte_Expulsion::getPartesProfesor
                (Conexion::getConexion(), $_SESSION["codigo_profesor"]);*/

Conexion::cerrarConexion();
?>

<div class="container">
    <div class="col-md-12"> 
        <div class="panel panel-default" >
            <div class="panel-heading" >
                <h3 class="text-center mifuente minegrita miversalita micoloretiqueta ">
                    Mis partes.
                </h3>
            </div>
            <?php if (empty($partes_profesor) ) { ?>
                <h4 class="mifuente minegrita mimargen micolor miversalita">
                    Actualmente no hay ningún parte. 
                </h4>
            <?php } else {
                ?>
                <div class="panel-body">
                    <table class=" table table-responsive">
                        <thead>
                            <tr>
                                <th class="mifuente  micoloretiqueta minegrita">Alumno</th>
                                <th class="mifuente  micoloretiqueta minegrita">Grupo</th>
                                <th class="mifuente  micoloretiqueta minegrita">Fecha</th>
                                <th class="mifuente  micoloretiqueta minegrita">Incidencia</th>
                                <th class="mifuente  micoloretiqueta minegrita">Puntos</th>
                                <th class="mifuente  micoloretiqueta minegrita">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($partes_profesor as $parte) {
                                ?>
                                <tr>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo $parte["aNombre"] . " " . $parte["aApellidos"] ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo $parte["grupo"] ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo date("d-m-Y", strtotime($parte["fecha"])); ?>
                                    </td>
                                    <td class="mifuente micolorparte minegrita">
                                        <?php echo $parte["incidencia"] ?>
                                    </td>
                                    <td class="mifuente micolorparte minegrita">
                                        <?php echo $parte["puntos"] ?>
                                    </td>
                                    <td class="mifuente  minegrita">
                                        <form  method="post"  action="<?php $_SERVER['PHP_SELF'] ?>">
                                            <input type="hidden" name="codigo_parte" value="<?php echo $parte["cod_parte"] ?>">
                                            <input type="hidden" name="matricula" value="<?php echo $parte["matricula"] ?>">

                                            <button type="submit" class="btn btn-sx micolor btn-primary miversalita" 
                                                    name="ver">
                                                <span class="glyphicon glyphicon-eye-open" aria-hidden="true">
                                                    Ver
                                                </span>
                                            </button> 
                                            <button type="submit" class="btn btn-sx micolor btn-danger miversalita" 
                                                    name="borrar">
                                                <span class="glyphicon glyphicon-trash" aria-hidden="true">
                                                    Borrar
                                                </span>
                                            </button> 
                                        </form>
                                    </td>
                                </tr>    
                                <?php
                            }

                             ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['ver']) || isset($_POST["ver_parte_expulsion"])) {
    // separo la cadena 0->cod_parte_expulsion 1->cod_expulsion
    //$datos_ver = explode("-", $_POST["datos"]);
    Conexion::abrirConexion();
    //cargo los datos del parte que corresponda
    if (isset($_POST['ver'])) {
        $datos_parte = RepositorioParte::getDatosParte
                        (Conexion::getConexion(), $_POST["codigo_parte"]);
    } else {
        $datos_parte = RepositorioParte_Expulsion::getDatosParteExpulsion
                        (Conexion::getConexion(), $_POST["matricula"]);
    }

    //muestro la información del parte seleccionado
    include_once("plantillas/datos_parte.inc.php");
}
Conexion::cerrarConexion();
include_once("plantillas/pie.inc.php");
?>







