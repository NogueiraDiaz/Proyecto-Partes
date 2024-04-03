<?php
include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";

include_once "app/Conexion.inc.php";
include_once "app/Alumno.inc.php";
include_once "app/RepositorioAlumno.inc.php";
include_once "app/ValidarRegistroAlumno.inc.php";

if (isset($_POST['enviar'])) {
    // Si el usuario pulsa el boton de enviar
    Conexion::abrirConexion();
    //creo el objeto para la valiadación de los datos del alumno
    $validar_alumno = new ValidarRegistroAlumno(
            $_POST['apellidos'], $_POST['nombre'], $_POST['dni_nie'], $_POST['grupo']
            , $_POST['direccion'], $_POST['localidad']
            , $_POST['provincia'], $_POST['codigo_postal'], $_POST['tutor_1']
            , $_POST['tutor_2'], $_POST['telefono_fijo_alumno']
            , $_POST['telefono_movil_alumno'], $_POST['telefono_fijo_tutor_1']
            , $_POST['telefono_movil_tutor_1'], $_POST['telefono_fijo_tutor_2']
            , $_POST['telefono_movil_tutor_2'], $_POST['email_tutor_1']
            , $_POST['email_tutor_2']);
    // Si la validación es correcta creo un objeto de la clase 
    if ($validar_alumno->registroCorrecto()) {
        $alumno = new Alumno(
                $_POST['nombre'], $_POST['apellidos'], $_POST['dni_nie'], $_POST['grupo']
                // concateno los campos y los separo con un $ para poder
                // separarlos cuando se realiza la edición del alumno
                , ( $_POST['direccion']. "$" . $_POST['localidad']. "$" 
                . $_POST['provincia']. "$" . $_POST['codigo_postal'])
                , $_POST['tutor_1'], $_POST['tutor_2'], $_POST['telefono_fijo_alumno']
                , $_POST['telefono_movil_alumno'], $_POST['telefono_fijo_tutor_1']
                , $_POST['telefono_fijo_tutor_2'], $_POST['telefono_movil_tutor_1']
                , $_POST['telefono_movil_tutor_2'], $_POST['email_tutor_1']
                , $_POST['email_tutor_2']);
        
        // Alta en la base de datos del nuevo alumno validado
        if (RepositorioAlumno::NuevoAlumno(Conexion::getConexion(), $alumno)) {
            $_SESSION["alta_ok"] = 1;
            header('Location: gestion_alumnos.php');
        }
        Conexion::cerrarConexion();
    }
}
?>

<div class="container">
    
        <!-- col-md-offset-2 es un desplazamiento antes de la columna para centrarlo -->
        <div class="mifondoGlow ">  
            <h3 class="text-center miversalita micolor 
                mipaddingtitulo">Registro nuevo alumno</h3>    
            <form class="form-signin center-block mipadding" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
                <?php
                if (isset($_POST['enviar'])) {
                    include_once 'plantillas/formulario_registro_alumno_validado.inc.php';
                } else {
                    include_once 'plantillas/formulario_registro_alumno_vacio.inc.php';
                }
                ?>
            </form>
        </div> 
    
</div>


<?php
include_once("plantillas/pie.inc.php");

