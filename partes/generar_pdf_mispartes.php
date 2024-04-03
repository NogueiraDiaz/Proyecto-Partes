<?php

include_once "plantillas/cabecera.inc.php";
include_once 'app/RepositorioSesion.inc.php';
RepositorioSesion::iniciarSesion();

include_once "app/Conexion.inc.php";
include_once 'app/RepositorioParte.inc.php';
include_once 'app/RepositorioParte_Expulsion.inc.php';
include_once "lib/dompdf/autoload.inc.php";

Conexion::abrirConexion();
if (isset($_SESSION["mispartes"])) {
    $datos_parte = RepositorioParte::getDatosParte
            (Conexion::getConexion(), $_SESSION["codigo_parte"]);
    unset($_SESSION["mispartes"]);
}

if (isset($_SESSION["mispartes_expulsion"])) {
    $datos_parte = RepositorioParte_Expulsion::getDatosParteExpulsion
            (Conexion::getConexion(), $_SESSION["codigo_parte"]);
    unset($_SESSION["mispartes_expulsion"]);
}

Conexion::cerrarConexion();

use Dompdf\Dompdf;

$html = ob_get_clean();
$texto = "CONVIVENCIA";
if ($datos_parte["puntos_parte"] > 0) {
    $texto = "INCIDENCIA";
}
$html = ' 
        <br>
        <table style="border-radius :5px;  background-color:#A9D0F5" width ="100%">
            <tr>
                <td style="text-align :center"> 
                <h2> PARTE ' . $texto . '</h2>
                </td>
            </tr>
        </table>
        <br> <br>
        <table style="border-bottom : 1px solid gray" width ="100%">
            <tr >
                <td width ="30%"> <b> ALUMNO:</b> </td>
                <td>' . $datos_parte["nom_alumno"] . ' ' . $datos_parte["ape_alumno"] . '</td>
            </tr>
        </table>
        
        <table style="border-bottom : 1px solid gray" width ="100%">
         
            <tr >
                <td width ="30%">  <b> GRUPO: </b></td>
                <td>' . $datos_parte["grupo_alumno"] . '</td>
            </tr>
        </table>
        
        <table style="border-bottom : 1px solid gray" width ="100%">
            <tr>
                <td width ="30%">  <b> PROFESOR: </b></td>
                <td>' . $datos_parte["nom_profesor"] . ' ' . $datos_parte["ape_profesor"] . '</td>
            </tr>
        </table>
        
        <table style="border-bottom : 1px solid gray" width ="100%">
            <tr>
                <td width ="30%">  <b> MATERIA: </b></td>
                <td>' . $datos_parte["materia_parte"] . '</td>
            </tr>
        </table>
        
        <table style="border-bottom : 1px solid gray" width ="100%">            
            <tr>
                <td width ="30%">  <b> FECHA: </b></td>
                <td>' . date("d-m-Y", strtotime($datos_parte["fecha_parte"])) . '</td>
            </tr>
        </table>
        
        <table style="border-bottom : 1px solid gray" width ="100%">            
            <tr>
                <td width ="30%">  <b> HORA: </b></td>
                <td>' . $datos_parte["hora_parte"] . '</td>
            </tr>
        </table>';

if ($datos_parte["puntos_parte"] > 0) {
    $html .= '<table style="border-bottom : 1px solid gray" width ="100%">            
                            <tr>
                                <td width ="30%">  <b> INCIDENCIA: </b></td>
                                <td >' . $datos_parte["nom_incidencia"] . '</td>
                            </tr>
                        </table>
                    <table style="border-bottom : 1px solid gray" width ="100%">            
                            <tr>
                                <td width ="30%">  <b> PUNTOS: </b></td>
                                <td>' . $datos_parte["puntos_parte"] . '</td>
                            </tr>
                    </table> ';
}

$html .= '<table style="border-bottom : 1px solid gray" width ="100%">            
            <tr>
                <td width ="30%">  <b> COMUNICACIÓN: </b></td>
                <td >' . $datos_parte["via_comunicacion_familia"] . '</td>
            </tr>
        </table>
        
        <table style="border-bottom : 1px solid gray" width ="100%">            
            <tr>
                <td width ="30%">  <b> FECHA COMUNICACIÓN: </b></td>
                <td >' . date("d-m-Y", strtotime($datos_parte["fecha_comunicacion_familia"])) . '</td>
                    
            </tr>
        </table>
        <br>   
        <table style="border-radius :5px; border : 1px solid gray; padding:7px" width ="100%">    
            <tr>
                <td> <b> EL PROFESOR DESCRIBE LOS HECHOS: </b></td>
            </tr>';

if (empty(trim($datos_parte["descripcion_profesor"]))) {
    $html .= '<tr>
                <td> <br> <br> <br> <br> <br> <br> </td>
            </tr> ';
} else {
    $html .= '<tr>
                <td style="text-align : justify"> '
            . $datos_parte["descripcion_profesor"] . '   
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

$dompdf->stream("Parte_" . $datos_parte["nom_alumno"] . ' '
        . $datos_parte["ape_alumno"] . "_"
        . date("d-m-Y", strtotime($datos_parte["fecha_parte"])));
?>




