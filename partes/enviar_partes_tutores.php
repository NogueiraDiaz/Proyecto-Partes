<?php
include_once "app/RepositorioSesion.inc.php";

include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";
include_once "app/RepositorioAlumno.inc.php";

include_once "app/Conexion.inc.php";

if (isset($_POST["generar"])) {
        $_SESSION["fecha_inicio"] = $_POST["fecha_inicio"];
        $_SESSION["fecha_fin"] = $_POST["fecha_fin"];
    ?>   
    <div class="container">
        <br>
        <div class="row mifondo mitama miversalita" >
            <h3 class="text-center mifondo miversalita micolor mipaddingtitulo">
                Generación partes tutores.
            </h3>
            <div class="panel-body text-center">
                <div class="row">
                    <h4 class="text-center mitexto micolor mimargensuperior">
                        Se van a generar los partes para 
                        <span style="color:orangered"> 
                            todos
                        </span>
                        los tutores entre 
                        <span style="color:orangered"> 
                            <?php echo $_POST["fecha_inicio"] ?>
                        </span>
                        y
                        <span style="color:orangered"> 
                            <?php echo $_POST["fecha_fin"] ?>
                        </span>
                    </h4>
                    <div class="col-md-4 col-md-offset-2 "> 
                        <a href="enviar_partes_tutores.php" class="btn btn-lg btn-success 
                           btn-block miversalita mimargensuperior15">
                            Volver
                        </a>
                    </div>
                    <div class="col-md-4"> 
                        <a href="generar_pdf_partes_tutores.php" class="btn btn-lg btn-success 
                           btn-block miversalita mimargensuperior15">
                            Generar partes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else {
    ?>
    <div class="container">
        <div class="col-md-12"> 
            <div class="panel panel-default" >
                <div class="panel-heading" >
                    <h3 class="text-center mifuente minegrita miversalita micoloretiqueta ">
                        Generación de partes para correos de Tutores
                    </h3>
                </div>
                <div class="panel-body">
                    <form class=" mipadding form-inline" method="post" action="<?php $_SERVER["PHP_SELF"] ?>">
                        <?php $time = time(); ?>

                        <div class="form-group">     	
                            <label class="miversalita mipadding micoloretiqueta ">
                                Fecha inicio
                            </label> 
                            <input class="form-control" type="text" name="fecha_inicio" 
                                   value=" <?php echo date("d-m-Y", $time); ?>">
                        </div>

                        <div class="form-group">     	
                            <label class="miversalita mipadding micoloretiqueta ">
                                Fecha fin 
                            </label> 
                            <input class="form-control" type="text" name="fecha_fin" 
                                   value=" <?php echo date("d-m-Y", $time); ?>">
                        </div>  

                        <div class="form-group" >     	
                            <button class="btn btn-success  text-right miversalita 
                                    mimargenizquierdo" type="submit" name="generar">
                                Generar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}
include_once("plantillas/pie.inc.php");
?>




