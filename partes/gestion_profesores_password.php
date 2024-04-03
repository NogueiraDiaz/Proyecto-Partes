<?php
include_once"plantillas/cabecera.inc.php";
include_once 'plantillas/navbar.inc.php';

include_once"app/Conexion.inc.php";

include_once"app/RepositorioProfesor.inc.php";
include_once"app/ValidarPassword.inc.php";

if (isset($_POST['enviar'])) {
    // Si el usuario pulsa el boton de enviar
    // CUIDADO con required de html que da problemas con $POST['enviar']
    
    $validar_password = new ValidarPassword($_POST['password1'], $_POST['password2']);
    if ($validar_password->registroCorrecto()) {
        Conexion::abrirConexion();
        $_SESSION["password_ok"] = 0;
        if(RepositorioProfesor::cambiarPasswordProfesor(Conexion::getConexion(), $_SESSION["cod_profesor"], password_hash($_POST['password1'], PASSWORD_DEFAULT))){
            $_SESSION["password_ok"] = 1;
            header('Location: gestion_profesores.php');
        }
        Conexion::cerrarConexion();
    }
}
?>

<div class="container">
    <div class="row">
        <br>
        <br>
        <br>
        <div class="col-md-8 col-md-offset-2 mifondoGlow mipadding">  <!--centrado-->
            <h3 class="text-center miversalita micolor 
                mipaddingtitulo ">Cambiar contraseña profesor</h3>    
            <form class="form-signin center-block mipadding" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
                <?php
                if (isset($_POST['enviar'])) {
                    include_once 'plantillas/formulario_gestion_profesores_password_validado.inc.php';
                } else {
                    include_once 'plantillas/formulario_gestion_profesores_password_vacio.inc.php';
                }
                ?>
            </form>
        </div> 
    </div>
</div>


<?php
include_once("plantillas/pie.inc.php");
