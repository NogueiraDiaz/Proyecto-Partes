<?php
/*--------------------------------------------FUNCIONES----------------------------------------------------------------- */
    function mostrarDatos($db){
        try{
            $cod_empresa = $_GET["cod_empresa"];
            $cod_alumno = $_GET["cod_alumno"];

            //aqui obtengo el nombre de la empresa para mostrarlo por pantalla
            $nombreEmpresa = $db->query("SELECT NOMBRE_EMPRESA FROM empresa WHERE COD_EMPRESA='$cod_empresa'")->fetch()["NOMBRE_EMPRESA"];

            $empresa = $db->query("SELECT * FROM pertenece WHERE COD_ALUMNO ='$cod_alumno'")->fetch();

            //variable donde almaceno la URL para enviar los datos
            $URL = $_SERVER['PHP_SELF'] . "?COD_EMPRESA=$cod_empresa&COD_ALUMNO=$cod_alumno&CICLO=" . $_GET["CICLO"];
            // Añado a la variable los datos a retornar, en este caso es un formulario el cual tiene como valores los datos
            // sacados de la base de datos para editarlos:
            $resultados = "
            <form action = '$URL' method='POST' enctype='multipart/form-data' class='container-fluid text-white' id='formulario'>
            
                <div class='row'>
                    <div class='col-lg-4 col-md-6 col-sm-12'>
                        <label for='formGroupExampleInput' class='form-label datos'>Tutor de prácticas:</label>
                        <input type='text' class='form-control' name='tutor' value= '" . $empresa['TUTOR_PRACTICAS'] . "' required>
                    </div>
                    <div class='col-lg-4 col-md-6 col-sm-12'>
                        <label for='formGroupExampleInput' class='form-label datos'>Empresa:</label> 
                        <input type='text' class='form-control' value='$nombreEmpresa' readonly>
                    </div>
                    <div class='col-lg-4 col-sm-12'>
                        <label for='formGroupExampleInput' class='form-label datos'>Ciclo:</label>
                        <input type='text' class='form-control' value='". $_GET["CICLO"]."' readonly>
                    </div>
                </div>

                <div class='row '>
                    <div class='col-lg-6 col-md-6 col-sm-12'>
                        <label for='formGroupExampleInput' class='form-label datos'>Fecha Inicio de Beca:</label>
                        <input type='date' class='form-control' name='inicioBeca' id='inicioBeca' value= '" . $empresa['F_INICIO_BECA'] . "' required>
                    </div>
                    <div class='col-lg-6 col-md-6 col-sm-12'>
                        <label for='formGroupExampleInput' class='form-label datos'>Fecha Fin de Beca:</label>
                        <input type='date' class='form-control' name='finBeca' id='finBeca' value= '" . $empresa['F_FIN_BECA'] . "' required>
                    </div>
                </div>


                <div class='row' id='anexos'>
                    <div class='col-lg-4 col-md-6 col-sm-12'>
                        <label for='formGroupExampleInput' class='form-label datos'>Anexo_I:</label>"
                        . imprimeInputAnexo($empresa['ANEXO_I'], "anexo1") . "
                        <input type='file' class='form-control inputAnexos' name='anexoI'>
                    </div>
                    <div class='col-lg-4 col-md-6 col-sm-12'>
                        <label for='formGroupExampleInput' class='form-label datos'>Anexo_II:</label>
                        " .imprimeInputAnexo($empresa['ANEXO_II'], "anexo2") . "
                        <input type='file' class='form-control inputAnexos' name='anexoII'>
                    </div>
                    <div class='col-lg-4 col-md-6 col-sm-12'>
                        <label for='formGroupExampleInput' class='form-label datos'>Anexo_IV:</label>
                        " .imprimeInputAnexo($empresa['ANEXO_IV'], "anexo4") . "
                        <input type='file' class='form-control inputAnexos' name='anexoIV'>
                    </div>

                    <div class='col-lg-4 col-md-6 col-sm-12'>
                        <label for='formGroupExampleInput' class='form-label datos'>Anexo_V:</label>"
                        . imprimeInputAnexo($empresa['ANEXO_V'], "anexo5") . "
                        <input type='file' class='form-control inputAnexos' name='anexoV'>
                    </div>
                    <div class='col-lg-4 col-md-6 col-sm-12'>
                        <label for='formGroupExampleInput' class='form-label datos'>Anexo_VI:</label>"
                        . imprimeInputAnexo($empresa['ANEXO_VI'], "anexo6") . "
                        <input type='file' class='form-control inputAnexos' name='anexoVI'>
                    </div>
                    <div class='col-lg-4 col-md-6 col-sm-12'>
                        <label for='formGroupExampleInput' class='form-label datos'>Anexo_VIbis:</label>"
                        . imprimeInputAnexo($empresa['ANEXO_VIbis'], "anexo6bis") . "
                        <input type='file' class='form-control inputAnexos' name='anexoVIbis'>
                    </div>
                    <div class='col-lg-4 col-md-6 col-sm-12'>
                        <label for='formGroupExampleInput' class='form-label datos'>Anexo_VII:</label>"
                        . imprimeInputAnexo($empresa['ANEXO_VII'], "anexo7") . "
                        <input type='file' class='form-control inputAnexos' name='anexoVII'>
                    </div>

                    <div class='col-lg-4 col-md-6 col-sm-12'>
                        <label for='formGroupExampleInput' class='form-label datos'>Anexo_IX:</label>"
                        . imprimeInputAnexo($empresa['ANEXO_IX'], "anexo9") . "
                        <input type='file' class='form-control inputAnexos' name='anexoIX'>
                    </div>
                    <div class='col-lg-4 col-md-6 col-sm-12'>
                        <label for='formGroupExampleInput' class='form-label datos'>Anexo_XI:</label>"
                        . imprimeInputAnexo($empresa['ANEXO_XI'], "anexo11") . "
                        <input type='file' class='form-control inputAnexos' name='anexoXI'>
                    </div>
                    <div class='col-lg-6 col-md-6 col-sm-12'>
                        <label for='formGroupExampleInput' class='form-label datos'>Anexo_XII:</label>"
                        . imprimeInputAnexo($empresa['ANEXO_XII'], "anexo12") . "
                        <input type='file' class='form-control inputAnexos' name='anexoXII'>
                    </div>
                    <div class='col-lg-6 col-sm-12'>
                        <label for='formGroupExampleInput' class='form-label datos'>Anexo_XV:</label>"
                        . imprimeInputAnexo($empresa['ANEXO_XV'], "anexo15") . "
                        <input type='file' class='form-control inputAnexos' name='anexoXV'>
                    </div>
                </div>

                <hr class='text-white'>";
            
                $resultados .= "<div class='row pb-3' id='anexos'><div class='col-lg-12 col-md-12 col-sm-12'><a href='insertarAnexos.php?COD_ALUMNO=" . $_GET["COD_ALUMNO"] . "&COD_EMPRESA=" . $_GET["COD_EMPRESA"] . "&CICLO=" . $_GET["CICLO"] . "&COD_USUARIO=" . $empresa["COD_USUARIO"] . 
                            "' class='btn btn-secondary w-100'> Insertar Anexos 3</a></div>";
    
                $resultados .= sacarAnexos($db);
    
                $resultados .= "<div class='row pt-3 pb-5'><div class='col-lg-12 col-md-12 col-sm-12'>
                <button type='submit' class='btn botones-guardar' name='editarEmpresaAsignada' id='asignar'>Actualizar cambios</button>
            </div></div></form>";
    
            // Retornamos el resultado:
            return $resultados;
        
        }
        catch (PDOException $e) {//en caso de fallo devuelve el mensaje de error de BBDD
            return 'Error en la base de datos '.$e->getMessage();
        }
    }
    
    
    /*--------------------------------------------CODIGO FUNCIONAL----------------------------------------------------------------- */
    
    session_start();
    //compruebo que el usuario está loggeado
    require_once("../Funciones/loginRequerido.php"); 
    
    // Llamo al archivo donde tenemos la función que mostrará las empresas que hay.
    require "../Funciones/desplegables.php";
    require "../Funciones/anexos.php";
    
    
    /*VARIABLE GLOBAL*/
    $ruta = "alumnos";   //se usa en el metodo subirAnexo para elegir la ruta en la que subir los archivos
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        //valores para hacer la obtención de datos
        $codAlumno = $_GET["COD_ALUMNO"];
        $ciclo = $_GET["CICLO"];
        $codEmpresa = $_POST["empresas"];
    
        $f_inicio = $_POST["inicioBeca"];
        $f_fin = $_POST["finBeca"];
        $tutor = $_POST["tutor"];
    
    
    
        // Obtener el nombre del alumno y el ciclo
        $nombre_alumno = $db->query("SELECT NOMBRE FROM alumno WHERE COD_ALUMNO = '$codAlumno'")->fetch()["NOMBRE"];
    
    
        //Aqui miramos todos los anexos y si alguno contiene datos añado a una variable un trozo de consulta SQL
        $anexos =   $_FILES['anexoI']['name'] != null ?   ", ANEXO_I='" .   subirAnexo($ruta, $nombre_alumno, $ciclo, "anexoI", $_POST["anexo1"]) .  "'" : " ";
        $anexos .=  $_FILES['anexoII']['name'] != null ?  ", ANEXO_II='" .  subirAnexo($ruta, $nombre_alumno, $ciclo, "anexoII", $_POST["anexo2"]) . "'" : " ";
        $anexos .=  $_FILES['anexoIV']['name'] != null ?  ", ANEXO_IV='" . subirAnexo($ruta, $nombre_alumno, $ciclo, "anexoIV", $_POST["anexo4"]) ."'" : " ";
        $anexos .=  $_FILES['anexoV']['name'] != null ?  ", ANEXO_V='" . subirAnexo($ruta, $nombre_alumno, $ciclo, "anexoV", $_POST["anexo5"]) ."'" : " ";
        $anexos .=  $_FILES['anexoVI']['name'] != null ?  ", ANEXO_VI='" . subirAnexo($ruta, $nombre_alumno, $ciclo, "anexoVI", $_POST["anexo6"]) ."'" : " ";
        $anexos .=  $_FILES['anexoVIbis']['name'] != null ?  ", ANEXO_VIbis='" . subirAnexo($ruta, $nombre_alumno, $ciclo, "anexoVIbis", $_POST["anexo6bis"]) ."'" : " ";
        $anexos .=  $_FILES['anexoVII']['name'] != null ?  ", ANEXO_VII='" . subirAnexo($ruta, $nombre_alumno, $ciclo, "anexoVII", $_POST["anexo7"]) ."'" : " ";
        $anexos .=  $_FILES['anexoIX']['name'] != null ?  ", ANEXO_IX='" . subirAnexo($ruta, $nombre_alumno, $ciclo, "anexoIX", $_POST["anexo9"]) ."'" : " ";
        $anexos .=  $_FILES['anexoXI']['name'] != null ?  ", ANEXO_XI='" . subirAnexo($ruta, $nombre_alumno, $ciclo, "anexoXI", $_POST["anexo11"]) ."'" : " ";
        $anexos .=  $_FILES['anexoXII']['name'] != null ?  ", ANEXO_XII='" . subirAnexo($ruta, $nombre_alumno, $ciclo, "anexoXII", $_POST["anexo12"]) ."'" : " ";
        $anexos .=  $_FILES['anexoXV']['name'] != null ?  ", ANEXO_XV='" . subirAnexo($ruta, $nombre_alumno, $ciclo, "anexoXV", $_POST["anexo15"]) ."'" : " ";
    
    
        //consulta a realizar para actualizar los datos de la tabla pertenece
        $sql = "UPDATE pertenece SET F_INICIO_BECA = '$f_inicio', F_FIN_BECA = '$f_fin', TUTOR_PRACTICAS = '$tutor'" . 
                $anexos ." WHERE COD_ALUMNO = '$codAlumno' AND COD_EMPRESA = '". $_GET["COD_EMPRESA"]."'";
    

        //SECCION DONDE ACTUALIZO LOS ANEXOS 3 MODIFICADOS
        //comienzo recorriendo todos los anexos 3 de la página, el numero lo guardo en una variable de sesion que creo al añadir los anexos en el metodo sacarAnexos
        for($i = 1; $i <= $_SESSION["n_Anexos3"] ; $i++){
            //primero compruebo que ha introducido un documento
            if($_FILES["anexo3_$i"]["name"] != null){
                $rutaArchivo = subirAnexo3($nombre_alumno, $ciclo, $_FILES["anexo3_$i"]["name"], $_FILES["anexo3_$i"]["tmp_name"], $_POST["anexo3_$i"]);
    
                if ($rutaArchivo) {
                    try{
                        $consulta = $db->query("UPDATE anexoiii_pertenece SET ANEXO_III = '$rutaArchivo' WHERE ANEXO_III LIKE '%".$_POST["anexo3_$i"] ."' AND COD_EMPRESA = '". $_GET["COD_EMPRESA"] ."' AND COD_ALUMNO = '". $_GET["COD_ALUMNO"] ."'");
                    }
                    catch(Exception $e){
                        echo "Error al insertar el anexo: " . $e->message();
                    }
                } else {
                    echo "Error al mover el archivo $i a la carpeta del alumno";
                }
            }
        }

    
        try{
            $insercion = $db->query($sql);
    
            if ($insercion) {
                header("Location: mostrarAsignados.php");
            } else {
                echo "<script>alert('Error al actualizar los datos, contacte con un administrador')</script>";
                header("Location: mostrarAsignados.php");
            }    
        } catch (PDOException $e) {//en caso de fallo devuelve el mensaje de error de BBDD
            echo "Error en la base de datos ".$e->getMessage();
            //en caso de fallo comente las siguientes dos lineas para comprobar el error
            echo "<script>alert('Error al actualizar los datos, contacte con un administrador')</script>";
            header("Location: mostrarAsignados.php");
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
    <title>Editar Asignado</title>
    </head>
    
    <body>
    <?php
        require "../Header-Footer/header.php";
        try{
            $nombreAlumno = $db->query("SELECT NOMBRE, APELLIDOS FROM alumno WHERE COD_ALUMNO = '". $_GET["COD_ALUMNO"] ."'")->fetch();
            echo "<h3 style='text-align:center;'>Editando datos del alumno ".$nombreAlumno["NOMBRE"] ." ". $nombreAlumno["APELLIDOS"]."</h3>";
        }
        catch (PDOException $e) {//en caso de fallo devuelve el mensaje de error de BBDD
            echo 'Error al recuperar nombre de alumno:  '.$e->getMessage();
        }
    
    
    ?>
    <!-- Llamo a la función para mostrar los datos: -->
    <section class='central-form'>   
        <?php echo mostrarDatos($db) ?>
    </section>
    
    <?php require "../Header-Footer/footer.php"; ?>
    </body>
    </html>