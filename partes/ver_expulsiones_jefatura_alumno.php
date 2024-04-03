<?php
include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";

include_once "app/RepositorioAlumno.inc.php";

include_once "app/Conexion.inc.php";

Conexion::abrirConexion();

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

if (isset($_POST["expulsiones_alumno"])) {
    $_SESSION["cod_alumno"] = $_POST["alumno"];
    $_SESSION["jefatura_expulsiones"]=1;
    $_SESSION["jefatura_expulsiones_carta"]=1;
    header("Location: gestion_alumnos_expulsiones.php");
}

Conexion::cerrarConexion();
?>

<div class="container">
    <div class="row mifondo">
        <h3 class='text-center mifondo miversalita micoloretiqueta mipaddingtitulo'>
            Selección datos busqueda alumno 
        </h3>


        <div class="col-md-4"> 
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

        <div class="col-md-4"> 
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

        <div class="col-md-4"> 
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

    </div> 
    <?php
    include_once "plantillas/formulario_consultas_jefatura_expulsiones_alumnos.inc.php";
    ?>
</div>

<?php
include_once("plantillas/pie.inc.php");
?>



