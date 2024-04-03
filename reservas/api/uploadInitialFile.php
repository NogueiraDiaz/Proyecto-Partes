<?php
session_start();
set_time_limit(100);
/* Librerías usadas:
    https://github.com/shuchkin/simplexlsx
    https://github.com/shuchkin/simplexls
*/
use Shuchkin\SimpleXLSX;
use Shuchkin\SimpleXLS;

$start = microtime(true);

if(isset($_SESSION['usuario_login']) && $_SESSION['usuario_login']['rol'] == '0'){
    if(strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
        include('../api/model/Reservas.php');

        if(!file_exists('./../static/uploads')){ mkdir('./../static/uploads'); }

        $reservasApi = new Reservas();
        $allowed = ['application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
        if(!in_array($_FILES['file']['type'], $allowed)){
            echo json_encode(array("isok"=>false,"error"=>"Formato de archivo no permitido"));
            exit();
        }

        // Procesar y guardar archivo subido
        $tmp_file = $_FILES['file']['tmp_name'];
        $filePath = realpath('./../static/uploads').'/'.$_FILES['file']['name'];
        $filePath = str_replace("\\", "/", $filePath);
        $type = strtolower(pathinfo($filePath,PATHINFO_EXTENSION));
        move_uploaded_file($tmp_file, $filePath);

        if($type == 'xls'){
            include_once('../includes/extras/SimpleXLS.php');
            if ( $read = SimpleXLS::parse($filePath) ) {
               $reservasApi -> inicializarTablaReservas(parseData($read,$reservasApi));
            } else {
                echo json_encode(array("isok"=>false,"error"=>SimpleXLS::parseError()));
            }
        } else if($type == 'xlsx'){
            include_once('../includes/extras/SimpleXLSX.php');
            if ( $read = SimpleXLSX::parse($filePath) ) {
                $reservasApi -> inicializarTablaReservas(parseData($read,$reservasApi));
            } else {
                echo json_encode(array("isok"=>false,"error"=>SimpleXLSX::parseError()));
            }
        }
    } else {
        //header('location: ../admins?error=invalidCall');
        echo json_encode(array("isok"=>false,"error"=>"Petición no válida"));
        exit();
    }

} else {
    echo "No session or admin set...";
}


/** Leer y formatear datos del archivo XLS/XLSX
 * @param SimpleXLS|SimpleXLSX $read Objeto generado por SimpleXLS/X que contiene los datos del archivo subido.
 * @param Reservas $api Reservas API objets to use it's functions
 * @return String Ruta absoluta del archivo CSV generado.
 */
function parseData($read, $api){
    $csvPath = realpath('./../static/uploads').'/initialParsedData_'.date('d-m-Y').".csv";
    $csvPath = str_replace("\\", "/", $csvPath);

	
	/* 
		Si se inicializa la tabla antes de Julio del curso actual, se toma AÑO-1/AÑO, si es después AÑO/AÑO+1
		Ejemplo 1: Fecha actual 10/02/2023 >> Inicializar curso 2022/2023
		Ejemplo 2: Fecha actual 10/09/2023 >> Inicializar curso 2023/2024
	*/
	$fechaInicial = strtotime("05-09-".date('Y'));
	$fechaFinal = strtotime("01-07-".date('Y')+1);
	
	$mesActual = date('m');
	if($mesActual < 7){
		$fechaInicial = strtotime("05-09-".date('Y')-1);
		$fechaFinal = strtotime("01-07-".date('Y'));
	}

    $parsedData = [];

    $text = '';
    for($s = 0; $s < count($read->sheetNames()); $s++){
        $rows = $read -> rows($s);
        $times = preg_split("/,\s/", $rows[0][0])[1];
        $itime = preg_split("/\//", $times)[0];
        $ftime = preg_split("/\//", $times)[1];

        if(strlen($itime) == 4) $itime = '0'.$itime;  // $inicio
        if(strlen($ftime) == 4) $ftime = '0'.$ftime;  // $fin

        $datos = array("inicio"=>$itime,"fin"=>$ftime,"espacios"=>[]);
        $espacios = [];

        for($i = 1; $i < count($rows[0]); $i++){
            $dia = '';
            switch($rows[1][$i]){
                case 'Lunes': $dia = 'monday'; break;
                case 'Martes': $dia = 'tuesday'; break;
                case 'Miércoles': $dia = 'wednesday'; break;
                case 'Jueves': $dia = 'thursday'; break;
                case 'Viernes': $dia = 'friday'; break;
            }
            $libres = [];
            for($j = 2; $j < count($rows); $j++){
                $aula = $rows[$j][$i];
                if(!empty($aula)){
                    array_push($libres,$aula);
                    $fechas = $api -> generateDays($dia,$fechaInicial,$fechaFinal);
                    foreach($fechas as $fecha){
                        $text .= '"'.$aula.'","'.$fecha.'","'.$itime.'","'.$ftime.'","'.'INICIAL'.'"'."\n";
                    }
                }
            }
            array_push($espacios,array("dia"=>$dia,"libres"=>$libres));            
        }
        $datos['espacios'] = $espacios;
        array_push($parsedData,$datos);
    }

    //file_put_contents(realpath('./../static/uploads').'/parsed_XLS_data_'.date('d-m-Y').'.json',json_encode($parsedData, JSON_PRETTY_PRINT));

    if( file_put_contents($csvPath, $text, LOCK_EX) != false ){
        return $csvPath;
    } else return null;
}
