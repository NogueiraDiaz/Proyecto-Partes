<?php
include_once"plantillas/cabecera.inc.php";
include_once 'plantillas/navbar.inc.php';

include_once"app/Conexion.inc.php";
include_once"app/Profesor.inc.php";
include_once"app/RepositorioProfesor.inc.php";
include_once"app/ValidarRegistroProfesor.inc.php";


   
   



if (isset($_POST['enviar'])) {
    // Si el usuario pulsa el boton de enviar
    // CUIDADO con required de html que da problemas con $POST['enviar']
    Conexion::abrirConexion();
    $validar_profesor = new ValidarRegistroProfesor($_POST['dni'], $_POST['apellidos'], $_POST['nombre'], $_POST['email'], $_POST['password1'], $_POST['password2'], $_POST['grupo']);
    if ($validar_profesor->registroCorrecto()) {
		if ($_POST['grupo'] != 'No.') {
			$nivel_acceso = -2;
		} else {
			$nivel_acceso = -1;
		}
        $profesor = new Profesor($_POST['dni'], $_POST['apellidos'], $_POST['nombre'], $_POST['email'], password_hash($_POST['password1'], PASSWORD_DEFAULT), $nivel_acceso, $_POST['grupo']);
        if (RepositorioProfesor::nuevoProfesor(Conexion::getConexion(), $profesor)) {
            header('Location: altacorrecta.php');
        }
    }
	
        Conexion::cerrarConexion();
}
?>

<div class="container">
    <div class="row">

        <div class="col-md-8 col-md-offset-2 mifondoGlow mipadding">  
            
            <h3 class="text-center miversalita micolor 
                mipaddingtitulo">Registro nuevo profesor</h3>    
            <form class="form-signin center-block mipadding" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
                <?php
                if (isset($_POST['enviar'])) {
                    include_once 'plantillas/formulario_registro_profesor_validado.inc.php';
                } else {
                    include_once 'plantillas/formulario_registro_profesor_vacio.inc.php';
                }
                ?>
            </form>
        </div> 
    </div>
</div>


<?php
include_once("plantillas/pie.inc.php")
?>