<?php


    session_start();
    //miro si el usuario está loggeado para redirigirlo en caso contrario
    require_once("../Funciones/loginRequerido.php");  

    try{
        require "../../../archivosComunes/conexion.php";
    }
    catch (PDOException $e) {//en caso de fallo devuelve el mensaje de error de BBDD
        echo "Error en la base de datos ".$e->getMessage();
    }
   

    //Aqui es donde se hace la inserción del alumno dentro de la base de datos si todo está correcto
    if(isset($_POST["crearAlumno"])){

        $ins = "INSERT INTO Alumnos (`cod_alumno`, `dni_alumno`, `nombre`, `apellidos`, `genero`, `correo_alumno`, `telefono_alumno`, `fecha_nac`, `lugar_nac`, `localidad_alumno`, `provincia_alumno`, `domicilio_alumno`, `cp_alumno`, `ciclo`, `anio`)
                                       value(NULL, " ."'".  $_POST["DNIAlumno"] .         "', '"     .$_POST["nombreAlumno"] ."', " . 
                                                      "'".  $_POST["apellidosAlumno"].    "', '" .    $_POST["GeneroAlumno"] .    "', " .
                                                      "'".  $_POST["correoAlumno"].       "', '".     $_POST["telefonoAlumno"] .  "', " . 
                                                      "'".  $_POST["fechaNacAlumno"].     "', '".     $_POST["lugarNacAlumno"].   "', " . 
                                                      "'".  $_POST["localidadAlumno"].    "', '" .    $_POST["provinciaAlumno"].  "', " . 
                                                      "'".  $_POST["domicilioAlumno"].    "', '".     $_POST["cpAlumno"]     .    "', " .
                                                      "'".  $_POST["cicloAlumno"].        "', '".     $_POST["anioAlumno"].       "')";
        try{
            $resul = $db->query($ins);

            //Comprobar errores
            if($resul){
                //si sale bien la consulta me cargo las varialbles de error que pueda haber y vuelvo a la página principal
                unset($_SESSION["errorDNI"]);


                header("Location: ../../index.php");
            } else print_r($db->errorinfo());
            echo "";
        }
        catch(PDOException $e){
            echo "Error con la base de datos: " . $e->getMessage();
        }
        
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


    <title>Añadir Alumno</title>
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="../../index.php"><img src="../../img/julioverne.png" width="70" height="58" class="d-inline-block align-text-top m-2"></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="../../index.php">Ver Alumnos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mostrarAsignados.php">Ver Alumnos Asignados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mostrarEmpresas.php">Ver Empresas</a>
                    </li>

                    <li style="padding-left: 3rem"><hr class="dropdown-divider"></li>
                    <li class="nav-item">
                        <a class="nav-link" href="crearEmpresa.php">Crear Empresa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="crearAlumno.php">Crear Alumno</a></a>
                    </li>
                    <li><hr class="dropdown-divider text-white"></li>
                </ul>

                <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
      <a class="text-light btn btn-outline-secondary me-2" href="../../../archivosComunes/actualizarUsuario.php?idusuario=<?php echo $_SESSION['usuario_login']['cod_usuario']?>">
      <span class="d-flex">
          <svg xmlns="http://www.w3.org/2000/svg" style="height: 24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>&nbsp;
                <?php echo $_SESSION['usuario_login']['nombre'].' '.$_SESSION['usuario_login']['apellidos'] ?>
      </span>                 
  </a>
  </li> 
                    <li class="nav-item">
                    <a class="nav-link" href="../../../archivosComunes/selector.php"><span class="salir">Página Principal</span> <i class="bi bi-back"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mostrarEmpresas.php"><span class="salir">Salir&nbsp</span> <i class="bi bi-box-arrow-right"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <h3>Añadir Alumno</h3>
    <form class="container-fluid pt-4 text-white central-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="contenedorlista" id="formulario">
        <div class="row">
            <div class="col-lg-4 col-sm-6 col-12">
                <label for='nombreAlumno' class='form-label datos'>Nombre: </label>
                <input type='text' name='nombreAlumno' class='form-control' value="<?php if(isset($_POST["nombreAlumno"]))  echo $_POST["nombreAlumno"] ?>" placeholder='Nombre'>
            </div>
            <div class="col-lg-4 col-sm-6 col-12">
                <label for='apellidosAlumno' class='form-label datos'>Apellidos: </label>
                <input type='text' class='form-control' name='apellidosAlumno' value="<?php if(isset($_POST["apellidosAlumno"]))  echo $_POST["apellidosAlumno"] ?>" placeholder='Apellidos'>
            </div>
            <div class="col-lg-4 col-sm-12 col-12">
                <label for='DNIAlumno' class='form-label datos'>DNI: </label>
                <input type='text' class='form-control' name='DNIAlumno' value="<?php if(isset($_POST["DNIAlumno"]))  echo $_POST["DNIAlumno"] ?>" placeholder='DNI' id="dni">
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-sm-6 col-12">
                <label for='GeneroAlumno' class='form-label datos'>Genero: </label>
                <select name='GeneroAlumno' class='form-select'>
                    <option value=Hombre <?php if(isset($_POST["GeneroAlumno"]) && $_POST["GeneroAlumno"]== 'Hombre') echo 'selected' ?>>Hombre</option>
                    <option value=Mujer <?php if(isset($_POST["GeneroAlumno"]) && $_POST["GeneroAlumno"]== 'Mujer') echo 'selected' ?>>Mujer</option>
                    <option value=Otros <?php if(isset($_POST["GeneroAlumno"]) && $_POST["GeneroAlumno"]== 'Otros') echo 'selected' ?>>Otros</option>
                </select>
            </div>
            <div class="col-lg-4 col-sm-6 col-12">
                <label for='correoAlumno' class='form-label datos'>Correo: </label>
                <input type='text' class='form-control' name='correoAlumno' value="<?php if(isset($_POST["correoAlumno"]))  echo $_POST["correoAlumno"] ?>" placeholder='Correo' id="correo">
            </div>
            <div class="col-lg-4 col-sm-12 col-12">
                <label for='telefonoAlumno' class='form-label datos'>Nº Telefono: </label>
                <input type='text' class='form-control' name='telefonoAlumno' value="<?php if(isset($_POST["telefonoAlumno"]))  echo $_POST["telefonoAlumno"] ?>" placeholder='Telefono' id="tlf">
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-sm-6 col-12">
                <label for='fechaNacAlumno' class='form-label datos'>Fecha de nacimiento: </label>
                <input type='date' class='form-control' name='fechaNacAlumno' value="<?php if(isset($_POST["fechaNacAlumno"]))  echo $_POST["fechaNacAlumno"] ?>" id="fechaNac">
            </div>
            <div class="col-lg-4 col-sm-6 col-12">
                <label for='lugarNacAlumno' class='form-label datos'>Lugar de nacimiento: </label>
                <input type='text' class='form-control' name='lugarNacAlumno' value="<?php if(isset($_POST["lugarNacAlumno"]))  echo $_POST["lugarNacAlumno"] ?>" placeholder='Lugar de nacimiento'>
            </div>
            <div class="col-lg-4 col-sm-12 col-12">
                <label for='localidadAlumno' class='form-label datos'>Localidad: </label>
                <input type='text' class='form-control' name='localidadAlumno' value="<?php if(isset($_POST["localidadAlumno"]))  echo $_POST["localidadAlumno"] ?>" placeholder='Localidad'>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-sm-6 col-12">
                <label for='provinciaAlumno' class='form-label datos'>Provincia: </label>
                <input type='text' class='form-control' name='provinciaAlumno' value="<?php if(isset($_POST["provinciaAlumno"]))  echo $_POST["provinciaAlumno"] ?>" placeholder='Provincia'>
            </div>
            <div class="col-lg-4 col-sm-6 col-12">
                <label for='domicilioAlumno' class='form-label datos'>Domicilio: </label>
                <input type='text' class='form-control' name='domicilioAlumno' value="<?php if(isset($_POST["domicilioAlumno"]))  echo $_POST["domicilioAlumno"] ?>" placeholder='Domicilio'>
            </div>
            <div class="col-lg-4 col-sm-12 col-12">
                <label for='cpAlumno' class='form-label datos'>CP: </label>
                <input type='text' class='form-control' name='cpAlumno' value="<?php if(isset($_POST["cpAlumno"]))  echo $_POST["cpAlumno"] ?>" placeholder='Código postal' id="CP">
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-sm-6 col-12">
                <label for='cicloAlumno' class='form-label datos'>Ciclo: </label>
                <select name='cicloAlumno' class='form-select'>
                    <option value=FPB <?php if(isset($_POST["cicloAlumno"]) && $_POST["cicloAlumno"]== 'FPB') echo 'selected' ?>>FPB</option>
                    <option value=SMR <?php if(isset($_POST["cicloAlumno"]) && $_POST["cicloAlumno"]== 'SMR') echo 'selected' ?>>SMR</option>
                    <option value=DAM <?php if(isset($_POST["cicloAlumno"]) && $_POST["cicloAlumno"]== 'DAM') echo 'selected' ?>>DAM</option>
                    <option value=DAW <?php if(isset($_POST["cicloAlumno"]) && $_POST["cicloAlumno"]== 'DAW') echo 'selected' ?>>DAW</option>
                </select>
            </div>
            <div class="col-lg-6 col-sm-6 col-12">
                <label for='anioAlumno' class='form-label datos'>Año: </label>
                <input type='text' class='form-control' name='anioAlumno' value="<?php if(isset($_POST["anioAlumno"]))  echo $_POST["anioAlumno"] ?>" placeholder='Año' id="anio">
            </div>
        </div>

        <div class="row pt-2 pb-5">
            <div class="col-md-12 col-sm-12 col-12">
                <button type="submit" name="crearAlumno" class='btn botones-guardar' id="crearAlumno">Crear Alumno</button>
            </div>
        </div>   
            
    </form>
    <br><br>

 
    <?php require "../Header-Footer/footer.php" ?>

</body>
</html>
