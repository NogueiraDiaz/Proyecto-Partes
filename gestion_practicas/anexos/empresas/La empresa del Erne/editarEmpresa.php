<?php

    /* session_start();
    if(!isset($_SESSION['email'])){
        header('Location: ../../loginNerea.php?redirigido=true');
    } */

    /* Función para editar los datos: */
    function editarEmpresa(){
        try{
            //realizo la conexión a la base de datos
            $db = require_once 'conexion.php';

            // Consulta para seleccionar los datos de la empresa según el código que le pasamos:
            $empresas = $db->query("SELECT * FROM empresa WHERE COD_EMPRESA = " . $_GET['COD_EMPRESA'] . " ");

            //variable que retorno con los resultados obtenidos
            $resultados = '';

            // Condicional para ver que la consulta retorna resultados:
            if($empresas->rowCount() > 0){
                // Bucle para sacar los datos de la consulta:
                foreach($empresas as $empresa){
                    // Añado a la variable los datos a retornar,
                    // en este caso es un formulario el cual tiene como valores los datos
                    // sacados de la base de datos para editarlos:
                    $resultados .= "
                    <form action='guardarCambios.php' method='POST'>

                    <div class='row camposEmpresa'>
                        <div class='col'>
                            <label for='formGroupExampleInput' class='form-label datos'>Tipo:</label>
                            <input type='text' class='form-control' name='tipo' value= " . $empresa['TIPO'] . " required pattern=''>
                        </div>
                        <div class='col'>
                            <label for='formGroupExampleInput' class='form-label datos'>Responsable:</label>
                            <input type='text' class='form-control' name='responsable' value= " . $empresa['RESPO_EMPRESA'] . " required pattern=''>
                        </div>
                        <div class='col'>
                            <label for='formGroupExampleInput' class='form-label datos'>DNI del responsable:</label>
                            <input type='text' class='form-control' name='dni' value= " . $empresa['DNI_RESPONSABLE'] . " required pattern=''>
                        </div>
                    </div>

                    <div class='row camposEmpresa'>
                    <div class='col'>
                            <label for='formGroupExampleInput' class='form-label datos'>Nombre empresa:</label>
                            <input type='text' class='form-control' name='nombre' value= " . $empresa['NOMBRE_EMPRESA'] . " required pattern=''>
                        </div>
                        <div class='col'>
                            <label for='formGroupExampleInput' class='form-label datos'>Localidad:</label>
                            <input type='text' class='form-control' name='localidad' value= " .  $empresa['LOCALIDAD_EMPRESA'] . " required pattern=''>
                        </div>
                        <div class='col'>
                            <label for='formGroupExampleInput' class='form-label datos'>Provincia:</label>
                            <input type='text' class='form-control' name='provincia' value= " . $empresa['PROVINCIA_EMPRESA'] . " required pattern=''>
                        </div>
                    </div>

                    <div class='row camposEmpresa'>
                        <div class='col'>
                            <label for='formGroupExampleInput' class='form-label datos'>Dirección:</label>
                            <input type='text' class='form-control' name='direccion' value= " . $empresa['DIRECC_EMPRESA'] . " required pattern=''>
                        </div>
                        <div class='col'>
                            <label for='formGroupExampleInput' class='form-label datos'>Código Postal:</label>
                            <input type='text' class='form-control' name='cp' value= " . $empresa['CP_EMPRESA'] . " required pattern=''>
                        </div>
                        <div class='col'>
                            <label for='formGroupExampleInput' class='form-label datos'>CIF:</label>
                            <input type='text' class='form-control' name='cif' value = " . $empresa['CIF_EMPRESA'] . " required pattern=''>
                        </div>
                    </div>

                    <div class='row camposEmpresa'>
                    <div class='col'>
                            <label for='formGroupExampleInput' class='form-label datos'>Localidad firma:</label>
                            <input type='text' class='form-control' name='localidadFirma' value= " . $empresa['LOCALIDAD_FIRMA'] . " required pattern=''>
                        </div>
                        <div class='col'>
                            <label for='formGroupExampleInput' class='form-label datos'>Fecha firma:</label>
                            <input type='date' class='form-control' name='fechaFirma' value= " .$empresa['FECHA_FIRMA'] . " required pattern=''>
                        </div>
                    </div>

                    <div class='row camposEmpresa'>
                    <div class='col'>
                            <label for='formGroupExampleInput' class='form-label datos'>Anexo 0:</label>
                            <input type='file' class='form-control' name='anexo0' value= " . $empresa['ANEXO_0'] . " required pattern=''>
                        </div>
                        <div class='col'>
                            <label for='formGroupExampleInput' class='form-label datos'>Anexo 0A:</label>
                            <input type='file' class='form-control' name='anexo0A' value= " . $empresa['ANEXO_0A'] . "required pattern=''>
                        </div>
                    <div class='col'>
                            <label for='formGroupExampleInput' class='form-label datos'>Anexo 0B:</label>
                            <input type='file' class='form-control' name='anexo0B' value= " . $empresa['ANEXO_0B'] . "required pattern=''>
                        </div>
                        <div class='col'>
                            <label for='formGroupExampleInput' class='form-label datos'>Anexo XVI:</label>
                            <input type='file' class='form-control' name='anexoXVI' value= " . $empresa['ANEXO_XVI'] . "required pattern=''>
                        </div>
                    </div>

                    <div class='row camposEmpresa'>
                        <button type='submit' class='btn btn-primary' name='editarEmpresa'>Guardar cambios</button>
                    </div>
        </form>";
                }
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
?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <link rel='stylesheet' href='../css/bootstrap.min.css'>
    <link rel='stylesheet' href='../css/custom.css'>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css'>
    <script type='text/javascript' src='../js/bootstrap.bundle.min.js'></script>
    <title>Editar usuario</title>
</head>

<body>
    <header>
    <nav class='navbar bg-dark position-fixed z-3 w-100'>
        <div class='container-fluid'>
            <img src='../img/julioverne.png' width='70' height='58' class='d-inline-block align-text-top m-2'>
            <h1>IES Julio Verne (Bargas - Toledo)</h1>
            <form class='d-flex' role='search' method='POST' action=''>
                <input class='form-control me-2' type='text' placeholder='Buscar' name='usuarioBuscado'>
                <button class='btn btn-outline-primary me-2' type='submit'>Buscar</button>
            </form>
            <!-- Debe redirigir al login al salir -->
            <button class='btn btn-outline-primary enlacesSalida '><a href=''><i class='bi bi-arrow-left-circle'></i></a></button>
            <button class='btn btn-outline-primary enlacesSalida'><a href=''><i class='bi bi-box-arrow-right'></i></a></button>            
        </div>
    </nav>
    </header>

    <!-- Llamo a la función para mostrar los datos: -->
    <section class='listado'>   
        <?php echo editarEmpresa() ?>
    </section>
</body>


</html>