<?php
include_once "app/RepositorioSesion.inc.php";

include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";
include_once "app/RepositorioAlumno.inc.php";

include_once "app/Conexion.inc.php";

Conexion::abrirConexion();

if (isset($_POST["buscar_partes_fecha"])) {
    $_SESSION["fecha_inicio"] = $_POST["fecha_inicio"];
    $_SESSION["fecha_fin"] = $_POST["fecha_fin"];
    header("Location: ver_tabla_partes_jefatura_fecha.php");
}
?>

<div class="container">
    <div class="row mifondoGlow">
        <h3 class='text-center mifondo miversalita micoloretiqueta mipaddingtitulo'>
            Selección de datos busqueda de partes por fecha
        </h3>
        <form class=" mipadding form-inline" method="post" action="<?php $_SERVER["PHP_SELF"] ?>">
            <?php $time = time(); ?>

            <div class="form-group">     	
                <label class="miversalita mipadding micolor ">
                    Fecha inicio
                </label> 
                <input class="form-control" type="text" name="fecha_inicio" 
                       value=" <?php echo date("d-m-Y", $time); ?>">
            </div>

            <div class="form-group">     	
                <label class="miversalita mipadding micolor ">
                    Fecha fin 
                </label> 
                <input class="form-control" type="text" name="fecha_fin" 
                       value=" <?php echo date("d-m-Y", $time); ?>">
            </div>  

            <div class="form-group" >     	
                <button class="btn btn-success  text-right miversalita 
                        mimargenizquierdo" type="submit" name="buscar_partes_fecha">
                    Buscar
                </button>
            </div>
        </form>
    </div>
</div>
<?php
Conexion::cerrarConexion();
include_once("plantillas/pie.inc.php");
?>





