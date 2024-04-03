<?php
include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";

include_once "app/RepositorioAlumno.inc.php";
include_once "app/RepositorioParte_Expulsion.inc.php";
include_once "app/RepositorioGrupo.inc.php";

include_once "app/Conexion.inc.php";

Conexion::abrirConexion();
$_SESSION["grupos"] = RepositorioGrupo::getGrupos(Conexion::getConexion());
if (isset($_POST["buscar_expulsiones_grupo"])) {
   $_SESSION["grupo"]=$_POST["grupo"]; 
   header("Location: ver_tabla_expulsiones_jefatura_grupo.php");
}

Conexion::cerrarConexion();
?>

<div class="container">
    <div class="row mifondoGlow">
        <h3 class='text-center mifondo miversalita micoloretiqueta mipaddingtitulo'>
            Selección datos busqueda grupo 
        </h3>
        <div class="col-md-6"> 
            <form class=" mipadding form-inline" method="post" action="<?php $_SERVER["PHP_SELF"] ?>">
                <div class="form-group">     	
                    <label class="miversalita micolor">Grupo: </label> 
                    <div class="form-group">
                        <select class="form-control" name="grupo">
                            <option value="" disabled selected>Grupo del alumno</option>
                            <?php

    foreach ($_SESSION["grupos"] as $alu) {

    echo "<option>" . $alu["grupo"] ."</option>";
    }
        ?>
						</select>
                    </div>
                </div>

                <div class="form-group" >     	
                    <button class="btn btn-success  miversalita mimargenizquierdo" type="submit" name="buscar_expulsiones_grupo">
                        <span class="glyphicon glyphicon-search" aria-hidden="true">
                            Buscar
                        </span>
                    </button>
                </div>
            </form> 
        </div>

    </div> 
    <?php
    //include_once "plantillas/formulario_consultas_expulsion_jefatura_grupo.inc.php";
    ?>
</div>

<?php
include_once("plantillas/pie.inc.php");
?>




