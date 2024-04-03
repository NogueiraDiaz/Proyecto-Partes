<?php
include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";

include_once "app/Conexion.inc.php";
include_once "app/Alumno.inc.php";
include_once "app/RepositorioAlumno.inc.php";
include_once "app/RepositorioGrupo.inc.php";

include_once "app/ValidarRegistroAlumno.inc.php";

Conexion::abrirConexion();
$alu = RepositorioAlumno::getAlumnoCodigo(Conexion::getConexion(), $_SESSION["cod_alumno"]);
$_SESSION["grupos"] = RepositorioGrupo::getGrupos(Conexion::getConexion());


// creo el objeto $alumno con los datos de la consulta por codigo de alumno
$alumno = new Alumno($alu['matricula'],$alu['nombre'], $alu['apellidos']
        , $alu['dni'], $alu['grupo'],$alu['telefono'],$alu['puntos_Actuales'],$alu['puntos_Acumulados'], $alu['telefono_fijo']
        ,$alu['direccion'], $alu['nombre_Tutor1'], $alu['nombre_Tutor2'], $alu['email']
        , $alu['fijo_Tutor1']
        , $alu['fijo_Tutor2'], $alu['movil_Tutor1']
        , $alu['movil_Tutor2'], $alu['email_Tutor1']
        , $alu['email_Tutor2']);

if (isset($_POST['enviar'])) {
    // Si el usuario pulsa el boton de enviar
    // validamos los datos de la edicion 
    $validar_alumno = new ValidarRegistroAlumno(
            $_POST['apellidos'], $_POST['nombre'], $_POST['dni_nie'], $_POST['grupo']
            , $_POST['direccion'], $_POST['tutor_1']
            , $_POST['tutor_2'], $_POST['telefono_fijo_alumno']
            , $_POST['telefono_movil_alumno'], $_POST['telefono_fijo_tutor_1']
            , $_POST['telefono_fijo_tutor_2'], $_POST['telefono_movil_tutor_1']
            , $_POST['telefono_movil_tutor_2'], $_POST['email_tutor_1']
            , $_POST['email_tutor_2']);
    
    // Si la validación es correcta
    if ($validar_alumno->registroCorrecto()) {
        // Para evitar los problemas del combo que no pasa los valores bien
        // en la edicion, -MIRAR COMO LO HE HECHO CON EL PROFESOR QUE NO ME DABA
        // ESTOS PROBLEMAS-
         $_POST['grupo'] == "" ? $grupo = $alu['grupo_alumno'] : $grupo = $_POST['grupo'];
         
        //Creamos un nuevo alumno con los datos editados y validados
        $alumno_editado = new Alumno($_POST['matricula'],
                $_POST['nombre']
                , $_POST['apellidos']
                , $_POST['dni_nie']
                , $_POST['grupo']
                , $_POST['telefono_movil_alumno']
                , $_POST['Puntos_totales']
                , $_POST['Puntos_acumulados']
                , $_POST['telefono_fijo_alumno']
                ,$_POST['direccion']
                , $_POST['tutor_1'], $_POST['tutor_2']
                , $_POST['email']
                , $_POST['telefono_fijo_tutor_1']
                , $_POST['telefono_fijo_tutor_2'], $_POST['telefono_movil_tutor_1']
                , $_POST['telefono_movil_tutor_2'], $_POST['email_tutor_1']
                , $_POST['email_tutor_2']);

       
        // Modificamos los datos del alumno en la base de datos
        if (RepositorioAlumno::cambiarDatosAlumno(Conexion::getConexion()
                        , $alumno_editado, $_SESSION["cod_alumno"])) {
             // para comprobar que la edición ha sido correcta y poder mostrar
        // el mensaje de confirmación para el usuario
            $_SESSION["edicion_ok"] = 1;
            header('Location: gestion_alumnos.php');
        }
        else{
            echo "la consulta no se realiza correctamente";
        }
    }
}
Conexion::cerrarConexion();
?>

<br> <br>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 mifondoGlow mipadding">  <!--centrado-->
            <h3 class="text-center miversalita micolor mipaddingtitulo">
                Edición datos alumno
            </h3>    
            <form class="form-signin center-block mipadding" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
                <?php
                if (isset($_POST['enviar'])) {
                    include_once 'plantillas/formulario_edicion_alumnos_validado.inc.php';
                } else {
                    include_once 'plantillas/formulario_edicion_alumnos_vacio.inc.php';
                }
                ?>
            </form>
        </div> 
    </div>
</div>


<?php
include_once("plantillas/pie.inc.php");


