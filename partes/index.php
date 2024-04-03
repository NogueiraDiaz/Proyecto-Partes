<?php
include_once "app/RepositorioSesion.inc.php";
//borro los datos de una sesion anterior para el parte
RepositorioSesion::borrarDatosSesion();

include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";

include_once "app/Conexion.inc.php";
include_once "app/RepositorioProfesor.inc.php";
include_once "app/RepositorioAlumno.inc.php";


include_once "app/Profesor.inc.php";
include_once "app/ValidarLogin.inc.php";

include_once "app/RepositorioGrupo.inc.php";
if (isset($_SESSION["acceso_no_validado"])) {
    unset($_SESSION["acceso_no_validado"]);
}
if (isset($_POST["enviar_login"])) {
    // Si el usuario pulsa el boton de enviar
    // CUIDADO con required de html que da problemas con $POST["enviar"]

    Conexion::abrirConexion();
	

	

    $validar_login = new ValidarLogin($_POST["email"], $_POST["password"]);
    if ($profesor = $validar_login->loginCorrecto()) {
        RepositorioSesion::iniciarSesion();
		$_SESSION["grupos"] = RepositorioGrupo::getGrupos(Conexion::getConexion());
        $_SESSION["nombre_profesor"] = $profesor["nombre"] . " " . $profesor["apellidos"];
        $_SESSION["nombre_profesor_navbar"] = $profesor["nombre"];
        $_SESSION["codigo_profesor"] = $profesor["dni"];
        $_SESSION["tipo_profesor"] = $profesor["rol"];
        $_SESSION["grupo_profesor"] = $profesor["tutor_Grupo"];
		if ($_SESSION["usuario_login"]["tutor_grupo"] != "No."){
			$_SESSION["alumnos_grupo"] = RepositorioAlumno::getAlumnosGrupo(Conexion::getConexion(), $_SESSION["usuario_login"]["tutor_grupo"]);
		}
        if ($profesor["validar"] == "no") {
            $_SESSION["acceso_no_validado"] = 1;
            header("Location: altacorrecta.php");
        } else {
            if ($profesor["rol"] == 0) {
                header("Location: index_admin.php");
            } else {
                header("Location: parte_tipo.php");
            }
        }
    }
    Conexion::cerrarConexion();
}
?>

<div class="container-fluid" >
    <div class="row">
        <div class="col-md-4 col-md-offset-4 mifondoGlow mimargensuperior40">  <!--centrado-->
            <form class="form-signin center-block" method="post" action="<?php $_SERVER["PHP_SELF"] ?>">
                <h3 class="text-center miversalita mimargen micoloretiqueta">Partes IES Julio Verne</h3>
                <?php
                if (!isset($_POST["enviar_login"])) {
                    include_once "plantillas/formulario_login_vacio.inc.php";
                } else {
                    include_once "plantillas/formulario_login_validado.inc.php";
                }
                ?>
            </form>
        </div> 
    </div> 
</div> 

<?php
include_once("plantillas/pie.inc.php");
?>

