<?php
include_once(__DIR__."/utils/dbc.php");
/** Clase / Modelo principal para la API de Reservas
 * @author Eloy Rodríguez Martín (ERMtn)
 */
class Reservas extends Dbc{
    const TABLA = "Reservas";

// SELECTS
    /** Busca una reserva por su Id.
     * @param String|int $rid Id de reserva.
     * @return JSON Respuesta JSON con los registros obtenidos o error
    */
    public function getReservaById($rid){
        $data = $this -> getById($rid);
        if($data !== null) echo json_encode(array("isok"=>true,"data"=>$data));
        else echo json_encode(array("isok"=>false,"error"=>"Consulta fallida"));
    }

    /** Busca todas las reservas de un usuario concreto.
     * @param String|int $uid Id de usuario (autor).
     * @return JSON Respuesta JSON con los registros obtenidos o error
    */
    public function getReservasByAutor($uid){
        $data = $this->getByAutor($uid);
        if($data !== null) echo json_encode(array("isok"=>true,"data"=>$data));
        else echo json_encode(array("isok"=>false,"error"=>"Consulta fallida"));
    }

    /** Busca todas las reservas un aula concreta.
     * @param String $aula Nombre del aula.
     * @return JSON Respuesta JSON con los registros obtenidos o error
    */
    public function getReservasByAula($aula){
        $data = $this->getByAula($aula);
        if($data !== null) echo json_encode(array("isok"=>true,"data"=>$data));
        else echo json_encode(array("isok"=>false,"error"=>"Consulta fallida"));
    }

    /** Busca todas las reservas de una fecha concreta.
     * @param String $fecha Fecha formato AAAA-mm-dd
     * @return JSON Respuesta JSON con los registros obtenidos o error
    */
    public function getReservasByFecha($fecha){
        
        $data = $this->getByFecha($fecha);
        if($data !== null) echo json_encode(array("isok"=>true,"data"=>$data));
        else echo json_encode(array("isok"=>false,"error"=>"Consulta fallida"));
    }

    /** Busca todas las reservas de una fecha y aula concreta
     * @param String $fecha Fecha a filtrar formato AAAA-mm-dd
     * @param String $aula Nombre del aula
     * @return JSON Respuesta JSON con los registros obtenidos o error
    */
    function getReservasByFechaAula($fecha, $aula){
        $data = $this->getByFechaAula($fecha,$aula);
        if($data !== null) echo json_encode(array("isok"=>true,"data"=>$data));
        else echo json_encode(array("isok"=>false,"error"=>"Consulta fallida"));
    }
	
	/** Busca todas las reservas de una fecha y periodo concreto.
     * @param String $fecha Fecha formato AAAA-mm-dd
     * @param String $hora  Fecha formato HH:mm
     * @return JSON Respuesta JSON con los registros obtenidos o error
    */
    public function getReservasByFechaHora($fecha, $hora){
        $data = $this->getByFechaHora($fecha,$hora);
        if($data !== null) echo json_encode(array("isok"=>true,"data"=>$data));
        else echo json_encode(array("isok"=>false,"error"=>"Consulta fallida"));
    }

    /** 
     * CUIDADO AL EJECUTAR ESTO. ¡DEVUELVE TODAS LAS RESERVAS, SI LA BBDD ESTÁ COMPLETA SERÁN MÁS DE 65000!
     * 
     * El programador no se hace responsable de los posibles daños causados al ejecutar esta consulta.
     * @return JSON Respuesta JSON con los registros obtenidos o error
     */
    public function getReservas(){
        $data = $this->getAll();
        if($data !== null) echo json_encode(array("isok"=>true,"data"=>$data));
        else echo json_encode(array("isok"=>false,"error"=>"Consulta fallida"));
    }

// INSERTS
    /** Crea una nueva reserva en la base de datos.
     * @param String $uid Id del usuario autor de la reserva.
     * @param String $room Aula a reservar.
     * @param String $date Fecha de la reserva.
     * @param String $idate Hora inicio en base a fecha actual, formato hh:mm.
     * @param String $fdate Hora fin en base a fecha actual, formato hh:mm.
     * @param String $comment Comentario opcional sobre la reserva
     */
    public function setReserva($uid,$room,$date,$idate,$fdate,$comment){

        $data = $this -> nuevaReserva($uid,$room,$date,$idate,$fdate,$comment);
        if($data === null) echo json_encode(array("isok"=>false,"error"=>"Consulta fallida"));
        else if($data === false) echo json_encode(array("isok"=>false,"error"=>"Aula ocupada"));
        else echo json_encode(array("isok"=>true,"data"=>1));

    }

    /** Genera tods las reservas necesarias entre la fecha de inicio y fin, en los días y hora indicados.
     * @param String $dias Listado de días de la semana a reservar, en inglés, separados por comas ( , ).
     * @param String $date_inicio Fecha inicial de repetición.
     * @param String $date_fin Fecha final de repetición.
     * @param String $uid Id del usuario autor de las reservas.
     * @param String $room Aula a reservar.
     * @param String $idate Hora inicio en base a fecha actual, formato hh:mm.
     * @param String $fdate Hora fin en base a fecha actual, formato hh:mm.
     * @param String $comment Comentario opcional sobre la reserva
     * @return JSON Respuesta con el número de registros borrados o error
     */
    public function reservaPeriodica($dias,$date_inicio,$date_fin,$uid,$room,$idate,$fdate,$comment){
        $dias = explode(",",$dias,6);
        $correctas = 0;
        $fallidas = array(); // Array de string con reservas formato 'dd-mm-YYYY - HH:MM'

        $date_inicio = strtotime($date_inicio);
        $date_fin = strtotime($date_fin);

        foreach($dias as $dia){
            $fechas = $this -> generateDays($dia,$date_inicio,$date_fin);
            foreach($fechas as $fecha){
                if($this -> combinationExists($room,$fecha,$idate,$fdate)){
                    array_push($fallidas, date('d-m-Y',strtotime($fecha))." - $idate");
                } else {
                    if($this -> nuevaReserva($uid,$room,$fecha,$idate,$fdate,$comment, false) !== null)
                        $correctas++;
                    else
                        array_push($fallidas, date('d-m-Y',strtotime($fecha))." - $idate");
                }
            }
        }
        echo json_encode(array("isok"=>true,"data"=>$correctas,"fallos"=>$fallidas));
    }


// UPDATES
    /** Actualiza una reserva con un Id concreto.
     * @param String $rid Id de la reserva a actualizar
     * @param String $room Aula a reservar.
     * @param String $date Fecha de reserva formato yyyy-mm-dd.
     * @param String $idate Hora inicio en base a fecha actual, formato hh:mm.
     * @param String $fdate Hora fin en base a fecha actual, formato hh:mm.
     * @param String $comment Comentario opcional sobre la reserva
     * @return JSON Respuesta con el número de registros borrados o error
     */
    public function updateReserva($rid,$room,$date,$idate,$fdate,$comment){
        if($this->combinationExists($room,$date,$idate,$fdate,$rid)){
            echo json_encode(array("isok"=>false,"error"=>"Aula ocupada"));
            exit();
        }
        
        $stmt = $this -> connect() -> prepare("UPDATE ".self::TABLA." SET aula = ?, fecha = ?, inicio = ?, fin = ?, comentario = ? WHERE id = ?");
        if(!$stmt->execute(array($room,$date,$idate,$fdate,$comment,$rid))){
            $stmt = null;
            echo json_encode(array("isok"=>false, "error"=>"Consulta fallida"));
            exit();
        }

        $r = array('id'=>$rid,'aula'=>$room,'fecha'=>$date,'inicio'=>$idate,'fin'=>$fdate,'comentario'=>$comment);
        echo json_encode(array("isok"=>true,"data"=>$r));
        $stmt = null;
    }


// DELETES
    /** Permite eliminar una reserva con un Id concreto
     * @param String|int $rid Id de reserva a eliminar
     * @return JSON Respuesta con el número de registros borrados o error
     */
    public function deleteById($rid){
        $stmt = $this -> connect() -> prepare("DELETE FROM ".self::TABLA." WHERE id = ?");
        if(!$stmt->execute(array($rid))){
            $stmt = null;
            echo json_encode(array("isok"=>false, "error"=>"Consulta fallida"));
            exit();
        }
        echo json_encode(array("isok"=>true, "data"=>$stmt->rowCount()));
        $stmt = null;
    }

    /** Vacía por completo la tabla reservas. Puede realizar un volcado antes, si se indica.
     * @param bool $backup Indica si realizar volcado antes de borrar el contenido.
     * @return JSON Respuesta JSON con la cantidad de registros eliminados o error.
     */
    public function cleanReservas($backup){
        $data = $this -> cleanAllReservas($backup);
        if($data !== false) echo json_encode(array("isok"=>true,"data"=>$data));
        else echo json_encode(array("isok"=>false,"error"=>"Consulta fallida"));
    }

    private function cleanAllReservas($backup){
        if($backup) $this->backup();
        if(($rows = $this->connect()->exec("DELETE FROM ".self::TABLA.";")) !== false){
            $this -> connect() -> exec("ALTER TABLE ".self::TABLA." AUTO_INCREMENT = 1");
            return $rows;
        }
        else return false;
    }


// MISC
    /** Hace un volcado de la tabla reservas de la base de datos.
     * Genera un archivo: dumpReservas_dd-mm-AAAA_randomInt.csv
     * @return bool Correcto o no
     */
    public function backup(){

        $basePath = __DIR__.'/../../db';
        if(!file_exists($basePath)){
            mkdir($basePath);
        }
        $basePath = str_replace("\\",'/',realpath($basePath));
        $outfile = $basePath."/dumpReservas_".date('d-m-Y').'_'.rand(0,9000).".csv";

        try{
            $stmt = $this -> connect() -> prepare("SELECT * FROM ".self::TABLA.";");
            if(!$stmt->execute(array())){
                $stmt = null;
                return false;
            }
            $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
            $stmt = null;
            
            $text = '';
            foreach($rows as $row){
                $text .= $row['id'].','.$row['autor'].',"'.$row['aula'].'","'.$row['fecha'].'","'.$row['inicio'].'","'.$row['fin'].'","'.$row['comentario']."\"\n";
            }

            if(file_put_contents($outfile, $text, LOCK_EX) !== false) return true;
            else return false;

        } catch(PDOException $e){
            //$msg = $e->getMessage();
            //if(str_contains($msg,'already exists')) return false;
            return false;
        }
    }

    /** 
     * Carga un archivo .CSV con los datos de reserva a la base de datos. Eficiente para cargar MUCHOS registros (+1000).
     * @param String $csvPath Ruta absoluta al archivo a importar.
     * @return bool Importación correcta o no.
     */
    public function loadCSVdata($csvPath){
        $csvData = explode("\n",file_get_contents($csvPath));
        $fullSQL = '';
        $sql = "INSERT INTO ".self::TABLA." VALUES";

        $fileName = "/initial_CSV_Reservas_".date("d-m-Y").".sql";
        $path = realpath(__DIR__.'/../../static/uploads');
        $path = str_replace("\\", "/", $path);
        $finalPath = $path.$fileName;
        $count = 0;
        foreach($csvData as $row){
            $sql .= "($row)";
            $count++;
            if($count < 4000) $sql .= ',';
            else{
                $sql .= ";";
                $fullSQL .= $sql."\n\n";
                $stmt = $this -> connect() -> exec($sql);
                $stmt = null;
                $sql = "INSERT INTO ".self::TABLA." VALUES";
                $count = 0;
            }
        }
        $sql = str_replace(",(),",";",$sql);
        $fullSQL .= $sql;
        file_put_contents($finalPath,$fullSQL);

        $stmt = $this -> connect() -> exec($sql);
        array_map('unlink', glob("$path/*.{csv,xlsx,xls}", GLOB_BRACE));

        //$stmt = $this->connect()->exec("LOAD DATA INFILE '$csvPath' INTO TABLE ".self::TABLA." FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\\n';");
        return ($stmt !== false) ? true : false;
    }

    /** ¡CUIDADO! Esta función vacía por completo la tabla reservas y carga TODAS las posibles 
     *  reservas desde el 5 de Septiembre del año actual hasta el 1 de Julio del año siguiente. En total más de 65000 reservas.
     * @param String $parsedCSVPath Ruta absoluta del archivo CSV creado al extraer los datos del archivo XLS/X subido.
     * @return JSON OK o ERROR.
     */
    function inicializarTablaReservas($parsedCSVPath){
        $data = $this -> inicializarReservas($parsedCSVPath);
        echo json_encode($data);
    }

    /** ¡CUIDADO! Esta función vacía por completo la tabla reservas y carga TODAS las posibles 
     *  reservas desde el 5 de Septiembre del año actual hasta el 1 de Julio del año siguiente. En total más de 65000 reservas.
     * @param String $parsedCSVPath Ruta absoluta del archivo CSV creado al extraer los datos del archivo XLS/X subido.
     * @return array OK o ERROR.
     */
    function inicializarReservas($parsedCSVPath){
        if($parsedCSVPath == null){
            return array("isok"=>false,"error"=>"No se pudo guardar los datos del archivo XLS subido.<br>Contacte con jefatura y comunique este error.");
        }

        $parsedData = file_get_contents($parsedCSVPath);
        if($parsedData === false){
            return array("isok"=>false,"error"=>"No se pudo leer los datos extraidos del XLS subido.<br>Contacte con jefatura y comunique este error.");
        }

        $start = microtime(true);

        if($this->totalReservas() > 0)
            $this -> cleanAllReservas(true);

		$fechaInicial = strtotime("05-09-".date('Y'));
		$fechaFinal = strtotime("01-07-".date('Y')+1);
		
        $mesActual = date('m');
		if($mesActual < 7){
			$fechaInicial = strtotime("05-09-".date('Y')-1);
			$fechaFinal = strtotime("01-07-".date('Y'));
		}
		
        $dates = $this->generateBusinessDays($fechaInicial,$fechaFinal);

        $roomData = file_get_contents('../static/aulas.json');
        $hourData = file_get_contents('../static/periodos.json');
        $rooms = json_decode($roomData);
        $hours = json_decode($hourData);

        $fileName = "initial_CSV_Reservas_".date('d-m-Y').".csv";
        $csvPath = realpath(__DIR__.'/../../static/uploads')."/$fileName";
        $csvPath = str_replace("\\", "/", $csvPath);

        $text = '';
        $count = 1;
        foreach($dates as $date){
            foreach ($rooms as $room) {
                for($i = 0; $i < count($hours)-1; $i++){
                    if($hours[$i]->hora != '11:15'){ // Recreo todo libre
                        $reserva = '"'.$room->nombre.'","'.$date.'","'.$hours[$i]->hora.'","'.$hours[$i+1]->hora.'","'.'INICIAL'.'"'."\n";
                        if(!str_contains($parsedData,$reserva)){
                            $text .= $count.','.(0).','.$reserva;
                            $count++;
                        } 
                    }
                }
            }
        }
        if(file_put_contents($csvPath, $text, LOCK_EX) == false)
             return array("isok"=>false,"error"=>"Error escribiendo el archivo CSV final antes de importar los datos.<br>Consulte con jefatura.");
        
        //return array("isok"=>true,"data"=>$fileName);

        if($this -> loadCSVdata($csvPath)){
            return array("isok"=>true,"data"=>"BBDD reinicializada en ".round(microtime(true)-$start,3)." segundos.");
        } else {
            return array("isok"=>false,"error"=>"Reinicialización no completada tras ".round(microtime(true)-$start,4)." segundos. :(<br>Consulte con jefatura.");
        }
    }

// AUX FUNCTIONS
    /** CUIDADO AL EJECUTAR ESTO. ¡DEVUELVE TODAS LAS RESERVAS, SI LA BBDD ESTÁ COMPLETA SERÁN MÁS DE 65000! 
     * 
     * El programador no se hace responsable de los posibles daños causados al ejecutar esta consulta.
     * @return array|null Lista de ARRAY_ASSOC (Objetos) con los registros obtenidos.
     */
    function getAll(){
        $stmt = $this -> connect() -> prepare("SELECT R.id,CONCAT(U.nombre,' ',U.apellidos) AS 'autor',aula,fecha,inicio,fin,comentario FROM ".self::TABLA." R INNER JOIN Usuarios U ON R.autor = U.cod_usuario");
        if(!$stmt->execute(array())){
            $stmt = null;
            return null;
            exit();
        }
        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
        return $rows;
    }

    /** Cuenta las reservas totales en la base de datos
     * @return int Número de reservas totales
     */
    function userExists($email){
        $stmt = $this -> connect() -> prepare("SELECT COUNT(*) FROM ".self::TABLA."");
        if(!$stmt->execute(array())){
            $stmt = null;
            return null;
            exit();
        }

        $rows = $stmt -> fetchColumn();
        $stmt = null;
        return $rows;
    }

    /** Busca una reserva por su Id.
     * @param String|int $rid Id de reserva.
     * @return array|null Lista de ARRAY_ASSOC (Objetos) con los registros obtenidos.
    */
   function getById($rid){
    $stmt = $this -> connect() -> prepare("SELECT R.id, CONCAT(U.nombre,' ',U.apellidos) AS 'autor',aula,fecha,inicio,fin,comentario FROM ".self::TABLA." R INNER JOIN Usuarios U ON R.autor = U.cod_usuario WHERE R.id = ?");
    if(!$stmt->execute(array($rid))){
        $stmt = null;
        return null;
        exit();
    }
    $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    $stmt = null;
    return $rows;
}

    /** Busca todas las reservas de un usuario concreto.
     * @param String|int $uid Id de usuario.
     * @return array|null Lista de ARRAY_ASSOC (Objetos) con los registros obtenidos.
    */
   function getByAutor($uid){
       $stmt = $this -> connect() -> prepare("SELECT R.id, CONCAT(U.nombre,' ',U.apellidos) AS 'autor',aula,fecha,inicio,fin,comentario FROM ".self::TABLA." R INNER JOIN Usuarios U ON R.autor = U.cod_usuario WHERE autor = ? AND fecha >= '".date('Y-m-d')."'");
       if(!$stmt->execute(array($uid))){
           $stmt = null;
           return null;
           exit();
       }
       $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
       $stmt = null;
       return $rows;
   }

    /** Busca todas las reservas de un aula concreta.
     * @param String $aula Nombre del aula.
     * @return array|null Lista de ARRAY_ASSOC (Objetos) con los registros obtenidos.
    */
    function getByAula($aula){
        $stmt = $this -> connect() -> prepare("SELECT R.id, CONCAT(U.nombre,' ',U.apellidos) AS 'autor',aula,fecha,inicio,fin,comentario FROM ".self::TABLA." R INNER JOIN Usuarios U ON R.autor = U.cod_usuario WHERE aula = ?");
        if(!$stmt->execute(array($aula))){
            $stmt = null;
            return null;
            exit();
        }
        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
        return $rows;
    }

    /** Busca todas las reservas de una fecha concreta
     * @param String $fecha Fecha a filtrar formato AAAA-mm-dd
     * @return array|null Lista de ARRAY_ASSOC (Objetos) con los registros obtenidos. NULL si hay error
    */
    function getByFecha($fecha){
        $stmt = $this -> connect() -> prepare("SELECT COUNT(*) FROM ".self::TABLA." WHERE fecha = ?;");
        if(!$stmt->execute(array($fecha))){
            $stmt = null;
            return null;
            exit();
        }

        if($stmt -> fetchColumn() == 0){
            return [];
            exit();
        }

        $stmt = $this -> connect() -> prepare("SELECT R.id, CONCAT(U.nombre,' ',U.apellidos) AS 'autor',aula,fecha,inicio,fin,comentario FROM ".self::TABLA." R INNER JOIN Usuarios U ON R.autor = U.cod_usuario WHERE R.fecha = ?;");
        if(!$stmt->execute(array($fecha))){
            $stmt = null;
            return null;
            exit();
        }
        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
        return $rows;
    }

    /** Busca todas las reservas de una fecha y aula concreta
     * @param String $fecha Fecha a filtrar formato AAAA-mm-dd
     * @param String $aula Nombre del aula
     * @return array|null Lista de ARRAY_ASSOC (Objetos) con los registros obtenidos. NULL si hay error
    */
    function getByFechaAula($fecha, $aula){
        $stmt = $this -> connect() -> prepare("SELECT COUNT(*) FROM ".self::TABLA." WHERE fecha = ? AND aula = ?;");
        if(!$stmt->execute(array($fecha,$aula))){
            $stmt = null;
            return null;
            exit();
        }

        if($stmt -> fetchColumn() == 0){
            return [];
        }

        $stmt = $this -> connect() -> prepare("SELECT id,inicio,fin,comentario FROM ".self::TABLA." WHERE fecha = ? AND aula = ? ORDER BY inicio ASC;");
        if(!$stmt->execute(array($fecha,$aula))){
            $stmt = null;
            return null;
            exit();
        }
        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
        return $rows;
    }
	
	/** Busca todas las reservas de una fecha concreta
     * @param String $fecha Fecha a filtrar formato AAAA-mm-dd
     * @param String $hora  Hora a filtrar formato HH:mm
     * @return array|null Lista de ARRAY_ASSOC (Objetos) con los registros obtenidos. NULL si hay error
    */
    function getByFechaHora($fecha, $hora){
        $stmt = $this -> connect() -> prepare("SELECT COUNT(*) FROM ".self::TABLA." WHERE fecha = ? AND inicio = ?;");
        if(!$stmt->execute(array($fecha,$hora))){
            $stmt = null;
            return null;
            exit();
        }

        if($stmt -> fetchColumn() == 0){
            return [];
            exit();
        }

        $stmt = $this -> connect() -> prepare("SELECT id,aula,inicio,fin,comentario FROM ".self::TABLA." WHERE fecha = ? AND inicio = ?;");
        if(!$stmt->execute(array($fecha,$hora))){
            $stmt = null;
            return null;
            exit();
        }
        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
        return $rows;
    }

    /** Busca todas las reservas de una fecha y aula concreta
     * @param String $aula Nombre del aula
     * @param String $start Fecha inicial para filtrar
     * @param String $end Fecha final para filtrar
     * @return JSON Objeto JSON con un array de eventos, puede estar vacío ( [] ).
    */
    function getAsCalendarEvents($aula,$start,$end){
        //echo '<script language="javascript">alert("juas");</script>';

        $stmt = $this -> connect() -> prepare("SELECT COUNT(*) FROM ".self::TABLA." WHERE aula = ? AND fecha BETWEEN ? AND ? LIMIT 2");
        if(!$stmt->execute(array($aula,$start,$end))){
            $stmt = null;
            // echo json_encode(array("error"=>"COUNT FAILED"));
            echo json_encode(array());
            exit();
        }

        if($stmt -> fetchColumn() == 0){
            // echo json_encode(array("error"=>"EMPTY COUNT"));
            echo json_encode(array());
            exit();
        }

        $stmt = $this -> connect() -> prepare("SELECT R.id, CONCAT(U.nombre,' ',U.apellidos) AS autor,aula,fecha,inicio,fin,comentario FROM ".self::TABLA." R INNER JOIN Usuarios U ON R.autor = U.cod_usuario WHERE aula = ? AND fecha BETWEEN ? AND ?;");
        if(!$stmt->execute(array($aula,$start,$end))){
            $stmt = null;
            // echo json_encode(array("error"=>"SELECT FAILED"));
            echo json_encode(array());
            exit();
        }
        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;

        $eventos = array();
        // Transformar $rows en objetos compatibles con eventos FullCalendar
        foreach($rows as $row){
            $ev = array(
                "id" => $row['id'],
                "title" => $row['aula'],
                "start" => $row['fecha'].'T'.$row['inicio'],
                "end" => $row['fecha'].'T'.$row['fin'],
                "display" => "block",
                "classNames" => [$row['comentario'] == 'INICIAL' ? 'bg-gradient' : 'bg-secondary bg-gradient border-secondary'],
                "overlap" => false,
                "extendedProps"=> array( "autor" => $row['autor'],"comentario" => $row['comentario'])
            );
            array_push($eventos, $ev);
        }
        echo json_encode($eventos);
    }

     /** Busca todas las reservas de una fecha y aula concreta
     * @param String $usuario Nombre del usuario
     * @param String $start Fecha inicial para filtrar
     * @param String $end Fecha final para filtrar
     * @return JSON Objeto JSON con un array de eventos, puede estar vacío ( [] ).
    */
    function getAsCalendarEventsusuario($usuario,$start,$end){
        $stmt = $this -> connect() -> prepare("SELECT COUNT(*) FROM ".self::TABLA." WHERE autor = ? AND fecha BETWEEN ? AND ? LIMIT 2");
        if(!$stmt->execute(array($usuario,$start,$end))){
            $stmt = null;
            // echo json_encode(array("error"=>"COUNT FAILED"));
            echo json_encode(array());
            exit();
        }
        
        if($stmt -> fetchColumn() == 0){
            // echo json_encode(array("error"=>"EMPTY COUNT"));
            echo json_encode(array());
            exit();
        }

        $stmt = $this -> connect() -> prepare("SELECT R.id, CONCAT(U.nombre,' ',U.apellidos) AS autor,aula,fecha,inicio,fin,comentario FROM ".self::TABLA." R INNER JOIN Usuarios U ON R.autor = U.cod_usuario WHERE autor = ? AND fecha BETWEEN ? AND ?;");
        if(!$stmt->execute(array($usuario,$start,$end))){
            $stmt = null;
            // echo json_encode(array("error"=>"SELECT FAILED"));
            echo json_encode(array());
            exit();
        }
        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;

        $eventos = array();
        // Transformar $rows en objetos compatibles con eventos FullCalendar
        foreach($rows as $row){
            $ev = array(
                "id" => $row['id'],
                "title" => $row['aula'],
                "start" => $row['fecha'].'T'.$row['inicio'],
                "end" => $row['fecha'].'T'.$row['fin'],
                "display" => "block",
                "classNames" => [$row['comentario'] == 'INICIAL' ? 'bg-gradient' : 'bg-secondary bg-gradient border-secondary'],
                "overlap" => false,
                "extendedProps"=> array( "autor" => $row['autor'],"comentario" => $row['comentario'])
            );
            array_push($eventos, $ev);
        }
        echo json_encode($eventos);
    }

    /** Crea una nueva reserva en la base de datos.
     * @param String $uid Id del usuario autor de la reserva.
     * @param String $room Aula a reservar.
     * @param String $date Fecha de la reserva.
     * @param String $idate Hora inicio en base a fecha actual, formato hh:mm.
     * @param String $fdate Hora fin en base a fecha actual, formato hh:mm.
     * @param String $comment Comentario opcional sobre la reserva
     * @param bool $check (Opcional) Para comprobar si ya existe una reserva igual, por defecto: true.
     * @return bool|null Si la reserva se ha hecho o no o NULL si error.
     */
    public function nuevaReserva($uid,$room,$date,$idate,$fdate,$comment,$check = true){

        if($check && $this->combinationExists($room,$date,$idate,$fdate)){
            return false;
        }

        $comment = ($comment == '') ? null : trim($comment);

        $stmt = $this -> connect() -> prepare("INSERT INTO ".self::TABLA."(autor,aula,fecha,inicio,fin,comentario) VALUES(?,?,?,?,?,?);");

        if(!$stmt -> execute(array($uid,$room,$date,$idate,$fdate,$comment))){
            // On error, close statement
            $stmt = null;
            return null;
        }
        
        return true;
        $stmt = null;
    }


    /**
     * Comprueba si cualquier valor del array es un string vacío
     * @param String[] $arrayParams  Lista de valores string.
     * @return bool
     */
    function checkEmpty($arrayParams){
        foreach ($arrayParams as $param){
            if(empty($param)) return true;
        }
        return false;
    }

    /**
     * Toma horas en base a fecha actual, con la hora en formato 24 horas (hh:mm).
     * @param String $idate Hora de inicio de la reserva.
     * @param String $fdate Hora de fin de la reserva.
     * @return bool $idate >= $fdate.
     */
    function invalidHours($idate,$fdate){
        return strtotime($idate) >= strtotime($fdate);
    }

    /**
     * @param String $start Fecha inicial de la reserva.
     * @param String $end (Sólo para periódica) Fecha final de la reserva.
     */
    function invalidDates($start, $end = null){
        if(strtotime($start) >= strtotime(date("d-m-Y"))){
            if($end != null){
                return strtotime($start) > strtotime($end);
            }
            else return false;
        } else return true;
    }

    /**
     * @param String $room Aula a reservar.
     * @param String $date Fecha de reserva formato yyyy-mm-dd.
     * @param String $idate Hora inicio en base a fecha actual, formato hh:mm.
     * @param String $fdate Hora fin en base a fecha actual, formato hh:mm.
     * @param String|Int $rid (Opcional) Para evitar errores al editar reserva, comprueba si existe una reserva con id diferente
     * @return bool Si existe un registro con estos parámetros (aula ocupada), false, si no, true.
     */
    private function combinationExists($room,$date,$idate,$fdate,$rid = null){
        if($rid == null){
            $stmt = $this -> connect() -> prepare("SELECT COUNT(*) FROM ".self::TABLA." WHERE aula = ? AND fecha = ? AND inicio = ? AND fin = ?;");
            if(!$stmt -> execute(array($room,$date,$idate,$fdate))){
                $stmt = null;
                return false;
            }

            $rows = $stmt -> fetchColumn();
            $stmt = null;
            if($rows > 0) return true;

            return false;
        } else {
            $stmt = $this -> connect() -> prepare("SELECT COUNT(*) FROM ".self::TABLA." WHERE id NOT IN(?*1) AND aula = ? AND fecha = ? AND inicio = ? AND fin = ?;");
            if(!$stmt -> execute(array(intval($rid),$room,$date,$idate,$fdate))){
                $stmt = null;
                return false;
            }

            $rows = $stmt -> fetchColumn();
            $stmt = null;
            if($rows > 0) return true;

            return false;
        }

    }

    /** Cuenta el número total de reservas en la tabla
     * @return int|false Número de reservas o FALSE si error.
     */
    function totalReservas(){
        $stmt = $this -> connect() -> prepare("SELECT COUNT(*) FROM ".self::TABLA.";");
        if(!$stmt -> execute(array())){
            $stmt = null;
            return false;
        }

        $rows = $stmt -> fetchColumn();
        $stmt = null;
        return $rows;
    }

    /** Genera todas las fechas entre semana desde idate hasta fdate
     * @param int $start Valor en segundos desde EPOCH de la fecha inicial
     * @param int $finish Valor en segundos desde EPOCH de la fecha final
     * @return array Lista de strings con las fechas obtenidas
     */
    function generateBusinessDays($start, $finish){
        $dates = [];
        $days = ['monday','tuesday','wednesday','thursday','friday'];
        foreach($days as $day){
            $today = strtotime("$day this week", $start);
            while($today < $finish){
                array_push($dates,date('Y-m-d', $today));
                $today = strtotime("next $day", $today);
            }
        }
        return $dates;
    }

    /** Genera todas las fechas en los días indicados desde la fecha inicial a la final
     * @param int $weekday String con el día de la semana, en inglés
     * @param int $start Valor en segundos desde EPOCH de la fecha inicial
     * @param int $finish Valor en segundos desde EPOCH de la fecha final
     * @return array Lista de strings con las fechas obtenidas
     */
    function generateDays($weekday,$start,$finish){
        $dates = [];
        $today = strtotime("$weekday this week", $start);
        while($today <= $finish){
            array_push($dates,date('Y-m-d', $today));
            $today = strtotime("next $weekday", $today);
        }
        return $dates;
    }
}