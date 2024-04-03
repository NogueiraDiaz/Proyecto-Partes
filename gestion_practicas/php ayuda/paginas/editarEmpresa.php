<?php
/* Función que muestra un formulario con los datos de la empresa: */
function mostrarDatos($db){
    try{
        // Consulta para seleccionar los datos de la empresa según el código que le pasamos:
        $empresas = $db->query("SELECT DISTINCT * FROM Empresas WHERE cod_empresa = '" . $_GET['cod_empresa'] . "'");
        $ciclosEmpresas = $db->query("SELECT DISTINCT ciclo FROM Ciclo_empresas WHERE cod_empresa = '" . $_GET['cod_empresa'] . "'");
        $tlfEmpresas = $db->query("SELECT DISTINCT telefono FROM Telefono_empresas WHERE cod_empresa = '" . $_GET['cod_empresa'] . "'");
        $correoEmpresas = $db->query("SELECT DISTINCT email FROM Mail_empresas WHERE cod_empresa = '" . $_GET['cod_empresa'] . "'");
        $arrayCiclos = [];

        foreach($ciclosEmpresas as $ciclo){
            $arrayCiclos[] = $ciclo['ciclo'];
        }
        
        //variable que retorno con los resultados obtenidos
        $resultados = '';

        // Condicional para ver que la consulta retorna resultados:
        if($empresas->rowCount() > 0){
            // Bucle para sacar los datos de la consulta:
            foreach($empresas as $empresa){
                // Añado a la variable los datos a retornar,
                // en este caso es un formulario el cual tiene como valores los datos
                // sacados de la base de datos para editarlos:
                $PHPSelf = htmlspecialchars($_SERVER["PHP_SELF"]) . "?cod_empresa=" . $_GET["cod_empresa"];
                $resultados .= "
                <form action='".$PHPSelf."' method='POST' enctype='multipart/form-data' id='formulario' class='text-white'>

                    <div class='row'>
                        <div class='col-lg-4 col-md-6 col-sm-12'>
                            <label for='formGroupExampleInput' class='form-label datos'>Tipo:</label>
                            <input type='text' class='form-control' name='tipo' value= " . $empresa['tipo'] . " >
                        </div>
                        <div class='col-lg-4 col-md-6 col-sm-12'>
                            <label for='formGroupExampleInput' class='form-label datos'>Responsable:</label>
                            <input type='text' class='form-control' name='responsable' value= " . $empresa['respo_empresa'] . " >
                        </div>
                        <div class='col-lg-4 col-md-6 col-sm-12'>
                            <label for='formGroupExampleInput' class='form-label datos'>DNI del responsable:</label>
                            <input type='text' class='form-control' name='dni' value= " . $empresa['dni_responsable'] . " id='dni'>
                        </div>

                    <div class='col-lg-4 col-md-6 col-sm-12'>
                            <label for='formGroupExampleInput' class='form-label datos'>Nombre empresa:</label>
                            <input type='text' class='form-control' name='nombre' value= '" . $empresa['nombre_empresa'] . "'>
                        </div>
                        <div class='col-lg-4 col-md-6 col-sm-12'>
                            <label for='formGroupExampleInput' class='form-label datos'>Localidad:</label>
                            <input type='text' class='form-control' name='localidad' value= '" .  $empresa['localidad_empresa'] . "'>
                        </div>
                        <div class='col-lg-4 col-md-6 col-sm-12'>
                            <label for='formGroupExampleInput' class='form-label datos'>Provincia:</label>
                            <input type='text' class='form-control' name='provincia' value= '" . $empresa['provincia_empresa'] . "' id='provincia'>
                        </div>

                        <div class='col-lg-4 col-md-6 col-sm-12'>
                            <label for='formGroupExampleInput' class='form-label datos'>Dirección:</label>
                            <input type='text' class='form-control' name='direccion' value= '" . $empresa['direcc_empresa'] . "'>
                        </div>
                        <div class='col-lg-4 col-md-6 col-sm-12'>
                            <label for='formGroupExampleInput' class='form-label datos'>Código Postal:</label>
                            <input type='number' class='form-control' name='cp' value= '" . $empresa['cp_empresa'] . "' id='CP'>
                        </div>
                        <div class='col-lg-4 col-md-6 col-sm-12'>
                            <label for='formGroupExampleInput' class='form-label datos'>CIF:</label>
                            <input type='text' class='form-control' name='cif' value = '" . $empresa['cif_empresa'] . "' id='CIF'>
                        </div>

                        <div class='col-lg-6 col-md-6 col-sm-12'>
                            <label for='formGroupExampleInput' class='form-label datos'>Localidad firma:</label>
                            <input type='text' class='form-control' name='localidadFirma' value= '" . $empresa['localidad_firma'] . "' id='localidad'>
                        </div>
                        <div class='col-lg-6 col-sm-12'>
                            <label for='formGroupExampleInput' class='form-label datos'>Fecha firma:</label>
                            <input type='date' class='form-control' name='fechaFirma' value= '" .$empresa['fecha_firma'] . "'>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-lg-6 col-sm-12'>
                            <label for='formGroupExampleInput' class='form-label datos'>Anexo 0:</label>
                            ". imprimeInputAnexo($empresa['anexo_0'], "anexo0") . "
                            <input type='file' class='form-control inputAnexos' name='anexo0'>
                        </div>
                        <div class='col-lg-6 col-sm-12'>
                            <label for='formGroupExampleInput' class='form-label datos'>Anexo 0A:</label>
                            ". imprimeInputAnexo($empresa['anexo_0a'], "anexo0A") . "
                            <input type='file' class='form-control inputAnexos' name='anexo0A'>
                        </div>
                        <div class='col-lg-6 col-sm-12'>
                            <label for='formGroupExampleInput' class='form-label datos'>Anexo 0B:</label>
                            ". imprimeInputAnexo($empresa['anexo_0b'], "anexo0B") . "
                            <input type='file' class='form-control inputAnexos' name='anexo0B'>
                        </div>
                        <div class='col-lg-6 col-sm-12'>
                            <label for='formGroupExampleInput' class='form-label datos'>Anexo XVI:</label>
                            ". imprimeInputAnexo($empresa['anexo_xvi'], "anexo16") . "
                            <input type='file' class='form-control inputAnexos' name='anexoXVI'>
                        </div>
                    </div>

                    <div class='row'>
                        <div class='col-12'>
                            <label for='formGroupExampleInput' class='form-label datos'>Selecciona el ciclo en el que se asignará la empresa:</label><br>
                            <div class='form-check-inline'>
                                <input class='form-check-input' type='checkbox' id='flexCheckChecked' name='ciclo[]' value='FPB' " . ((in_array('FPB', $arrayCiclos)) ? 'checked' : '' ) . ">
                                <label class='form-check-label text-light' for='flexRadioDefault1'> FPB </label>
                            </div>
                            <div class='form-check-inline'>
                                <input class='form-check-input' type='checkbox' id='flexCheckChecked' name='ciclo[]' value='SMR' " . ((in_array('SMR', $arrayCiclos)) ? 'checked' : '') . ">
                                <label class='form-check-label text-light' for='flexRadioDefault1'> SMR </label>
                            </div>
                            <div class='form-check-inline'>
                                <input class='form-check-input' type='checkbox' id='flexCheckChecked' name='ciclo[]' value='DAM' " . ((in_array('DAM', $arrayCiclos)) ? 'checked' : '') . ">
                                <label class='form-check-label text-light' for='flexRadioDefault1'> DAM </label>
                            </div>
                            <div class='form-check-inline'>
                                <input class='form-check-input' type='checkbox' id='flexCheckChecked' name='ciclo[]' value='DAW' " . ((in_array('DAW', $arrayCiclos)) ? 'checked' : '') . ">
                                <label class='form-check-label text-light' for='flexRadioDefault1'> DAW </label>
                            </div>
                        </div>
                    </div>
                ";
            }

            $resultados .= "<div class='row' id='telefonoEmpresa'>";


            $primerTelefono = true;
            foreach ($tlfEmpresas as $tlf) {
                if ($primerTelefono) {
                    $resultados .= "
                        <div class='col-lg-4 col-md-6 col-sm-12' id='anteriortelefono'>   
                            <label for='telefono' class='form-label datos'>Número de teléfono: </label>
                            <input type='number' class='form-control' name='telefono[]' id='telefono' value='".$tlf['telefono']."'>
                        </div>
                    ";
                    $primerTelefono = false;
                } else {
                    $resultados .= "
                        <div class='col-lg-4 col-md-6 col-sm-12' id='divtelefono'>   
                            <label for='telefono' class='form-label datos'>Número de teléfono: </label>
                            <input type='number' class='form-control' name='telefono[]' id='telefono' value='".$tlf['telefono']."'>
                        </div>
                    ";
                }
            }
            $resultados .= "
                    <div class='col-12 añadirInput' id='posteriortelefono'>
                        <a class='btn btn-primary' name='borrarTLF' id='borrarTLF'><i class='bi bi-dash-lg'></i></a>
                        <a class='btn btn-primary' name='crearTLF' id='crearTLF'><i class='bi bi-plus-lg'></i></a>
                    </div>
                </div>
                <div class='row' id='correoEmpresa'>
            ";

            $primerCorreo = true;
            foreach($correoEmpresas as $correo){
                if ($primerCorreo) {
                    $resultados .= "
                        <div class='col-lg-4 col-md-6 col-sm-12' id='anteriorcorreo'>   
                            <label for='correo' class='form-label datos'>Correo electrónico: </label>
                            <input type='text' class='form-control' name='correo[]' id='correo' value='".$correo['email']."'>
                        </div>
                    ";
                    $primerCorreo = false;
                } else {
                    $resultados .= "
                        <div class='col-lg-4 col-md-6 col-sm-12' id='divcorreo'>   
                            <label for='correo' class='form-label datos'>Correo electrónico: </label>
                            <input type='text' class='form-control' name='correo[]' id='correo' value='".$correo['email']."'>
                        </div>
                    ";
                }
            }
            $resultados .= "
                        <div class='col-12 añadirInput' id='posteriorcorreo'>
                            <a class='btn btn-primary' name='borrarCorreo' id='borrarCorreo'><i class='bi bi-dash-lg'></i></a>
                            <a class='btn btn-primary' name='crearCorreo' id='crearCorreo'><i class='bi bi-plus-lg'></i></a>
                        </div>
                    </div>

                        <div class='row'>
                                <button type='submit' class='btn botones-guardar mb-3' name='editarEmpresa' id='crearEmpresa'>Guardar cambios</button>
                        </div>
                </form>
            ";
        }
        // Mensaje en caso de que no encuentre nada en la base de datos:
        else{
            $resultados = 'No se ha encontrado ningún usuario';
        }

        // Retornamos el resultado:
        return $resultados;
    }
    catch (PDOException $e) {//en caso de fallo devuelve el mensaje de error de BBDD
        return 'Error en la base de datos '.$e->getMessage();
    }
}

/*----------------------------------------------CODIGO FUNCIONAL---------------------------------------------------------------------------- */

    /*VARIABLE GLOBAL*/
    $ruta = "empresas";   //se usa en el metodo subirAnexo para elegir la ruta en la que subir los archivos

    session_start();
    require_once("../Funciones/loginRequerido.php"); 
    
    require "../Funciones/anexos.php"; //funciones para crear carpetas y guardar anexos

    //realizo la conexión a la base de datos
    require_once '../../../archivosComunes/conexion.php';

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Comenzamos la transacción:
        $db->beginTransaction();

        $anexos =  $_FILES['anexo0']['name'] != null   ?    ", anexo_0='" . subirAnexo($ruta, $_POST["nombre"], "", "anexo0", $_POST["anexo00"]). "'"      : " ";
        $anexos .= $_FILES['anexo0A']['name'] != null  ?    ", anexo_0a='" . subirAnexo($ruta, $_POST["nombre"], "", "anexo0A", $_POST["anexo01"]). "'"    : " ";
        $anexos .= $_FILES['anexo0B']['name'] != null  ?    ", anexo_0b='" . subirAnexo($ruta, $_POST["nombre"], "", "anexo0B", $_POST["anexo02"]). "'"    : " ";
        $anexos .= $_FILES['anexoXVI']['name'] != null ?    ", anexo_xvi='" . subirAnexo($ruta, $_POST["nombre"], "", "anexoXVI", $_POST["anexo16"]). "'"  : " ";
        
        //Consulta para insertar los datos:
        $consulta = "UPDATE `Empresas` SET `tipo` = '".$_POST["tipo"]."', `respo_empresa` = '".$_POST["responsable"]."', `dni_responsable` = '".$_POST["dni"]."',
        `nombre_empresa` = '".$_POST["nombre"]."', `localidad_empresa` = '".$_POST["localidad"]."', `provincia_empresa` = '".$_POST["provincia"]."',
        `direcc_empresa` = '".$_POST["direccion"]."', `cp_empresa` = '".$_POST["cp"]."', `cif_empresa` = '".$_POST["cif"]."', `localidad_firma` = '".$_POST["localidadFirma"]."',
        `fecha_firma` = '".$_POST["fechaFirma"]."' $anexos WHERE `Empresas`.`cod_empresa` = '".$_GET['cod_empresa']."';";

        $empresas = $db->query($consulta);

        $borrarCiclos = "DELETE FROM Ciclo_empresas WHERE cod_empresa = '" . $_GET['cod_empresa'] . "';";
        $borrarTelefonos = "DELETE FROM Telefono_empresas WHERE cod_empresa = '" . $_GET['cod_empresa'] . "';";
        $borrarCorreos = "DELETE FROM Mail_empresas WHERE cod_empresa = '" . $_GET['cod_empresa'] . "';";
        $cicloAntiguo = $db->query($borrarCiclos);
        $telefonoAntiguo = $db->query($borrarTelefonos);
        $correoAntiguo = $db->query($borrarCorreos);

        $error = false;

        foreach ($_POST["ciclo"] as $cicloElegido) {
            $consultaInsertar = "INSERT INTO Ciclo_empresas (cod_empresa, ciclo) VALUES ('" . $_GET['cod_empresa'] . "', '$cicloElegido');";
            $cicloNuevo = $db->query($consultaInsertar);
            if(!$cicloNuevo){
                echo "<br> Error: " . print_r($db->errorInfo()) . "<br>";
                $db->rollBack();
                echo "<br> Transacción anulada <br>";
            }
        }

        foreach ($_POST["telefono"] as $num) {
            $consulta = "INSERT INTO `Telefono_empresas` (`cod_empresa`, `telefono`) VALUES ('" . $_GET['cod_empresa'] . "', '$num');";
            $result = $db->query($consulta);
            if (!$result) {
                $error = true;
                break;
            }
        }

        foreach ($_POST["correo"] as $correo) {
            $consulta2 = "INSERT INTO `Mail_empresas` (`cod_empresa`, `email`) VALUES ('" . $_GET['cod_empresa'] . "', '$correo');";
            $result = $db->query($consulta2);

            if (!$result) {
                $error = true;
                break;
            }
        }
        
        // Si no encuentra nada muestra el error y realiza el rollBack para deshacer los cambios:
        if(!$empresas || !$cicloAntiguo || !$telefonoAntiguo || !$correoAntiguo || $error){
            echo "<br> Error: " . print_r($db->errorInfo()) . "<br>";
            $db->rollBack();
            echo "<br> Transacción anulada <br>";
        }
        else{
            //Si hubiera ido bien:
            $db->commit();
            header("Location: mostrarEmpresas.php");
        }
    }


?>


<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <link rel='stylesheet' href='../../css/bootstrap.min.css'>
    <link rel='stylesheet' href='../../css/custom.css'>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css'>

    <script type="text/javascript" src="../../js/bootstrap.bundle.min.js" defer></script>
    <script type="text/javascript" src="../../js/patrones.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <title>Editar empresa</title>
</head>

<body>
    <?php require "../Header-Footer/header.php"; ?>

    <!-- Llamo a la función para mostrar los datos: -->
    <section class="central-form">
        <?php echo mostrarDatos($db) ?>
    </section>

    <?php require "../Header-Footer/footer.php" ?>
</body>
</html>