<?php
//--------------------------------------------------CODIGO FUNCIONAL--------------------------------------------------------------------------------------
session_start();
//miro si el usuario está loggeado para redirigirlo en caso contrario
require_once("../Funciones/loginRequerido.php"); 

//codigo de usuario
$codUsuario=$_GET["id"];


//conexion a la base de datos
try{
    //realizo la conexión a la base de datos
    require "../../../archivosComunes/conexion.php";
    
    $usuarios = $db->query("SELECT * FROM Alumnos WHERE COD_ALUMNO='$codUsuario'");
    //Aqui guardo todos los datos del usuario
    $usuario = $usuarios->fetch();
}
catch (PDOException $e) {//en caso de fallo devuelve el mensaje de error de BBDD
    return "Error en la base de datos ".$e->getMessage();
}

$ruta = "empresas";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $boolConsulta = true;

    //Actualizo los datos del usuario
    echo $_POST["GeneroAlumno"];

    $upd = "UPDATE Alumnos set nombre = '" . $_POST["nombreAlumno"] . "' , apellidos = '" . $_POST["apellidosAlumno"] . "', dni_alumno = '" . $_POST["DNIAlumno"] . "', correo_alumno = '" . $_POST["correoAlumno"] . "', 
    telefono_alumno = '" . $_POST["telefonoAlumno"] . "',fecha_nac = '" . $_POST["fechaNacAlumno"]. "',genero = '" . $_POST["GeneroAlumno"] . "', lugar_nac ='" . $_POST["lugarNacAlumno"] . "', localidad_alumno='" . $_POST["localidadAlumno"] . "', provincia_alumno = '" . $_POST["provinciaAlumno"] . "', 
    domicilio_alumno='" . $_POST["domicilioAlumno"] . "', cp_alumno='" . $_POST["cpAlumno"] . "', ciclo='" . $_POST["cicloAlumno"] . "', anio='" . $_POST["anioAlumno"] . "'WHERE cod_alumno = '$codUsuario' ";
    $resul = $db->query($upd);

    //Comprobar errores
    if($resul)  header("Location: ../../index.php");
    else        print_r($db->errorinfo());
     

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <script type="text/javascript" src="../../js/bootstrap.bundle.min.js" defer></script>
    <script type="text/javascript" src="../../js/patrones.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>

    <title>Editar Alumno</title>
    <style>
        *{
            padding: 0;
            margin: 0;
        }

        .contenedorlista{
            width: 50vw;
            margin: auto;
            display: flex;
            justify-content: center;
        }

        .contenedorlista label, .contenedorlista input, .contenedorlista select{
            height: 3vh;
            margin: 5px 10px;
        }
        .contenedorlista div{
            display: flex;
            flex-direction: column;
            
        }

        .contenedorlista div:last-child{
            text-align: left;
        }



        
    </style>
</head>

<body>
    <!-- menu de navegacion -->
    <?php require "../Header-Footer/header.php" ?>

        <h3>Editar Alumno</h3>
        <form class="container-fluid pt-4 text-white central-form" method="POST" action="<?php echo $_SERVER['PHP_SELF'] . "?id=". $_GET["id"]; ?>" class="contenedorlista" id="formulario">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <label for='nombreAlumno' class='form-label datos'>Nombre: </label>
                    <input type='text' name='nombreAlumno' class='form-control' value="<?php echo $usuario["nombre"] ?>" placeholder='Nombre'>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <label for='apellidosAlumno' class='form-label datos'>Apellidos: </label>
                    <input type='text' class='form-control' name='apellidosAlumno' value="<?php echo $usuario["apellidos"] ?>" placeholder='Apellidos'>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <label for='DNIAlumno' class='form-label datos'>DNI: </label>
                    <input type='text' class='form-control' name='DNIAlumno' value="<?php echo $usuario["dni_alumno"] ?>" placeholder='DNI' id="dni">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <label for='GeneroAlumno' class='form-label datos'>Genero: </label>
                    <select name='GeneroAlumno' class='form-select'>
                        <option value=Hombre <?php if($usuario["genero"] == 'Hombre') echo 'selected' ?>>Hombre</option>
                        <option value=Mujer <?php if($usuario["genero"] == 'Mujer') echo 'selected' ?>>Mujer</option>
                        <option value=Otros <?php if($usuario["genero"] == 'Otros') echo 'selected' ?>>Otros</option>
                    </select>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <label for='correoAlumno' class='form-label datos'>Correo: </label>
                    <input type='text' class='form-control' name='correoAlumno' value="<?php echo $usuario["correo_alumno"] ?>" placeholder='Correo' id="correo">
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <label for='telefonoAlumno' class='form-label datos'>Nº Telefono: </label>
                    <input type='text' class='form-control' name='telefonoAlumno' value="<?php echo $usuario["telefono_alumno"] ?>" placeholder='Telefono' id="tlf">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <label for='fechaNacAlumno' class='form-label datos'>Fecha de nacimiento: </label>
                    <input type='date' class='form-control' name='fechaNacAlumno' value="<?php echo $usuario["fecha_nac"] ?>" id="fechaNac">
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <label for='lugarNacAlumno' class='form-label datos'>Lugar de nacimiento: </label>
                    <input type='text' class='form-control' name='lugarNacAlumno' value="<?php echo $usuario["lugar_nac"] ?>" placeholder='Lugar de nacimiento'>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <label for='localidadAlumno' class='form-label datos'>Localidad: </label>
                    <input type='text' class='form-control' name='localidadAlumno' value="<?php echo $usuario["localidad_alumno"] ?>" placeholder='Localidad'>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <label for='provinciaAlumno' class='form-label datos'>Provincia: </label>
                    <input type='text' class='form-control' name='provinciaAlumno' value="<?php echo $usuario["provincia_alumno"] ?>" placeholder='Provincia'>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <label for='domicilioAlumno' class='form-label datos'>Domicilio: </label>
                    <input type='text' class='form-control' name='domicilioAlumno' value="<?php echo $usuario["domicilio_alumno"] ?>" placeholder='Domicilio'>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <label for='cpAlumno' class='form-label datos'>CP: </label>
                    <input type='text' class='form-control' name='cpAlumno' value="<?php echo $usuario["cp_alumno"] ?>" placeholder='Código postal' id="CP">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for='cicloAlumno' class='form-label datos'>Ciclo: </label>
                    <select name='cicloAlumno' class='form-select'>
                        <option value=FPB <?php if($usuario["ciclo"] == 'FPB') echo "selected"?>>FPB</option>
                        <option value=SMR <?php if($usuario["ciclo"] == 'SMR') echo "selected"?>>SMR</option>
                        <option value=DAM <?php if($usuario["ciclo"] == 'DAM') echo "selected"?>>DAM</option>
                        <option value=DAW <?php if($usuario["ciclo"] == 'DAW') echo "selected"?>>DAW</option>
                    </select>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for='anioAlumno' class='form-label datos'>Año: </label>
                    <input type='text' class='form-control' name='anioAlumno' value="<?php echo $usuario["anio"] ?>" placeholder='Año' id="anio">
                </div>
            </div>

            <div class="row pt-2 pb-5">
                <div class="col-md-12 col-sm-12 col-12">
                    <button type="submit" name="crearAlumno" class='btn botones-guardar' id="crearAlumno">Guardar</button>
                </div>
            </div>   
                
        </form>
        <br><br>
	
 
    <?php require "../Header-Footer/footer.php" ?>
</body>
</html>



