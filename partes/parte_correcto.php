<?php
include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";
?>
<div class="container">
    <br>
    <div class="row mifondo mitama miversalita" >
        <h3 class="text-center mifondo miversalita micoloretiqueta mipaddingtitulo">
            El parte ha sido dado de alta correctamente
        </h3>
        <div class="panel-body text-center">
            <div class="row">
                <?php
                if (isset($_SESSION["expulsion"])) {
                    unset($_SESSION["expulsion"]);
                    ?>
                    <h4 class="text-center mitexto micolor mimargensuperior">
                        El alumno ha llegado a 10 puntos y se ha generado una expulsión.
                        <br> 
                        <br> 
                        Debes comunicar esta situación a jefatura de estudios.
                    </h4>
                <?php }
                    ?>
                </div>    
                <div class="row">
                    <div class="col-md-4 col-md-offset-2 "> 
                        <a href="parte_tipo.php" class="btn btn-lg btn-info
                           btn-block miversalita mimargensuperior15"> 
                            Finalizar
                        </a>
                    </div>
                </div>

                <div class="row">
                    <br>
                    <h5 class="text-center mitexto micoloretiqueta mimargensuperior">
                        No olvides guardar una copia del parte.
                    </h5>
                </div>
            </div>
        </div>
    </div>

    <?php
    
    include_once("plantillas/pie.inc.php");
    ?>


