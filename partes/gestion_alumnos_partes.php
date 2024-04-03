<?php
include_once "app/RepositorioSesion.inc.php";

include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";

include_once "app/Conexion.inc.php";

include_once "app/Parte.inc.php";
include_once "app/RepositorioParte.inc.php";
include_once "app/RepositorioParte_Expulsion.inc.php";
include_once "app/RepositorioExpulsion.inc.php";


Conexion::abrirConexion();

// Obtenemos los valores reales de la clave del alumno
$matricula = explode(".", $_SESSION["cod_alumno"])[0];
$grupo = explode(".", $_SESSION["cod_alumno"])[1];

if (isset($_POST['guardar_parte'])) {
    $_SESSION["mispartes"] = 1;
    $_SESSION["codigo_parte"] = $_POST["codigo_parte"];
    header("Location: generar_pdf_mispartes.php");
}

if (isset($_POST['guardar_parte_expulsion'])) {
    $_SESSION["mispartes_expulsion"] = 1;
    $datos = explode("-", $_POST["datos"]);
    $_SESSION["codigo_parte"] = $datos[0];
    header("Location: generar_pdf_mispartes.php");
}

if (isset($_POST["borrar"])) {
    // borro el parte que se ha seleccionado
    RepositorioParte::borrarParteCodigoTodo(Conexion::getConexion(), $_POST["codigo_parte"]);
	// Recalculamos la expulsion actual
	RepositorioExpulsion::recalcExpulsionAlumno(Conexion::getConexion(), $matricula);
    header("Location: gestion_alumnos_partes.php");
}
if (isset($_POST["caducar"])){
	// No esta terminada la funcion de recalcular expulsion asiqeu deshabiolito el boton demomento
	// Botón para caducar el parte seleccionado
	RepositorioParte::CaducarParte(Conexion::getConexion(), $_POST["codigo_parte"]);
	print "Solo caducado";
	// Recalculamos la expulsion actual
	RepositorioExpulsion::recalcExpulsionAlumno(Conexion::getConexion(), $matricula);
	// header("Location: gestion_alumnos_partes.php");
	print "Caducado y recalculado";
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
                    $parte_borrar["dNI"], $parte_borrar["matricula"]
                    , $parte_borrar["incidencia"], $parte_borrar["materia"]
                    , $parte_borrar["fecha"], $parte_borrar["hora"]
                    , $parte_borrar["puntos"], $parte_borrar["descripcion"]
                    , $parte_borrar["fecha_Comunicacion"]
                    , $parte_borrar["via_Comunicacion"]);

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

    header("Location: gestion_alumnos_partes.php");
}

// Obtengo los partes del alumno que se ha seleccionado

$partes_alumno = RepositorioParte::getPartesAlumnoCodigo
                (Conexion::getConexion(), $matricula, $grupo);
/*$partes_alumno_expulsion = RepositorioParte_Expulsion::getPartesExpulsionAlumnos
                (Conexion::getConexion(), $matricula);*/
Conexion::cerrarConexion();
?>

<div class="container">
    <div class="col-md-12 text-right"> 
        <?php if (isset($_SESSION["jefatura"])) { ?>
            <a href="ver_partes_jefatura_alumno.php" class="btn btn-success miversalita "> 
                <?php
                unset($_SESSION["jefatura"]);
            } else {
                ?>   
                <a href="ver_partes_jefatura_alumno.php" class="btn btn-success miversalita ">
                <?php } ?>   

                <span class="glyphicon glyphicon-menu-left" aria-hidden="true">
                    Volver
                </span>
            </a>
    </div> 

    <br> <br>

    <div class="col-md-12"> 
        <div class="panel panel-default" >
            <div class="panel-heading" >
                <h3 class="text-center mifuente minegrita miversalita micoloretiqueta ">
                    <?php
                    if ($partes_alumno[0][0] != "") {
                        echo "Partes del alumno: " . $partes_alumno[0][0]
                        . " " . $partes_alumno[0][1];
                    } /*else {
                        echo "Partes del alumno: " . $partes_alumno_expulsion[0]["NombreAlumno"]
                        . " " . $partes_alumno_expulsion[0]["ApellidosAlumno"];
                    }*/
                    ?>
                </h3>
            </div>
            <?php if (empty($partes_alumno) ){ ?>
                <h4 class="mifuente minegrita mimargen micolor miversalita">
                    Actualmente no hay ningun parte. 
                </h4>
            <?php } else {
                ?>
                <div class="panel-body">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th class="mifuente  micoloretiqueta minegrita">Profesor</th>
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
                                            <!--<button type="submit" class="btn btn-sx micolor btn-primary miversalita" 
                                                    name="guardar_parte">
                                                <span class="glyphicon glyphicon-save" aria-hidden="true">
                                                    pdf
                                                </span>
                                            </button> -->
                                            <button type="submit" class="btn btn-danger micolor miversalita" 
                                                    name="borrar">
                                                <span class="glyphicon glyphicon-trash" aria-hidden="true">
                                                    Borrar
                                                </span>
                                            </button> 
											<button style="visibility: <?php if($parte["caducado"] > 1){echo "Hidden";}else{echo "Visible";}?>;" type="submit" class="btn btn-danger micolor miversalita"
													name="caducar">
  												🪧Caducar
											</button>
                                        </form>
                                    </td>
                                </tr>    
                            <?php }
                            ?>

                            <?php
                            /*foreach ($partes_alumno_expulsion as $parte) {
                                ?>
                                <tr>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo $parte["Nombre"] . " " . $parte["Apellidos"] ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">

                                        <?php echo date("d-m-Y", strtotime($parte["Fecha_Insercion"])); ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo $parte["Incidencia"] ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo $parte["Puntos"] ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <form  method="post"  action="<?php $_SERVER['PHP_SELF'] ?>">
                                            <input type="hidden" name="datos" 
                                                   value="<?php
                                                   echo $parte["cod_parte"]
                                                   ?>">
                                            <button type="submit" class="btn micolor btn-primary miversalita" 
                                                    name="ver_parte_expulsion">
                                                <span class="glyphicon glyphicon-eye-open" aria-hidden="true">
                                                    Ver
                                                </span>
                                            </button> 
                                            <button type="submit" class="btn btn-sx micolor btn-primary miversalita" 
                                                    name="guardar_parte_expulsion">
                                                <span class="glyphicon glyphicon-save" aria-hidden="true">
                                                    pdf
                                                </span>
                                            </button>
                                            <?php if ($parte["Fecha_Inicio"] == "0000-00-00") { ?>
                                                <button type="submit" class="btn btn-sx micolor btn-danger miversalita" 
                                                        name="borrar_parte_expulsion">
                                                    <span class="glyphicon glyphicon-trash" aria-hidden="true">
                                                        Borrar
                                                    </span>
                                                </button> 
                                            <?php } ?> 
                                        </form>
                                    </td>
                                </tr>    
                            <?php } */?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
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
                        (Conexion::getConexion(), $matricula);
    }
    Conexion::cerrarConexion();

    //muestro la información del parte seleccionado
    include_once("plantillas/datos_parte.inc.php");
}

include_once("plantillas/pie.inc.php");
?>



