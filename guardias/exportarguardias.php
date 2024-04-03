<?php
// PHPoffice
require '../vendor/autoload.php';
// Conexion
require_once("../archivosComunes/conexion.php");
// Para acceder a esta pagina hay que iniciar sesion previamente.
// require_once('../archivosComunes/loginRequerido.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Obtener la fecha especificada del formulario
if (isset($_POST['inicio']) && $_POST['fin'] ) {
    $inicio = $_POST['inicio'];
    $fin = $_POST['fin'];
if($inicio<$fin){
    $spreadsheet = new Spreadsheet();
    $activeWorksheet = $spreadsheet->getActiveSheet();

    $activeWorksheet->setCellValue('A1', 'Fecha');
    $activeWorksheet->setCellValue('B1', 'Periodo');
    $activeWorksheet->setCellValue('C1', 'Clase');
    $activeWorksheet->setCellValue('D1', 'Usuario');

    $activeWorksheet->getColumnDimension('A')->setWidth(20);
    $activeWorksheet->getColumnDimension('B')->setWidth(20);
    $activeWorksheet->getColumnDimension('C')->setWidth(20);
    $activeWorksheet->getColumnDimension('D')->setWidth(40);

    $select = "SELECT cod_guardias,observaciones, fecha,  Guardias.cod_usuario AS cod_usuario,
    Usuarios.nombre AS nombre, Usuarios.apellidos AS apellidos, Periodos.inicio AS periodoinicio, Periodos.fin AS periodofin
    FROM Guardias
    JOIN Periodos ON Guardias.periodo = Periodos.cod_periodo
    JOIN Usuarios ON Guardias.cod_usuario = Usuarios.cod_usuario
    WHERE fecha >= :fechaInicio AND fecha <= :fechaFin
    ORDER BY fecha ASC";
    $stmt = $db->prepare($select);
    $stmt->bindParam(':fechaInicio', $inicio);
    $stmt->bindParam(':fechaFin', $fin);

    $stmt->execute();
    $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Utilizamos un bucle foreach para recorrer todas las filas que devuelve la consulta
    $i = 2;
    foreach ($resul as $columna) {
        $usuario =  $columna['cod_usuario'];
        $activeWorksheet->setCellValue('A' . $i, $columna['fecha']);
        $activeWorksheet->setCellValue('B' . $i, $columna['periodoinicio'] . ' - ' . $columna['periodofin']);

        $dia   = substr($columna['fecha'],8,2);
        $mes = substr($columna['fecha'],5,2);
        $anio = substr($columna['fecha'],0,4); 
        $semana = date('w',  mktime(0,0,0,$mes,$dia,$anio));  
        if($semana == 1){
            $select1 = "SELECT clase
            FROM Horarios
            WHERE cod_usuario = ? AND inicio = ? AND fin = ? AND  dia = 'Lunes';";
             $resul1 = $db->prepare($select1);
             $resul1->execute(array( intval($usuario),$columna['periodoinicio'], $columna['periodofin']));  
             if ($columna1 = $resul1->fetch(PDO::FETCH_ASSOC)) {
                $activeWorksheet->setCellValue('C' . $i, $columna1['clase']);
            }
        
        }else if($semana == 2){
            $select1 = "SELECT clase
            FROM Horarios
            WHERE cod_usuario = ? AND inicio = ? AND fin = ? AND  dia = 'Martes';";
             $resul1 = $db->prepare($select1);
             $resul1->execute(array( intval($usuario),$columna['periodoinicio'], $columna['periodofin']));  
             if ($columna1 = $resul1->fetch(PDO::FETCH_ASSOC)) {
                $activeWorksheet->setCellValue('C' . $i, $columna1['clase']);
            }
        }else if($semana == 3){
            $select1 = "SELECT clase
            FROM Horarios
            WHERE cod_usuario = ? AND inicio = ? AND fin = ? AND  dia = 'Miércoles';";
             $resul1 = $db->prepare($select1);
             $resul1->execute(array( intval($usuario),$columna['periodoinicio'], $columna['periodofin']));  
             if ($columna1 = $resul1->fetch(PDO::FETCH_ASSOC)) {
                $activeWorksheet->setCellValue('C' . $i, $columna1['clase']);
            }
        }else if($semana == 4){
            $select1 = "SELECT clase
            FROM Horarios
            WHERE cod_usuario = ? AND inicio = ? AND fin = ? AND  dia = 'Jueves';";
             $resul1 = $db->prepare($select1);
             $resul1->execute(array( intval($usuario),$columna['periodoinicio'], $columna['periodofin']));  
             if ($columna1 = $resul1->fetch(PDO::FETCH_ASSOC)) {
                $activeWorksheet->setCellValue('C' . $i, $columna1['clase']);
             }
            }else if($semana == 5){
                $select1 = "SELECT clase
                FROM Horarios
                WHERE cod_usuario = ? AND inicio = ? AND fin = ? AND  dia = 'Viernes';";
                 $resul1 = $db->prepare($select1);
                 $resul1->execute(array( intval($usuario),$columna['periodoinicio'], $columna['periodofin']));  
                 if ($columna1 = $resul1->fetch(PDO::FETCH_ASSOC)) {
                    $activeWorksheet->setCellValue('C' . $i, $columna1['clase']);
                }
        }else{
            echo '<td> </td>';
        }
        
        $activeWorksheet->setCellValue('D' . $i, $columna['nombre'] . ' ' . $columna['apellidos']);
        $i++;
    }
        $writer = new Xlsx($spreadsheet);
        $writer->save('../Exportar/datos ' . $inicio . ' ' . $fin . '.xlsx');
}else{
    echo "<script>alert('La fecha de inicio es mayor a la de fin')</script>";
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
    <div class="container mt-5" style="max-width: 300px;">
        <form action="exportarguardias.php" method="post">
            <div class="form-group">
                <label for="inicio">Inicio:</label>
                <input type="date" id="inicio" name="inicio" class="form-control">
            </div>
            <div class="form-group">
                <label for="fin">Fin:</label>
                <input type="date" id="fin" name="fin" class="form-control">
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Crear</button>
        </form>
    </div>
    <div class="container mt-5" style="max-width: 300px;">
        <?php
        if (isset($_POST['inicio']) && $_POST['fin']) {
            echo "<a class='text-warning fs-2' href='../Exportar/datos " . $inicio . " " . $fin . ".xlsx'>Descargar</a>";
        }
        ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php
        include('../archivosComunes/footer.php');
        ?>