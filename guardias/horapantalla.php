<?php
require_once("../archivosComunes/conexion.php");
// Para acceder a esta pagina hay que iniciar sesion previamente.
require_once('../archivosComunes/loginRequerido.php');

$hora_actual = date("H:i:s");
$select = "SELECT cod_guardias, observaciones, fecha, Guardias.cod_usuario AS cod_usuario,
Usuarios.nombre AS nombre, Usuarios.apellidos AS apellidos, Usuarios.cod_delphos AS delphos, Periodos.inicio AS periodoinicio, Periodos.fin AS periodofin,
Periodos.cod_periodo AS cod_periodo
FROM Guardias
JOIN Periodos ON Guardias.periodo = Periodos.cod_periodo
JOIN Usuarios ON Guardias.cod_usuario = Usuarios.cod_usuario
WHERE (fecha = CURDATE() AND TIME(Periodos.inicio) > DATE_SUB(TIME('$hora_actual'), INTERVAL 55 MINUTE))
OR (fecha = CURDATE() + INTERVAL 1 DAY AND TIME('$hora_actual') >= TIME('21:15:00'))
ORDER BY fecha ASC, periodoinicio ASC;";
$resul = $db->query($select);



$resul = $db->query($select);
$i=0;
$periodoActual="";
$periodoSiguiente="";
// Utilizamos un bucle while para recorrer todas las filas que devuelve la consulta
while ($columna = $resul->fetch(PDO::FETCH_ASSOC)) {
    $usuario =  $columna['cod_usuario'];
    $delphos =  $columna['delphos'];
    $i = $i+1;
    if($i==1){
        if($columna['periodoinicio'] <= $hora_actual && $columna['periodofin'] >= $hora_actual){
        $periodoActual = $columna['periodoinicio'];
        $periodoSiguiente = $columna['periodofin'];

        }
        
        if($hora_actual<='08:29:59'){
            $periodoSiguiente = '08:30:00';
        }else if($hora_actual>='08:30:00' && $hora_actual<='09:24:59'){
            $periodoSiguiente = '09:25:00';
        }else if($hora_actual>='09:25:00' && $hora_actual<='10:19:59'){
            $periodoSiguiente = '10:20:00';
        }else if($hora_actual<='11:44:59' && $hora_actual>='10:20:00'){
            $periodoSiguiente = '11:45:00';
        }else if($hora_actual>='11:45:00' && $hora_actual<='12:39:59'){
            $periodoSiguiente = '12:40:00';
        }else if($hora_actual>='12:40:00' && $hora_actual<='13:34:59'){
            $periodoSiguiente = '13:35:00';
        }else if($hora_actual>='13:35:00' && $hora_actual<='15:14:59'){
            $periodoSiguiente = '15:15:00';
        }else if($hora_actual>='15:15:00' && $hora_actual<='16:09:59'){
            $periodoSiguiente = '16:10:00';
        }else if($hora_actual>='16:10:00' && $hora_actual<='17:04:59'){
            $periodoSiguiente = '17:05:00';
        }else if($hora_actual<='18:29:59' && $hora_actual>='17:05:00'){
            $periodoSiguiente = '18:30:00';
        }else if($hora_actual>='13:35:00' && $hora_actual<='15:14:59'){
            $periodoSiguiente = '15:15:00';
        }else if($hora_actual>='18:30:00' && $hora_actual<='19:24:59'){
            $periodoSiguiente = '19:25:00';
        }else if($hora_actual>='19:25:00' && $hora_actual<='20:19:59'){
            $periodoSiguiente = '20:20:00';
        }else if($hora_actual>='20:20:00' && $hora_actual<='21:14:59'){
            $periodoSiguiente = '21:15:00';
        }
    }
    echo "<tr id='".$i."'>";
    // Recorremos las columnas de la fila actual
    echo '<td>'.$columna['fecha'].'</td>';
    if ($periodoActual == $columna['periodoinicio']){
        echo '<script>document.getElementById('.$i.').style.background="#008f39"</script>';        
        echo '<script>document.getElementById('.$i.').style.color="white"</script>';    
        echo '<script>document.getElementById('.$i.').style.fontWeight="bold"</script>';        
        
    }else if ($periodoSiguiente == $columna['periodoinicio']){
        echo '<script>document.getElementById('.$i.').style.background="#b8daba"</script>';        
        echo '<script>document.getElementById('.$i.').style.color="black"</script>';    
        echo '<script>document.getElementById('.$i.').style.fontWeight="bold"</script>';        

    }else if ('08:30:00' == $columna['periodoinicio'] || '15:15:00' == $columna['periodoinicio']){
        echo '<script>document.getElementById('.$i.').style.background="#00008B"</script>';        
        echo '<script>document.getElementById('.$i.').style.color="white"</script>';    
        echo '<script>document.getElementById('.$i.').style.fontWeight="bold"</script>';        
        
    }else if ('09:25:00' == $columna['periodoinicio'] || '16:10:00' == $columna['periodoinicio']){
        echo '<script>document.getElementById('.$i.').style.background="#1E90FF"</script>';        
        echo '<script>document.getElementById('.$i.').style.color="black"</script>';    
        echo '<script>document.getElementById('.$i.').style.fontWeight="bold"</script>';        
        
    }else if ('10:20:00' == $columna['periodoinicio'] || '17:05:00' == $columna['periodoinicio']){
        echo '<script>document.getElementById('.$i.').style.background="#00BFFF"</script>';        
        echo '<script>document.getElementById('.$i.').style.color="black"</script>';    
        echo '<script>document.getElementById('.$i.').style.fontWeight="bold"</script>';        
        
    }else if ('11:45:00' == $columna['periodoinicio'] || '18:30:00' == $columna['periodoinicio']){
        echo '<script>document.getElementById('.$i.').style.background="#87CEFA"</script>';        
        echo '<script>document.getElementById('.$i.').style.color="black"</script>';    
        echo '<script>document.getElementById('.$i.').style.fontWeight="bold"</script>';        
        
    }else if ('12:40:00' == $columna['periodoinicio'] || '19:25:00' == $columna['periodoinicio']){
        echo '<script>document.getElementById('.$i.').style.background="#ADD8E6"</script>';        
        echo '<script>document.getElementById('.$i.').style.color="black"</script>';    
        echo '<script>document.getElementById('.$i.').style.fontWeight="bold"</script>';        
        
    }else if ('13:35:00' == $columna['periodoinicio'] || '20:20:00' == $columna['periodoinicio']){
        echo '<script>document.getElementById('.$i.').style.background="#F0F8FF"</script>';        
        echo '<script>document.getElementById('.$i.').style.color="black"</script>';    
        echo '<script>document.getElementById('.$i.').style.fontWeight="bold"</script>';        
        
    }
    echo '<td>'.substr($columna['periodoinicio'], 0, strlen($columna['periodoinicio']) - 3)." - ".substr($columna['periodofin'], 0, strlen($columna['periodofin']) - 3).'</td>';
    $dia   = substr($columna['fecha'],8,2);
    $mes = substr($columna['fecha'],5,2);
    $anio = substr($columna['fecha'],0,4); 
    $semana = date('w',  mktime(0,0,0,$mes,$dia,$anio));  
    $semanaGuardia="";
    if($semana == 1){
        $semanaGuardia="Lunes";
    }else if($semana == 2){
        $semanaGuardia="Martes";
    }else if($semana == 3){
        $semanaGuardia="Miércoles";
    }else if($semana == 4){
        $semanaGuardia="Jueves";
    }else if($semana == 5){
        $semanaGuardia="Viernes";
       
    }else{
        echo '<td> </td>';
    }
    if($semana >=1 && $semana <=5){
        $select1 = "SELECT clase
        FROM Horarios
        WHERE (cod_usuario = ? OR cod_delphos = ?) AND inicio = ? AND fin = ? AND  dia = ?;";

        $resul1 = $db->prepare($select1);
        //Pasar a traves de un array los valores escritos en el formulario
        //Los valores se recogen por parametros en la función
        $resul1->execute(array( intval($usuario),$delphos, $columna['periodoinicio'], $columna['periodofin'], $semanaGuardia));  
        if ($columna1 = $resul1->fetch(PDO::FETCH_ASSOC)) {
            if ($columna1['clase']!="" && $columna1['clase']!=null){
                echo '<td>'.$columna1['clase'].'</td>';
                }else{
                    echo '<td></td>';
                    echo '<script>document.getElementById('.$i.').style.display="none"</script>';        
                }
        }else{
            echo '<td></td>';
            echo '<script>document.getElementById('.$i.').style.display="none"</script>';
        }
    }
    echo '<td>'.$columna['nombre'].' '.$columna['apellidos'].'</td>';
    echo '<td style="max-width:300px;">'.$columna['observaciones'].'</td>';
   /* $select2 = "SELECT u.nombre, u.apellidos
    FROM Horarios h, Usuarios u
    WHERE (h.clase like '%Guardia%' OR h.clase like '%GUARDIA%') 
    AND h.inicio = ? AND h.fin = ? AND  h.dia = 'Viernes'
    AND (u.cod_usuario = h.cod_usuario OR u.cod_delphos = h.cod_delphos);";

        $resul2 = $db->prepare($select2);
        //Pasar a traves de un array los valores escritos en el formulario
        //Los valores se recogen por parametros en la función
        $resul2->execute(array(  $columna['periodoinicio'], $columna['periodofin']));  

            $personasGuardia='<td >';
            // Utilizamos un bucle while para recorrer todas las filas que devuelve la consulta
            while ($columna2 = $resul2->fetch(PDO::FETCH_ASSOC)) {
                $nombre =  $columna2['nombre'];
                $apellidos =  $columna2['apellidos'];

                $personasGuardia .= $columna2['nombre'].' '.$columna2['apellidos'].'<br>';

            }
            $personasGuardia .= '</td>';
            echo $personasGuardia;*/
    echo "</tr>";
}

?>