<?php

    session_start();
    //miro si el usuario está loggeado para redirigirlo en caso contrario
    require_once("../Funciones/loginRequerido.php"); 


    // Llamo al archivo donde tenemos la función que mostrará las empresas que hay.
    require "../Funciones/desplegables.php"; 
    require "../Funciones/anexos.php";


    $ruta = "alumnos";  //variable que uso para decidir la ruta a la que subir los anexos


    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Obtener los valores del formulario:
        $cod_empresa = $_POST["empresas"];
        $cod_usuario = $_SESSION["usuario_login"]["cod_usuario"];
        $cod_alumno = $_GET["cod_alumno"];
        
        $f_inicio = $_POST["inicioBeca"];
        $f_fin = $_POST["finBeca"];
        $tutor = $_POST["tutor"];
        $ciclo = $_POST["cicloAlumno"];

        // Obtener el nombre del alumno y el ciclo
        $sql = "SELECT nombre FROM Alumnos WHERE cod_alumno = '$cod_alumno'";
        $consulta = $db->query($sql);
        $fila = $consulta->fetch();
        $nombre_alumno = $fila["nombre"];

        //Se comprueban
        $anexo1 = $_FILES['anexo1']['name'] != null ? subirAnexo($ruta, $nombre_alumno, $ciclo, "anexo1") : " ";
        $anexo2 = $_FILES['anexo2']['name'] != null ? subirAnexo($ruta, $nombre_alumno, $ciclo, "anexo2") : " ";
        $anexo4 = $_FILES['anexo4']['name'] != null ? subirAnexo($ruta, $nombre_alumno, $ciclo, "anexo4") : " ";
        $anexo5 = $_FILES['anexo5']['name'] != null ? subirAnexo($ruta, $nombre_alumno, $ciclo, "anexo5") : " ";
        $anexo6 = $_FILES['anexo6']['name'] != null ? subirAnexo($ruta, $nombre_alumno, $ciclo, "anexo6") : " ";
        $anexo6bis = $_FILES['anexo6bis']['name'] != null ? subirAnexo($ruta, $nombre_alumno, $ciclo, "anexo6bis") : " ";
        $anexo7 = $_FILES['anexo7']['name'] != null ? subirAnexo($ruta, $nombre_alumno, $ciclo, "anexo7") : " ";
        $anexo9 = $_FILES['anexo9']['name'] != null ? subirAnexo($ruta, $nombre_alumno, $ciclo, "anexo9") : " ";
        $anexo11 = $_FILES['anexo11']['name'] != null ? subirAnexo($ruta, $nombre_alumno, $ciclo, "anexo11") : " ";
        $anexo12 = $_FILES['anexo12']['name'] != null ? subirAnexo($ruta, $nombre_alumno, $ciclo, "anexo12") : " ";
        $anexo15 = $_FILES['anexo15']['name'] != null ? subirAnexo($ruta, $nombre_alumno, $ciclo, "anexo15") : " ";


        if(!$anexo1 || !$anexo2 || !$anexo4 || !$anexo5 || !$anexo6 || !$anexo6bis || !$anexo7 || !$anexo9 || !$anexo11 || !$anexo12 || !$anexo15){
            echo "algo ha salido mal"; 
        } 
        else {
            $sql = "INSERT INTO Pertenece (cod_empresa, cod_usuario, cod_alumno, f_inicio_beca, f_fin_beca, 
            tutor_practicas, ciclo, anexo_i, anexo_ii, anexo_iv, anexo_v, anexo_vi, anexo_vibis, anexo_vii, anexo_ix, 
            anexo_xi, anexo_xii, anexo_xv)
            VALUES ('$cod_empresa', '$cod_usuario', '$cod_alumno', '$f_inicio', '$f_fin', '$tutor', '$ciclo', '$anexo1', 
            '$anexo2', '$anexo4', '$anexo5', '$anexo6', '$anexo6bis', '$anexo7', '$anexo9', '$anexo11', '$anexo12', '$anexo15')";
            $consulta = $db->query($sql);    

            // Ejecutar la consulta SQL
            if ($consulta) {
                echo "Los datos se han insertado correctamente";
                header ("Location: ../../index.php");
            } else {
                echo "Error al insertar los datos: " . $db->errorInfo()[2];
            }
        }
        // Cerrar la conexión
        $db = null;
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
    <title>Añadir empresa</title>
</head>

<body class="cuerpo">
    <?php require "../Header-Footer/header.php"; ?>

    <section class="central-form">  
    <h3>Asignar Empresa</h3> 
        <!-- Formulario para asignar las empresas: -->
        <form class="container-fluid pt-4 text-white central-form" id="formulario"
            action="<?php echo $_SERVER['PHP_SELF'] . "?cod_alumno=" . $_GET["cod_alumno"] . "&ciclo=" . $_GET["ciclo"] ?>" method="POST" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label for="formGroupExampleInput" class="form-label datos">Empresa:</label>
                            <?php
                                echo obtenerEmpresaCiclo($db, $_GET["ciclo"]);
                            ?>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label for="formGroupExampleInput" class="form-label datos">Tutor de prácticas:</label>
                            <input type="text" class="form-control" name="tutor" >
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <label for="formGroupExampleInput" class="form-label datos">Ciclo:</label>
                            <input type="text" name='cicloAlumno' class="form-control" value="<?php echo $_GET["ciclo"] ?>" readonly></input>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="formGroupExampleInput" class="form-label datos">Fecha Inicio de Beca:</label>
                            <input type="date" class="form-control" name="inicioBeca" id="inicioBeca">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="formGroupExampleInput" class="form-label datos">Fecha Fin de Beca:</label>
                            <input type="date" class="form-control" name="finBeca" id="finBeca">
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label for="formGroupExampleInput" class="form-label datos">Anexo_I:</label>
                            <input type="file" class="form-control inputAnexos" name="anexo1" >
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label for="formGroupExampleInput" class="form-label datos">Anexo_II:</label>
                            <input type="file" class="form-control inputAnexos" name="anexo2">
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label for="formGroupExampleInput" class="form-label datos">Anexo_IV:</label>
                            <input type="file" class="form-control inputAnexos" name="anexo4">
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label for="formGroupExampleInput" class="form-label datos">Anexo_V:</label>
                            <input type="file" class="form-control inputAnexos" name="anexo5">
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label for="formGroupExampleInput" class="form-label datos">Anexo_VI:</label>
                            <input type="file" class="form-control inputAnexos" name="anexo6">
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label for="formGroupExampleInput" class="form-label datos">Anexo_VIbis:</label>
                            <input type="file" class="form-control inputAnexos" name="anexo6bis">
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label for="formGroupExampleInput" class="form-label datos">Anexo_VII:</label>
                            <input type="file" class="form-control inputAnexos" name="anexo7">
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label for="formGroupExampleInput" class="form-label datos">Anexo_IX:</label>
                            <input type="file" class="form-control inputAnexos" name="anexo9">
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label for="formGroupExampleInput" class="form-label datos">Anexo_XI:</label>
                            <input type="file" class="form-control inputAnexos" name="anexo11">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="formGroupExampleInput" class="form-label datos">Anexo_XII:</label>
                            <input type="file" class="form-control inputAnexos" name="anexo12">
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <label for="formGroupExampleInput" class="form-label datos">Anexo_XV:</label>
                            <input type="file" class="form-control inputAnexos" name="anexo15">
                        </div>
                    </div>
                </div>

                    <div class="row pb-5">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button type="submit" class="btn botones-guardar" name="asignarEmpresa" id="asignar">Guardar cambios</button>
                        </div>
                    </div>
        </form>
    </section>

    <?php require "../Header-Footer/footer.php" ?>

</body>
</html>
