<?php
include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";

include_once "app/RepositorioAlumno.inc.php";
include_once "app/RepositorioGrupo.inc.php";



include_once "app/Conexion.inc.php";

Conexion::abrirConexion();
$_SESSION["grupos"] = RepositorioGrupo::getGrupos(Conexion::getConexion());


if (isset($_POST["buscar_alumno_nombre"])) {
    $alumnos = RepositorioAlumno::getAlumnosNombreBusqueda(Conexion::getConexion()
                    , $_POST["nombre"]);
}

if (isset($_POST["buscar_alumno_apellidos"])) {
    $alumnos = RepositorioAlumno::getAlumnosApellidosBusqueda(Conexion::getConexion()
                    , $_POST["apellidos"]);
}

if (isset($_POST["buscar_alumno_grupo"])) {
    $alumnos = RepositorioAlumno::getAlumnosGrupo(Conexion::getConexion()
                    , $_POST["grupo"]);
}

if (isset($_POST["editar_alumno"])) {
    $_SESSION["cod_alumno"] = $_POST["alumno"];
    header("Location: gestion_alumnos_editar.php");
}
if (isset($_POST["partes_alumno"])) {
    $_SESSION["cod_alumno"] = $_POST["alumno"];
    header("Location: gestion_alumnos_partes.php");
}
if (isset($_POST["expulsiones_alumno"])) {
    $_SESSION["cod_alumno"] = $_POST["alumno"];
    header("Location: gestion_alumnos_expulsiones.php");
}

Conexion::cerrarConexion();
?>


<?php
if (isset($_SESSION["alta_ok"])) {
    RepositorioAlumno::mensajeEdicionAlumno($_SESSION["alta_ok"], "La contraseña ha sido cambiada correctamente.");
    unset($_SESSION["alta_ok"]);
}
if (isset($_SESSION["edicion_ok"])) {
    RepositorioAlumno::mensajeEdicionAlumno($_SESSION["edicion_ok"], "Los cambios se han realizado correctamente.");
    unset($_SESSION["edicion_ok"]);
}
?>
<div class="container">
    <div class="row mifondo">
        <h3 class='text-center mifondo miversalita micoloretiqueta mipaddingtitulo'>
            Selección datos busqueda alumno 
        </h3>


        <div class="col-md-3"> 
            <form class="center-block mipadding" method="post" action="<?php $_SERVER["PHP_SELF"] ?>">
                <div class="form-group">     	
                    <label class="miversalita micolor">Nombre: </label> 
                    <input class="form-control" type="text" name="nombre" placeholder="Nombre Alumno"> 
                </div>

                <div class="form-group row" >     	
                    <button class="btn btn-success  miversalita mimargenizquierdo" type="submit" name="buscar_alumno_nombre">
                        <span class="glyphicon glyphicon-search" aria-hidden="true">
                            Buscar
                        </span>
                    </button>
                </div>
            </form> 
        </div>

        <div class="col-md-3"> 
            <form class="center-block mipadding" method="post" action="<?php $_SERVER["PHP_SELF"] ?>">
                <div class="form-group">     	
                    <label class="miversalita micolor">Apellidos: </label> 
                    <input class="form-control" type="text" name="apellidos" 
                           placeholder="Apellidos Alumno"> 
                </div>

                <div class="form-group row" >     	
                    <button class="btn btn-success  miversalita mimargenizquierdo" type="submit" name="buscar_alumno_apellidos">
                        <span class="glyphicon glyphicon-search" aria-hidden="true">
                            Buscar
                        </span>
                    </button>
                </div>
            </form> 
        </div>

        <div class="col-md-3"> 
            <form class="center-block mipadding" method="post" action="<?php $_SERVER["PHP_SELF"] ?>">
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

                <div class="form-group row" >     	
                    <button class="btn btn-success  miversalita mimargenizquierdo" type="submit" name="buscar_alumno_grupo">
                        <span class="glyphicon glyphicon-search" aria-hidden="true">
                            Buscar
                        </span>
                    </button>
                </div>
            </form> 
        </div>

        <div class="col-md-3"> 
            <div class="form-group">     	
                <label class="miversalita micolor">&nbsp; </label> 
                
                
            </div>

            <div class="form-group row" >     	
                
                <a href="registro_alumnos.php" 
                   class="btn btn-success miversalita ">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true">
                        Nuevo alumno
                    </span>
                </a>
            </div>
        </div>


    </div> 
    <?php
    include_once "plantillas/formulario_consultas_alumnos.inc.php";
    ?>
</div>

<?php
include_once("plantillas/pie.inc.php");
?>



