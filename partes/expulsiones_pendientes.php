<?php
include_once "app/RepositorioSesion.inc.php";

include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";

include_once "app/Conexion.inc.php";
include_once "app/RepositorioParte_Expulsion.inc.php";

include_once "app/RepositorioExpulsion.inc.php";
include_once "app/Expulsion.inc.php";

RepositorioSesion::iniciarSesion();

Conexion::abrirConexion();

//lo guardo en una variable de sesion para poder utilizarlo cuando selecciona la fecha
// ya que el valor del POST se pierde
if ($_POST["codigo_expulsion"] != "") {
    $_SESSION["cod_expulsion"] = $_POST["codigo_expulsion"];
}

$partes_expulsion = RepositorioParte_Expulsion::get_Expulsiones_Codigo
                (Conexion::getConexion(), $_SESSION["cod_expulsion"]);


if (isset($_POST["expulsion"])) {
	
    RepositorioExpulsion::anadirfechaExpulsion(Conexion::getConexion()
            , $_SESSION["cod_expulsion"], $_POST["fecha_ini"], $_POST["fecha_fin"]);
	RepositorioParte_Expulsion::CaducarAlExpulsar(Conexion::getConexion(), $_SESSION["cod_expulsion"]);
    header("Location:index_admin.php");
}
Conexion::cerrarConexion();
?>

<div class="container">
    <div class="col-md-12"> 
        <div class="panel panel-default" >
            <div class="panel-heading" >
                <h3 class="text-center mifuente minegrita miversalita micoloretiqueta ">
                    Gestionar expulsión
                </h3>
            </div>
            <div class="panel-body">
                <form class=" mipadding form-inline" method="post" action="<?php $_SERVER["PHP_SELF"] ?>">
                    

                    <div class="form-group">     	
                        <label class="miversalita mipadding micoloretiqueta ">
                            Fecha inicio expulsión
                        </label> 
                        <input class="form-control" type="date" name="fecha_ini">
                    </div>

                    <div class="form-group">     	
                        <label class="miversalita mipadding micoloretiqueta ">
                            Fecha fin expulsión 
                        </label> 
                        <input class="form-control" type="date" name="fecha_fin"/>
                    </div>  

                    <div class="form-group" >     	
                        <button class="btn btn-danger text-right miversalita 
                                mimargenizquierdo" type="submit" name="expulsion">
                            Expulsar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="container">
    <div class="col-md-12"> 
        <div class="panel panel-default" >
            <div class="panel-heading" >
                <h3 class="text-center mifuente minegrita miversalita micoloretiqueta ">
                    <?php
                    echo "Partes del alumno: " . $partes_expulsion[0]["nombreAlumno"]
                    . " " . $partes_expulsion[0]["apellidosAlumno"];
                    ?>
                </h3>
            </div>
            <div class="panel-body">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th class="mifuente  micoloretiqueta minegrita">Profesor</th>
                            <th class="mifuente  micoloretiqueta minegrita">Fecha</th>
                            <th class="mifuente  micoloretiqueta minegrita">Incidencia</th>
                            <th class="mifuente  micoloretiqueta minegrita">Puntos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($partes_expulsion as $parte) { ?>
                            <tr>
                                <td class="mifuente micolor minegrita">
                                    <?php echo $parte["nombreProfesor"] . " " . $parte["apellidosProfesor"] ?>
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
                                        <!-- Concateno los campos cod_parte_expulsion y cod_expulsion para ahorrarme una
                                        consulta, luego lo separo-->
                                        <input type="hidden" name="datos" value="<?php
                                    echo $parte["matricula"]
                                    . "-" . $parte["fecha"]
                                    ?>">
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
include_once("plantillas/pie.inc.php");
?>



