<?php
// PHPoffice
require '../vendor/autoload.php';
// Conexion
require_once("../archivosComunes/conexion.php");
// Para acceder a esta pagina hay que iniciar sesion previamente.
// require_once('../archivosComunes/loginRequerido.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;


use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['archivo']) && !empty($_FILES['archivo']['name'][0])) {
        // Obtener el número de archivos seleccionados
        $numArchivos = count($_FILES['archivo']['name']);

        // Recorrer cada archivo
        for ($i = 0; $i < $numArchivos; $i++) {
            $rutaArchivo = $_FILES['archivo']['tmp_name'][$i];
            $cod_excel = $_FILES['archivo']['name'][$i];

            // Cargar el archivo XLSX
            $documento = IOFactory::load($rutaArchivo);

            // Obtener la primera hoja del documento
            $hoja = $documento->getActiveSheet();
            $profesor = $hoja->getCell("A1")->getValue();
            $separarcoma = explode(",", $profesor);
            $apellidos = $separarcoma[0];
            $nombre = explode(" (", $separarcoma[1])[0];

            for ($y = 3; $y < 15; $y++) { 
                $a = 'B';
                for ($x = 0; $x < 5; $x++) { 
                    $dia = $hoja->getCell($a . "2")->getValue();
                    $hora = $hoja->getCell('A'. $y)->getValue();
                    $contenido = $hoja->getCell($a . $y)->getValue();
                    
                    if(($contenido != "recreo") && ($contenido != "RECREO")){
                        if(!empty($hora)){
                        $separarhora =  explode("\n", $hora);
                        $horainicio = $separarhora[0];
                        $horafin = $separarhora[1];
                    

                    // echo $cod_excel . ' ' . $nombre . ' ' . $apellidos . ' ' . $dia . ' ' . $horainicio . ' ' . $horafin . ' ' . $contenido . '<br>'; 

                    $a++;

                    $horainicio = date('H:i:s', strtotime($horainicio));
                    $horafin = date('H:i:s', strtotime($horafin));

                    $cod_excel = explode("_", $cod_excel)[0];
                    $delphos = intval($cod_excel);

                    // Consultar la tabla de usuario para obtener el nombre basado en el curso
                    $query = "SELECT cod_usuario FROM Usuarios WHERE cod_delphos = :delphos";
                    $stmt = $db->prepare($query);
                    $stmt->bindParam(':delphos', $delphos);
                    $stmt->execute();
                    $cod_usuario = $stmt->fetchColumn();

                    $insert = "INSERT INTO Horarios (nombre, apellidos, dia, cod_usuario, inicio, fin, clase, cod_delphos)
                    VALUES (:nombre, :apellidos, :dia, :cod_usuario, :inicio, :fin, :clase, :delphos)";
                    $stmt = $db->prepare($insert);
                    $stmt->bindParam(':nombre', $nombre);
                    $stmt->bindParam(':apellidos', $apellidos);
                    $stmt->bindParam(':dia', $dia);
                    if($cod_usuario==NULL){
                        $cod_usuario=null;
                    }
                    $stmt->bindParam(':cod_usuario', $cod_usuario);
                    $stmt->bindParam(':inicio', $horainicio);
                    $stmt->bindParam(':fin', $horafin);
                    $stmt->bindParam(':clase', $contenido);
                    $stmt->bindParam(':delphos', $delphos);

                    $stmt->execute(); 
                    
                }
            }
                }
            }
        }
    }
}



?>


<!DOCTYPE html>
<html>

<head>
    <title>Exportal excel</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>

<body>
    <?php
    include('../guardias/navguardias.php');

    ?>
    <div class="container mt-5" style="max-width: 500px;">
    <h1>Máximo 20 archivos simultáneos.</h1><p> El hosting no soporta más de 20 hojas de cálculo en el proceso de la importación</p>

    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="archivo" class="form-label">Seleccionar archivo:</label>
          <input type="file" class="form-control" id="archivo" name="archivo[]" multiple>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
      </form>
    </div>
    <div class="container mt-5" style="max-width: 500px;">
<!-- PHP_SELF para enviar al mismo archivo -->
<form method="POST" action="borrarhorarios.php">
<label for="archivo" class="form-label">Eliminar todos los horarios importados</label>

    <button type="submit" class="btn btn-primary">Eliminar todos los horarios</button>

</form>

    <div id="formulario" class="mx-auto mt-3" style="width:400px;">


    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</div>
</div>
    <?php
        include('../archivosComunes/footer.php');
        ?>