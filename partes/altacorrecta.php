<?php
include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";
?>
<div class="container">
    <br>
    <div class="row mifondo mitama miversalita" >
        <h3 class="text-center mifondo miversalita micolor mipaddingtitulo">
            <?php if (isset($_SESSION["acceso_no_validado"])) { ?>
                Estas intentando acceder sin activar tu cuenta.
            <?php } else { ?>
                Alta correcta.
            <?php } ?>
        </h3>
        <div class="panel-body text-center">
            <div class="row">
                <h4 class="text-center mitexto micolor mimargensuperior">
                    <?php if (isset($_SESSION["acceso_no_validado"])) { ?>
                    <div style="color:orangered"> 
                        Para poder acceder a la aplicación debes activar tu cuenta en jefatura de estudios.
                    </div>
                    <?php 
                    } else { ?>
                    Tu cuenta ha sido creada correctamente, pero no está activa. 
                    <br> <br>
                    <div style="color:orangered"> 
                        Para poder acceder a la aplicación debes activar tu cuenta en jefatura de estudios.
                    </div>
                    <?php } ?>
                </h4>
                <div class="col-md-4 col-md-offset-4 "> 
                    <a href="index.php" class="btn btn-lg btn-success 
                       btn-block miversalita mimargensuperior15">
                        Continuar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once("plantillas/pie.inc.php");
?>


