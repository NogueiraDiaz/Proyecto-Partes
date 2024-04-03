<?php
include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";

include_once "app/Conexion.inc.php";
include_once "app/Profesor.inc.php";
include_once "app/RepositorioProfesor.inc.php";
include_once "app/ValidarRegistroProfesor.inc.php";
Conexion::abrirConexion();
$prof = RepositorioProfesor::getProfesorCodigo(Conexion::getConexion(), $_SESSION["codigo_profesor"]);
// creo $profesor para poder mostrar los datos en el formulario_edicion_profesores vacio
$profesor = new Profesor($prof['dni'], $prof['apellidos'], $prof['nombre'], $prof['email'], $prof['passowrd']
        , $prof['rol'], $prof['tutor_Grupo']);
if (isset($_POST['enviar'])) {
    // Si el usuario pulsa el boton de enviar
    $_SESSION["editado"] = 1;
    $validar_profesor = new ValidarRegistroProfesor($_POST['apellidos']
            , $_POST['nombre'], $_POST['email'], $_POST['password1'], $_POST['password2'], $_POST['tutor_grupo']);
    if ($validar_profesor->registroCorrecto()) {
        if ($_POST["grupo"] == "Dejar de ser tutor") {
            $prof['rol'] = 1;
            $_POST["grupo"] = NULL;
        }
        // Esto es para cuando se realizar una modificación del grupo, cuando un profeosor
        // que no es tutor pasa a serlo, para el caso de que se le haya pasado
        // al profesor seleccionar el grupo del que es tutor en el alta
        if ($_POST["grupo"] !=NULL && $_POST["grupo"] != "Dejar de ser tutor" 
                && $prof['rol']==1) {
            $prof['tutor_grupo'] = 2;
        }
        // Comprueba si la contraseña ha sido modificada, si ha sido modificado
        // la vuelvo a cifrar y si no ha sido modificada guardo la que habia anteriormente
        // que ya estaba modificada.
        // Si no hago esto y no cambia la clave, cifro la clave que ya estaba cifrada....+

        if ($prof['pas_profesor'] == $_POST['password1']) {
            $profesor = new Profesor($prof['cod_profesor'], $_POST['apellidos']
                    , $_POST['nombre'], $_POST['email'], $_POST['password1']
                    , $_POST['grupo'], $prof['rol']);
        } else {
            $profesor = new Profesor($prof['cod_profesor'], $_POST['apellidos']
                    , $_POST['nombre'], $_POST['email']
                    , password_hash($_POST['password1'], PASSWORD_DEFAULT)
                    , $_POST["grupo"], $prof['rol']);
        }

        $_SESSION["edicion_ok"] = 0;
        if (RepositorioProfesor::cambiarDatosProfesor(Conexion::getConexion(), $profesor)) {
            $_SESSION["edicion_ok"] = 1;
            header('Location: gestion_profesores.php');
        }
    }
}
Conexion::cerrarConexion();
?>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 mifondoGlow mipadding">  <!--centrado-->
            <h3 class="text-center miversalita micolor mipaddingtitulo">
                Edición datos profesor
            </h3>    
            <form class="form-signin center-block mipadding" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
                <?php
                if (isset($_POST['enviar'])) {
                    include_once 'plantillas/formulario_edicion_profesores_validado.inc.php';
                } else {
                    include_once 'plantillas/formulario_edicion_profesores_vacio.inc.php';
                }
                unset($_SESSION["editado"]);
                ?>
            </form>
        </div> 
    </div>
</div>


<?php
include_once("plantillas/pie.inc.php");

