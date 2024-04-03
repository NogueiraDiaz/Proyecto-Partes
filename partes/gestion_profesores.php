<?php
include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";

include_once "app/RepositorioProfesor.inc.php";

include_once "app/Conexion.inc.php";


Conexion::abrirConexion();
$profesores = RepositorioProfesor::getProfesores(Conexion::getConexion());
Conexion::cerrarConexion();

if (isset($_POST["cambiar_password"])) {
    $_SESSION["cod_profesor"] = $_POST["profesor"];
    header("Location: gestion_profesores_password.php");
}

if (isset($_POST["editar_profesor"])) {
    $_SESSION["cod_profesor"] = $_POST["profesor"];
    header("Location: gestion_profesores_editar.php");
}

if (isset($_POST["activar_profesor"])) {
    $_SESSION["cod_profesor"] = $_POST["profesor"];
    header("Location: gestion_profesores_activar.php");
}

if (isset($_POST["partes_profesor"])) {
    $_SESSION["cod_profesor"] = $_POST["profesor"];
    header("Location: gestion_profesores_partes.php");
}
?>

<div class="container">
    <?php
    if (isset($_SESSION["password_ok"])) {
        RepositorioProfesor::mensajeEdicionProfesor($_SESSION["password_ok"], "La contraseña ha sido cambiada correctamente.");
        unset($_SESSION["password_ok"]);
    }
    if (isset($_SESSION["edicion_ok"])) {
        RepositorioProfesor::mensajeEdicionProfesor($_SESSION["edicion_ok"], "Los cambios se han realizado correctamente.");
        unset($_SESSION["edicion_ok"]);
    }
    if (isset($_SESSION["activado_ok"])) {
        RepositorioProfesor::mensajeEdicionProfesor($_SESSION["activado_ok"], "El profesor ha sido activado correctamente.");
        unset($_SESSION["activado_ok"]);
    }
    ?>   

    <div class="col-md-12 text-right"> 
        <a href="registro_profesores.php" class="btn btn-success miversalita mimargen">
            <span class="glyphicon glyphicon-plus" aria-hidden="true">
                Nuevo profesor
            </span>
        </a>
    </div>  

    <div class=""> 
        
        <div class=" mifondoGlow" >
            
                <h3 class="text-center mifuente minegrita miversalita micoloretiqueta">
                    Gestión profesores
                </h3>
            <div class="panel-body">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th class="mifuente  micoloretiqueta minegrita">Nombre</th>
                            <th class="mifuente  micoloretiqueta minegrita">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($profesores == NULL) {
                            echo "No tiene partes";
                        } else {
                            foreach ($profesores as $profesor) {
                                ?>
                                <tr>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo $profesor["nombre"] . " " . $profesor["apellidos"] ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <form  method="post"  action="<?php $_SERVER['PHP_SELF'] ?>">

                                            <input type="hidden" name="profesor" value="<?php echo $profesor["dni"] ?>">

                                            <button type="submit" class="btn btn-sx micolor btn-primary miversalita" 
                                                    name="cambiar_password">
                                                <span class="glyphicon glyphicon-refresh" aria-hidden="true">
                                                    Cambiar Contraseña
                                                </span>
                                            </button> 
                                            <!-- No vamos a borrar, si un profesor no debe acceder le cambiamos la clave.
                                            
                                            <button type="submit" class="btn btn-sx micolor btn-primary btn-danger miversalita" 
                                                        name="borrar_profesor">
                                                    <span class="glyphicon glyphicon-trash" aria-hidden="true">
                                                        Borrar
                                                    </span>
                                            </button>  
                                            -->
                                            <button type="submit" class="btn btn-sx micolor btn-success miversalita" 
                                                    name="editar_profesor">
                                                <span class="glyphicon glyphicon-pencil" aria-hidden="true">
                                                    Editar
                                                </span>
                                            </button>  

                                            <?php if ($profesor["usuario_login"]["validar"] == "no") { ?>
                                                <button type="submit" class="btn btn-sx micolor btn-danger miversalita" 
                                                        name="activar_profesor">
                                                    <span class="glyphicon glyphicon-flash" aria-hidden="true">
                                                        Activar
                                                    </span>
                                                </button> 
                                            <?php } ?>
                                        </form>
                                    </td>
                                </tr>    
                            <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include_once("plantillas/pie.inc.php");
?>


