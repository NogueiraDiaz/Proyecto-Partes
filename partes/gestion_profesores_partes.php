<?php
include_once "app/RepositorioSesion.inc.php";

include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";

include_once "app/Conexion.inc.php";

include_once "app/RepositorioParte.inc.php";
include_once "app/Parte.inc.php";

Conexion::abrirConexion();

// Obtengo los partes del profesor que se ha seleccionado
$partes_profesor = RepositorioParte::getPartesProfesor
                (Conexion::getConexion(), $_SESSION["cod_profesor"]);
Conexion::cerrarConexion();
?>


<div class="container">
    <div class="col-md-12 text-right"> 
        <a href="gestion_alumnos.php" 
           class="btn btn-success miversalita ">
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
                    echo "Partes del Profesor: "  .$partes_profesor[0]["nom_profesor"]
                    . " " . $partes_profesor[0]["ape_profesor"];
                    ?>
                </h3>
            </div>
            <div class="panel-body">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th class="mifuente  micoloretiqueta minegrita">Alumno</th>
                            <th class="mifuente  micoloretiqueta minegrita">Grupo</th>
                            <th class="mifuente  micoloretiqueta minegrita">Fecha</th>
                            <th class="mifuente  micoloretiqueta minegrita">Incidencia</th>
                            <th class="mifuente  micoloretiqueta minegrita">Puntos</th>
                            <th class="mifuente  micoloretiqueta minegrita">Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($partes_profesor as $parte) { ?>
                            <tr>
                                <td class="mifuente micolor minegrita">
                                    <?php echo $parte["nom_alumno"] . " " . $parte["ape_alumno"] ?>
                                </td>
                                <td class="mifuente micolor minegrita">
                                    <?php echo $parte["grupo_alumno"]?>
                                </td>
                                <td class="mifuente micolor minegrita">
                                    <?php echo date("d-m-Y", strtotime($parte["fecha_parte"])); ?>
                                </td>
                                <td class="mifuente micolor minegrita">
                                    <?php echo $parte["nom_incidencia"] ?>
                                </td>
                                <td class="mifuente micolor minegrita">
                                    <?php echo $parte["puntos_parte"] ?>
                                </td>
                                <td class="mifuente micolor minegrita">
                                   <form  method="post"  action="<?php $_SERVER['PHP_SELF'] ?>">
                                        <input type="hidden" name="codigo_parte" value="<?php echo $parte["cod_parte"] ?>">
                                        <button type="submit" class="btn btn-sx micolor btn-primary btn-success miversalita" 
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
    ?>
    <div class="container">
        <br>
        <div class="row mifondo">
            <h3 class="text-center mifondo miversalita micoloretiqueta mipaddingtitulo">
                Datos parte. 
            </h3>
            <?php
            RepositorioSesion::iniciarSesion();
            echo "<div class = 'row col-md-12'> ";
            RepositorioSesion::mostrarDatosSesion("Profesor", 
                    ($datos_parte["nom_profesor"] . " ". $datos_parte["ape_profesor"]));
            echo "</div>";

            echo "<div class = 'row col-md-4'> ";
            RepositorioSesion::mostrarDatosSesion("Alumno", 
                    ($datos_parte["nom_alumno"] . " ". $datos_parte["ape_alumno"]));
            echo "</div>";
            echo "<div class = 'col-md-8'> ";
            RepositorioSesion::mostrarDatosSesion("Grupo", $datos_parte["grupo_alumno"]);
            echo "</div>";

            echo "<div class = 'row col-md-4'> ";
            RepositorioSesion::mostrarDatosSesion("Fecha parte incidencia",$datos_parte["fecha_parte"]);
            echo "</div>";
            echo "<div class = 'col-md-8'> ";
            RepositorioSesion::mostrarDatosSesion("Hora", $datos_parte["hora_parte"]);
            echo "</div>";

            echo "<div class = 'row col-md-12'> ";
            RepositorioSesion::mostrarDatosSesion("Materia", $datos_parte["materia_parte"]);
            echo "</div>";

            if ($_SESSION["identificador_parte"] == "incidencia") {
                echo "<div class = 'row col-md-4'> ";
                RepositorioSesion::mostrarDatosSesion("Incidencia", $datos_parte["nom_incidencia"]);
                echo "</div>";
                echo "<div class = 'col-md-8'> ";
                RepositorioSesion::mostrarDatosSesion("Puntos", $datos_parte["puntos_parte"]);
                echo "</div>";
            }

            echo "<div class = 'row col-md-12'> ";
            RepositorioSesion::mostrarDatosSesion("Descripcion", utf8_encode($datos_parte["descripcion_profesor"]));
            echo "</div>";

            echo "<div class = 'row col-md-4'> ";
            RepositorioSesion::mostrarDatosSesion("Medio Comunicación", $datos_parte["via_comunicacion_familia"]);
            echo "</div>";
            echo "<div class = 'col-md-8'> ";
            RepositorioSesion::mostrarDatosSesion("Fecha Comunicación", $datos_parte["fecha_parte"]);
            echo "</div>";
            ?> 
        </div>    
    </div>

<?php } 
include_once("plantillas/pie.inc.php");
?>






