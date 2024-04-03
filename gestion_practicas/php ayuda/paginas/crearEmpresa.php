<?php
    session_start();
    //miro si el usuario está loggeado para redirigirlo en caso contrario
    require_once("../Funciones/loginRequerido.php"); 

    /*VARIABLE GLOBAL*/
    $ruta = "empresas";   //se usa en el metodo subirAnexo para elegir la ruta en la que subir los archivos

    try{
            // Realizo la conexión a la base de datos:
        require_once("../../../archivosComunes/conexion.php");
        require "../Funciones/anexos.php";
        
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            // Comenzamos la transacción:
            $db->beginTransaction();

            $consultaCOD = $db->query("SELECT * FROM Empresas WHERE cod_empresa = '". $_POST["cod_empresa"] . "'");

            if($consultaCOD->rowCount() == 0){
                $_SESSION["error_cod"] = false;
                $anexo0 = $_FILES['anexo0']['name'] != null ? subirAnexo($ruta, $_POST["nombre"], "", "anexo0") : " ";
                $anexo0A = $_FILES['anexo0A']['name'] != null ? subirAnexo($ruta, $_POST["nombre"], "", "anexo0A") : " ";
                $anexo0B = $_FILES['anexo0B']['name'] != null ? subirAnexo($ruta, $_POST["nombre"], "", "anexo0B") : " ";
                $anexoXVI = $_FILES['anexoXVI']['name'] != null ? subirAnexo($ruta, $_POST["nombre"], "", "anexoXVI") : " ";

                $cod_empresa = $_POST["cod_empresa"];
                $tipo = $_POST["tipo"];
                $respon = $_POST["responsable"];
                $dni = $_POST["dni"];
                $nombre = $_POST["nombre"];
                $localidad = $_POST["localidad"];
                $prov = $_POST["provincia"];
                $direccion = $_POST["direccion"];
                $cp = $_POST["cp"];
                $cif = $_POST["cif"];
                $lfirma = $_POST["localidadFirma"];
                $ffirma = $_POST["fechaFirma"];

                if (!$anexo0 || !$anexo0A || !$anexo0B || !$anexoXVI) {
                    echo "Algo ha salido mal";
                } else {
                    // Consulta para insertar los datos:
                    /* -------------------------------- Cambiar el cod_empresa, está puesto así porque hay que cambiar la bbdd para que se autoincremente: ----------------------------------- */
                    $consulta = "INSERT INTO Empresas (`cod_empresa`, `tipo`, `respo_empresa`, `dni_responsable`, `nombre_empresa`, `localidad_empresa`, `provincia_empresa`, `direcc_empresa`, `cp_empresa`, `cif_empresa`, `localidad_firma`, `fecha_firma`, `anexo_0`, `anexo_0a`, `anexo_0b`, `anexo_xvi`) 
                                VALUES ('$cod_empresa', '$tipo', '$respon', ' $dni', '$nombre', '$localidad', '$prov', '$direccion', '$cp', '$cif', '$lfirma ', '$ffirma', '$anexo0', '$anexo0A', '$anexo0B', '$anexoXVI');";
                  $empresas = $db->query($consulta);

                    $error = false;

                    foreach ($_POST["telefono"] as $num) {
                        $consulta = "INSERT INTO `Telefono_empresas` (`cod_empresa`, `telefono`) VALUES ('".$_POST['cod_empresa']."', '$num');";
                        $result = $db->query($consulta);
                    
                        if (!$result) {
                            $error = true;
                            break;
                        }
                    }

                    foreach ($_POST["correo"] as $correo) {
                        $consulta2 = "INSERT INTO `Mail_empresas` (`cod_empresa`, `email`) VALUES ('".$_POST['cod_empresa']."', '$correo');";
                        $result = $db->query($consulta2);
        
                        if (!$result) {
                            $error = true;
                            break;
                        }
                    }

                    foreach ($_POST["ciclo"] as $cicloElegido) {
                        echo $cicloElegido;
                        $consulta = "INSERT INTO `Ciclo_empresas` (`cod_empresa`, `ciclo`) VALUES ('".$_POST['cod_empresa']."', '$cicloElegido');";
                        $ciclo = $db->query($consulta);

                        if (!$ciclo) {
                            $error = true;
                            break;
                        }
                    }
                    echo "8";

                    // Si todo va bien, se inserta en la base de datos:
                    if (!$empresas || $error) {
                        echo "<br> Error: " . print_r($db->errorInfo()) . "<br>";
                        $db->rollBack();
                        echo "<br> Transacción anulada <br>";
                    } else {
                        $db->commit();
                        header("Location: mostrarEmpresas.php");
                    }
                }
            }
            else{
                $_SESSION["error_cod"] = true;
            }
            
        }
        
    }
    catch (PDOException $e) {//en caso de fallo devuelve el mensaje de error de BBDD
        return "Error en la base de datos ".$e->getMessage();
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
    <title>Añadir empresa</title>
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
                        <a class="nav-link active" href="crearEmpresa.php">Crear Empresa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="crearAlumno.php">Crear Alumno</a></a>
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

    <section class="central-form">   
    <h3>Añadir Empresa</h3>
        <!-- Formulario para insertar los datos con patrones por cada campo: -->
        <form class="container-fluid pt-4 text-white central-form" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data" id="formulario">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label for="cod_empresa" class="form-label datos">Código de Empresa:</label>
                            <input type="text" class="form-control" value="<?php if(isset($_POST["cod_empresa"])) echo $_POST["cod_empresa"] ?>" name="cod_empresa">
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label for="responsable" class="form-label datos">Responsable:</label>
                            <input type="text" class="form-control" value="<?php if(isset($_POST["responsable"])) echo $_POST["responsable"] ?>" name="responsable">
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <label for="dni" class="form-label datos">DNI del responsable:</label>
                            <input type="text" class="form-control" value="<?php if(isset($_POST["dni"])) echo $_POST["dni"] ?>" name="dni"id="dni">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label for="nombre" class="form-label datos">Nombre empresa:</label>
                            <input type="text" class="form-control" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"] ?>" name="nombre">
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label for="tipo" class="form-label datos">Tipo:</label>
                            <input type="text" class="form-control" value="<?php if(isset($_POST["tipo"])) echo $_POST["tipo"] ?>" name="tipo">
                        </div>

                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <label for="localidad" class="form-label datos">Localidad:</label>
                            <input type="text" class="form-control" value="<?php if(isset($_POST["localidad"])) echo $_POST["localidad"] ?>" name="localidad">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label for="provincia" class="form-label datos">Provincia:</label>
                            <input type="text" class="form-control" value="<?php if(isset($_POST["provincia"])) echo $_POST["provincia"] ?>" name="provincia" id="provincia">
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label for="direccion" class="form-label datos">Dirección:</label>
                            <input type="text" class="form-control" value="<?php if(isset($_POST["direccion"])) echo $_POST["direccion"] ?>" name="direccion">
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <label for="cp" class="form-label datos">Código Postal:</label>
                            <input type="number" class="form-control" value="<?php if(isset($_POST["cp"])) echo $_POST["cp"] ?>" name="cp" id="CP">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label for="cif" class="form-label datos">CIF:</label>
                            <input type="text" class="form-control" value="<?php if(isset($_POST["cif"])) echo $_POST["cif"] ?>" name="cif" id="CIF">
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label for="localidadFirma" class="form-label datos">Localidad firma:</label>
                            <input type="text" class="form-control" value="<?php if(isset($_POST["localidadFirma"])) echo $_POST["localidadFirma"] ?>" name="localidadFirma">
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <label for="fechaFirma" class="form-label datos">Fecha firma:</label>
                            <input type="date" class="form-control" value="<?php if(isset($_POST["fechaFirma"])) echo $_POST["fechaFirma"] ?>" name="fechaFirma">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-12">   
                            <label for="formGroupExampleInput" class="form-label datos inputAnexos">Anexo 0:</label>
                            <input type="file" class="form-control inputAnexos" name="anexo0" >
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <label for="formGroupExampleInput" class="form-label datos inputAnexos">Anexo 0A:</label>
                            <input type="file" class="form-control inputAnexos" name="anexo0A"  >
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <label for="formGroupExampleInput" class="form-label datos inputAnexos">Anexo 0B:</label>
                            <input type="file" class="form-control inputAnexos" name="anexo0B"  >
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <label for="formGroupExampleInput" class="form-label datos inputAnexos">Anexo XVI:</label>
                            <input type="file" class="form-control inputAnexos" name="anexoXVI"  >
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <label for="formGroupExampleInput" class="form-label datos">Selecciona el ciclo en el que se asignará la empresa:</label><br>
                            <div class="form-check-inline">
                                <input class="form-check-input" type="checkbox" id="flexCheckChecked" name="ciclo[]" value="FPB">
                                <label class="form-check-label text-light" for="flexRadioDefault1"> FPB </label>
                            </div>
                            <div class="form-check-inline">
                                <input class="form-check-input" type="checkbox" id="flexCheckChecked" name="ciclo[]" value="SMR">
                                <label class="form-check-label text-light" for="flexRadioDefault1"> SMR </label>
                            </div>
                            <div class="form-check-inline">
                                <input class="form-check-input" type="checkbox" id="flexCheckChecked" name="ciclo[]" value="DAM">
                                <label class="form-check-label text-light" for="flexRadioDefault1"> DAM </label>
                            </div>
                            <div class="form-check-inline">
                                <input class="form-check-input" type="checkbox" id="flexCheckChecked" name="ciclo[]" value="DAW">
                                <label class="form-check-label text-light" for="flexRadioDefault1"> DAW </label>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="telefonoEmpresa">
                        <div class="col-lg-4 col-md-6 col-sm-12" id="anteriortelefono">   
                            <label for="telefono" class="form-label datos">Número de teléfono: </label>
                            <input type="number" class="form-control" name="telefono[]" id="telefono">
                        </div>
                        <div class="añadirInput" id="posteriortelefono">
                            <a class="btn btn-primary" name="borrarTLF" id="borrarTLF"><i class="bi bi-dash-lg"></i></a>
                            <a class="btn btn-primary" name="crearTLF" id="crearTLF"><i class="bi bi-plus-lg"></i></a>
                        </div>
                    </div>

                    <div class="row" id="correoEmpresa">
                        <div class="col-lg-4 col-md-6 col-sm-12" id="anteriorcorreo">   
                            <label for="correo" class="form-label datos">Correo electrónico: </label>
                            <input type="text" class="form-control" name="correo[]" id="correo">
                        </div>
                        <div class="añadirInput" id="posteriorcorreo">
                            <a class="btn btn-primary" name="borrarCorreo" id="borrarCorreo"><i class="bi bi-dash-lg"></i></a>
                            <a class="btn btn-primary" name="crearCorreo" id="crearCorreo"><i class="bi bi-plus-lg"></i></a>
                        </div>
                    </div>

                    <div class="row pb-5">
                        <div class="col-12">
                            <button type="submit" class="btn botones-guardar" name="añadirEmpresa" id="crearEmpresa">Guardar cambios</button>
                        </div>
                    </div>
        </form>
    </section>

    <?php require "../Header-Footer/footer.php" ?>

</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php         if(isset($_SESSION["error_cod"]) && $_SESSION["error_cod"] == true) echo "<script type='text/javascript'>Swal.fire('Error', 'El código de empresa ya se encuentra en el sistema', 'error')</script>"; ?>