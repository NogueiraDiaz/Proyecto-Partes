<?php

include_once "plantillas/cabecera.inc.php";
include_once 'app/RepositorioSesion.inc.php';
RepositorioSesion::iniciarSesion();

include_once "lib/dompdf/autoload.inc.php";

use Dompdf\Dompdf;

$html = ob_get_clean();
$texto = "CONVIVENCIA";
if ($_SESSION["identificador_parte"] == "incidencia") {
    $texto = "INCIDENCIA";
}
$html = ' 
        <br>
        <table style="border-radius :5px;  background-color:#A9D0F5" width ="100%">
            <tr>
                <td style="text-align :center"> 
                <!--<img align= "right" src="image/julioverne.png">  -->                  
                <h2> PARTE ' . $texto . '</h2>
                </td>
            </tr>
        </table>
        <br> <br>
        <table style="border-bottom : 1px solid gray" width ="100%">
            <tr >
                <td width ="30%"> <b> ALUMNO:</b> </td>
                <td>' . $_SESSION["nombre_alumno"] . '</td>
            </tr>
        </table>
        
        <table style="border-bottom : 1px solid gray" width ="100%">
         
            <tr >
                <td width ="30%">  <b> GRUPO: </b></td>
                <td>' . $_SESSION["grupo"] . '</td>
            </tr>
        </table>
        
        <table style="border-bottom : 1px solid gray" width ="100%">
            <tr>
                <td width ="30%">  <b> PROFESOR: </b></td>
                <td>' . $_SESSION["nombre_profesor"] . '</td>
            </tr>
        </table>
        
        <table style="border-bottom : 1px solid gray" width ="100%">
            <tr>
                <td width ="30%">  <b> MATERIA: </b></td>
                <td>' . $_SESSION["materia"] . '</td>
            </tr>
        </table>
        
        <table style="border-bottom : 1px solid gray" width ="100%">            
            <tr>
                <td width ="30%">  <b> FECHA: </b></td>
                <td>' . $_SESSION["fecha"] . '</td>
            </tr>
        </table>
        
        <table style="border-bottom : 1px solid gray" width ="100%">            
            <tr>
                <td width ="30%">  <b> HORA: </b></td>
                <td>' . $_SESSION["hora"] . '</td>
            </tr>
        </table>';

if ($_SESSION["identificador_parte"] == "incidencia") {
    $html .= '<table style="border-bottom : 1px solid gray" width ="100%">            
                            <tr>
                                <td width ="30%">  <b> INCIDENCIA: </b></td>
                                <td >' . $_SESSION["nombre_incidencia"] . '</td>
                            </tr>
                        </table>
                    <table style="border-bottom : 1px solid gray" width ="100%">            
                            <tr>
                                <td width ="30%">  <b> PUNTOS: </b></td>
                                <td>' . $_SESSION["puntos_incidencia"] . '</td>
                            </tr>
                    </table> ';
}

$html .= '<table style="border-bottom : 1px solid gray" width ="100%">            
            <tr>
                <td width ="30%">  <b> COMUNICACIÓN: </b></td>
                <td >' . $_SESSION["medio_comunicacion_parte"] . '</td>
            </tr>
        </table>
        
        <table style="border-bottom : 1px solid gray" width ="100%">            
            <tr>
                <td width ="30%">  <b> FECHA COMUNICACIÓN: </b></td>
                <td >' . $_SESSION["fecha_comunicacion_parte"] . '</td>
            </tr>
        </table>
        <br>   
        <table style="border-radius :5px; border : 1px solid gray; padding:7px" width ="100%">    
            <tr>
                <td> <b> EL PROFESOR DESCRIBE LOS HECHOS: </b></td>
            </tr>';

if (empty(trim($_SESSION["descripcion_parte"]))) {
    $html .= '<tr>
                <td> <br> <br> <br> <br> <br> <br> </td>
            </tr> ';
} else {
    $html .= '<tr>
                <td style="text-align : justify"> '
            . $_SESSION["descripcion_parte"] . '   
                </td>
            </tr> ';
}

$html .= '</table>
        <br>   
        <table style="border-radius :5px; border : 1px solid gray; padding:7px" width ="100%">           
            <tr>
                <td> <b> EL ALUMNO DESCRIBE LOS HECHOS: </b></td>
            </tr>
            <tr>
                <td> <br> <br> <br> <br> <br> <br> </td>
            </tr>
        </table>
        <br>   
        <table style="border-radius :5px; border : 1px solid gray; padding:7px" width ="100%">             
            <tr>
                <td> <b> TAREAS: </b></td>
            </tr>
            <tr>
                <td> <br> <br> <br> <br> <br> <br> </td>
            </tr>
        </table>
        <br>
        <div style = "text-align: right" >Firma del Profesor:</div>
';

$dompdf = new Dompdf();

$dompdf->loadHtml($html);

$dompdf->setPaper("A4");
$dompdf->render();

$dompdf->stream("Parte_" . $_SESSION["nombre_alumno"] . "_" . $_SESSION["fecha"]);
?>



