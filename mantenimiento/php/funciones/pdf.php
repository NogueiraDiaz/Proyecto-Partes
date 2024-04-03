<?php

require_once ('../../../vendor/autoload.php'); // Ruta a la carpeta de la librerÃ­a mPDF
require_once('../../../archivosComunes/conexion.php');
session_start();

// Crear una instancia de mPDF
$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);

$stylesheet = file_get_contents('../../css/tabla.css');
$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);


// Crear contenido HTML para la tabla
$mpdf->WriteHTML('<h1>INCIDENCIAS</h1>');
$mpdf->WriteHTML('<table>
    
        <thead>
            <tr>
                <th scope="col">Codigo</th>
                <th scope="col">Estado de la tarea</th>
                <th scope="col">Nivel de tarea</th>
                <th scope="col">Localizacion</th>
                <th scope="col">Descripción</th>
                <th scope="col">Comentario</th>
                <th scope="col">Tarea creada por</th>
                <th scope="col">Fecha inicio</th>
                <th scope="col">Tipo de incidencia</th>
            </tr>
        </thead>
        <tbody>');
            
            $cod = $_SESSION['usuario_login']['cod_usuario'];

            // consulta 
            if($_SESSION['usuario_login']['rol'] == 2){
                $consulta = "SELECT * FROM Tareas WHERE tipo_incidencia = 'centro'";
            }elseif($_SESSION['usuario_login']['rol'] == 1){
                $consulta = "SELECT * FROM Tareas WHERE tipo_incidencia = 'informatica' AND cod_usuario_gestion = (SELECT cod_usuario FROM Usuarios WHERE cod_usuario = '$cod')";
            }elseif($_SESSION['usuario_login']['rol'] == 0){
                $consulta = "SELECT * FROM Tareas";
            }

            //Preparo la consulta
            $preparada = $db->prepare($consulta);
            $preparada->execute();

            $resultados = $preparada->fetchAll(PDO::FETCH_ASSOC);  

           foreach ($resultados as $row){

                $codTarea = $row["cod_tarea"];

                // Subconsulta para sacar el nombre del cod usuarui gestion de la tabla tareas.
                $subConsultaNombre = "SELECT nombre FROM Usuarios WHERE cod_usuario = (SELECT cod_usuario_gestion FROM Tareas WHERE cod_tarea = '$codTarea')";
                $subConsultaNombre = $db->query($subConsultaNombre);


                $mpdf->WriteHTML('<tr><td>'. $row["cod_tarea"] .'</td>');
                $mpdf->WriteHTML('<td>'. $row["estado"] .'</td>');
                $mpdf->WriteHTML('<td>'. $row["nivel_tarea"] .'</td>');
                $mpdf->WriteHTML('<td>'. $row["localizacion"] .'</td>');
                $mpdf->WriteHTML('<td>'. $row["descripcion"] .'</td>');
                $mpdf->WriteHTML('<td>'. $row["comentario"] .'</td>');

                foreach ($subConsultaNombre as $row2) {
                    $mpdf->WriteHTML('<td>'. $row2["nombre"] .'</td>');  
                }

                $mpdf->WriteHTML('<td>'. $row["fecha_inicio"] .'</td>');
                $mpdf->WriteHTML('<td>'. $row["tipo_incidencia"] .'</td> </tr>');          
            }

$mpdf->WriteHTML('</tbody>
</table>');


// Guardar el PDF en un archivo
$mpdf->Output('incidencias.pdf', 'I');


?>