<?php

include_once "plantillas/cabecera.inc.php";
include_once 'app/RepositorioSesion.inc.php';
RepositorioSesion::iniciarSesion();

include_once "app/Conexion.inc.php";
include_once 'app/RepositorioExpulsion.inc.php';
include_once 'app/RepositorioParte_Expulsion.inc.php';
include_once "lib/dompdf/autoload.inc.php";

Conexion::abrirConexion();
$datos_expulsion = RepositorioParte_Expulsion::getDatosExpulsion
                (Conexion::getConexion(), $_SESSION["cod_expulsion"]);

$fecha_expulsion = RepositorioExpulsion::getdatosExpulsionCodigo
                (Conexion::getConexion(), $_SESSION["cod_expulsion"]);

Conexion::cerrarConexion();

use Dompdf\Dompdf;
$mes = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto"
    ,"Septiembre","Octubre","Noviembre","Dicicembre");
$fecha= explode("-", date("d-m-Y"));
echo "La fecja es " .$fecha ."<br>";
echo "El dia es " .$fecha[0] ."<br>";
echo "El mwa es " .$fecha[1] ."<br>";
echo "El año es " .$fecha[2] ."<br>";

$html = ob_get_clean();

$html = ' 
        <br><br>
        <table width ="100%">
            <tr>
                <td width = "40%" style="text-align :center"> 
                    <img height = "110px" width = "120px" src="image/logo_junta.png">
                </td>
            
                <td width = "10%" style="text-align :center"> 
                    &nbsp;
                </td>
            
                <td width = "40%">
                    <div> <b>I.E.S. Julio Verne de Bargas</b></div>
                    <div> Consejería de Educación, Ciencia y Cultura</div>
                    <div> C/ Instituto s/n – 45593 Bargas (Toledo) </div>
                    <div> Tel: 925358268 <div>
                    <div> jefatura@iesbargas.com </div>
                </td>
            </tr>
        </table>
        <br> <br>
        
        <table width ="100%"style="text-align :center"> 
            <tr >
                <td>
                    <b>NOTIFICACIÓN DE MEDIDA ADOPTADA PARA CORREGIR LA CONDUCTA 
                    DEL ALUMNADO <br> 
                    (Conducta gravemente perjudicial para la convivencia)
                    </b>
                </td>
            </tr>
         </table>
            <br>
            <br>
        <table width ="100%">    
            <tr >
                <td >
                   Alumno/a: <b>' . $datos_expulsion[0]["nom_alumno"]
                    . ' ' .  $datos_expulsion[0]["ape_alumno"] . '</b>
                </td>
                <td style = "text-align: right">
                   Fecha Notificación: <b>' . date("d-m-Y") .'</b>
                </td>
            </tr>
        </table>
        <br>
        <br>
        <table width ="100%">
            <tr >
                <td style = "text-align: justify">
                   D. Daniel Fernández Gutiérrez, Director del centro IES Julio Verne 
                   le comunica que, en el ejercicio de la competencia atribuida en el 
                   Decreto 3/2008, de la Convivencia Escolar de Castilla-La Mancha (DOCM 11-01-2008)
                   <br><br>
                    Se procederá a corregir las siguientes conductas de su hijo/a, 
                    tipificado como gravemente perjudiciales para la convivencia.<br>
                    <b>Conductas:</b><br> <blockquote>';
foreach ($datos_expulsion as $expulsion) {
    $html .= '- ' . $expulsion["nom_incidencia"] . '<br>';
}

$html .= '</blockquote><br>
                </td>
            </tr>
       
            <tr >
                <td style = "text-align: justify">
                  <b>Medidas correctoras impuestas:</b>
                  <br>
                    Realización de tareas educativas en su domicilio, 
                    con suspensión temporal de la asistencia al propio 
                    centro docente desde el día <b> ' .
        date("d-m-Y", strtotime($fecha_expulsion["fecha_inicio_expulsion"]))
        . '</b> al <b>' .
        date("d-m-Y", strtotime($fecha_expulsion["fecha_fin_expulsion"]))
        . '</b>.' .
        '<br><br>    
                </td>
            </tr>
            <tr >
                <td style = "text-align: right">
                  En Bargas, a '.$fecha[0].' de '. $mes[((int)$fecha[1]-1)]. ' de '. $fecha[2].
                    '.<br> <br> <br> <br> <br> <br>
                    EL DIRECTOR.
                </td>
            </tr>
        </table>';

$dompdf = new Dompdf();

$dompdf->loadHtml($html);

$dompdf->setPaper("A4");
$dompdf->render();

$dompdf->stream("Expulsión_" . $datos_expulsion[0]["nom_alumno"] . ' '
        . $datos_expulsion[0]["ape_alumno"] . "_"
        . date("d-m-Y", strtotime($fecha_expulsion["fecha_inicio_expulsion"])));
?>





