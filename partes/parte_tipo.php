<?php

session_start();
if(!isset($_SESSION["usuario_login"])){
    header("Location: ../index.php?redirigido=true");
};

include_once "app/RepositorioSesion.inc.php";
RepositorioSesion::borrarDatosSesion();

include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";


include_once"app/Conexion.inc.php";

include_once"app/RepositorioProfesor.inc.php";
include_once"app/Profesor.inc.php";

include_once "app/RepositorioAlumno.inc.php";
include_once "app/Alumno.inc.php";

include_once "app/ValidarParte.inc.php";

RepositorioSesion::iniciarSesion();

if (isset($_POST["parte_incidencia"])) {
    
    $_SESSION["tipo_parte"] = 0;
    $_SESSION["identificador_parte"] = "incidencia";
    header("Location: parte_grupo.php");
}
if (isset($_POST["parte_convivencia"])) {
    $_SESSION["tipo_parte"] = 1;
    $_SESSION["identificador_parte"] = "convivencia";
    // registro de incidencia especial para los partes de convivencia, con 0 puntos
    $_SESSION["codigo_incidencia"] = 0;
    $_SESSION["puntos_incidencia"] = 0;
    header("Location: parte_grupo.php");
}
?>  

<div class="container">
    <div class="row mifondoGlow">
        <h3 class="text-center mifondo miversalita micoloretiqueta 
            mipaddingtitulo">Selección tipo de parte</h3>
        <form class="center-block mipadding" method="post" action="<?php $_SERVER["PHP_SELF"] ?>">
            <div class="row">
                <div class="col-md-4 col-md-offset-2 "> 
                    <button title="Los partes de convivencia ya no están disponibles" disabled class="tooltip1 btn  btn-lg btn-danger btn-block miversalita mimargensuperior15" 
                            type="submit" name="parte_convivencia">Parte Convivencia
                            <span class="tooltip1 tooltiptext">
                                Tipo no disponible
                             </span>
                     </button><!--Este boton y su funcionalidad estan deshabilitados-->                            
                </div>
                <div class="col-md-4 "> 
                    <button class="btn btn-lg btn-success btn-block miversalita mimargensuperior15" 
                            type="submit" name="parte_incidencia">Parte Incidencia</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
include_once "plantillas/pie.inc.php";
?>


