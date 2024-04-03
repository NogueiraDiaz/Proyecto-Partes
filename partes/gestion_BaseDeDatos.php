<?php

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
include('MySqlBackup.php');

RepositorioSesion::iniciarSesion();

if (isset($_POST["copia_datos"])) {
Conexion::abrirConexion();
//$cont = file_get_contents("copia_base_datos.php"); 
//echo $cont;
$arrayDbConf['host'] = SERVIDOR;
$arrayDbConf['user'] = USUARIO;
$arrayDbConf['pass'] = PASSWORD;
$arrayDbConf['name'] = BASE_DATOS;
$nombreArchivo = "CopiaBaseDatosPartesJulioVerne.sql";
try {
 
    $bck = new MySqlBackupLite($arrayDbConf);
    $bck->setFileName($nombreArchivo);
    $bck->backUp();
    $bck->downloadFile();
    Conexion::cerrarConexion();
  }
  catch(Exception $e) {
    echo $e;
    Conexion::cerrarConexion();
  }

    
}
if (isset($_POST["borrado_datos"])) {
  header("Location: advertencia_borrado.php");
}
?>  

<div class="container">
    <br>
    <br>
    <br>
    <div class="row mifondoGlow">
        <h3 class="text-center mifondo miversalita micoloretiqueta 
            mipaddingtitulo">Selección tipo de acción</h3>
        <form class="center-block mipadding" method="post" action="<?php $_SERVER["PHP_SELF"] ?>">
            <div class="row"> 
                <div class="col-md-4 col-md-offset-2"> 
                    <button class="btn btn-lg btn-success btn-block miversalita mimargensuperior15" 
                            type="submit" name="copia_datos">COPIA de datos </button>
                </div>
                <div class="col-md-4  "> 
                    <button title="CUIDADO" class=" btn  btn-lg btn-danger btn-block miversalita mimargensuperior15" 
                            type="submit" name="borrado_datos">BORRADO de datos</button>                            
                </div>
            </div>
        </form>
    </div>
</div>

<?php
include_once "plantillas/pie.inc.php";
?>

