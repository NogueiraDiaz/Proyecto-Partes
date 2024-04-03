<?php

include_once "plantillas/cabecera.inc.php";
include_once "app/RepositorioSesion.inc.php";
RepositorioSesion::iniciarSesion();

include_once "app/Conexion.inc.php";

include_once "app/RepositorioAlumno.inc.php";
include_once "app/RepositorioParte.inc.php";
include_once "app/RepositorioExpulsion.inc.php";


$html = ob_get_clean();
Conexion::abrirConexion();
$grupos = RepositorioAlumno::getGrupos(Conexion::getConexion());

foreach ($grupos as $grupo) {
    $totales_partes_alumnos = RepositorioParte::getTotalNumeroPartesyPartesAlumno(
                    Conexion::getConexion(), $grupo["grupo_alumno"]
                    , $_SESSION["fecha_inicio"], $_SESSION["fecha_fin"]);

    $partes_alumnos_sin_expulsiones = RepositorioParte::getNumeroPartesyPartesAlumnosinExpulsion(
                    Conexion::getConexion(), $grupo["grupo_alumno"]
                    , $_SESSION["fecha_inicio"], $_SESSION["fecha_fin"]);

    $expulsiones_alumno = RepositorioExpulsion::getExpulsionesAlumnos(
                    Conexion::getConexion(), $grupo["grupo_alumno"]
                    , $_SESSION["fecha_inicio"], $_SESSION["fecha_fin"]);

    $html = '  <br>
        <table style="border-radius :5px; color:gray; background-color:#A9D0F5" width ="100%">
            <tr>
                <td style="text-align :center"> 
                <h3> INFORMACION PARTES ' . $grupo["grupo_alumno"] . '</h3>
               <h3> PERIODO: ' . $_SESSION["fecha_inicio"] . ' - ' . $_SESSION["fecha_fin"] . '</h3>
                </td>
            </tr>
        </table>
        <br>
    
        
        <table style="background-color:#A9D0F5" border: 1px solid gray" width ="100%">  
            <tr style="border-bottom : 1px solid gray">
                <td>   <b>PARTES SIN EXPULSION  </b>   </td>
            </tr>
        </table>
       <table style="border-radius :5px;  border: 1px solid gray" width ="100%"> 
            <tr >
                <td width ="30%"> <b> ALUMNO:</b> </td>
                <td width ="30%"> <b> NUMERO DE PARTES:</b> </td>
                <td width ="30%"> <b> PUNTOS PARTES:</b> </td>
                
            </tr>';

    foreach ($partes_alumnos_sin_expulsiones as $parte_alumno) {
        $html .= ' 
            <tr >
                <td>' . $parte_alumno["nom_alumno"] . " " . $parte_alumno["ape_alumno"] . '</td>
                <td>' . $parte_alumno["partes"] . '</td>
                <td>' . $parte_alumno["puntos"] . '</td>
            </tr> ';
        //include 'plantillas/creacion_varible_pdf_partes_tutores.inc.php';
    }
    $html .= '  </table> <br>
    
    <table style="background-color:#A9D0F5" border: 1px solid gray" width ="100%">  
            <tr style="border-bottom : 1px solid gray">
                <td> <b> TOTAL PARTES</b> </td>
            </tr>
        </table>
       <table style="border-radius :5px;  border: 1px solid gray" width ="100%"> 
            <tr >
                <td width ="30%"> <b> ALUMNO:</b> </td>
                <td width ="30%"> <b> NUMERO DE PARTES:</b> </td>
                <td width ="30%"> <b> PUNTOS PARTES:</b> </td>
                
            </tr>';



    foreach ($totales_partes_alumnos as $parte_alumno) {
        /* echo "GRUPO:" . $grupo["grupo_alumno"];
          echo "nombre del alumno " . ($parte_alumno["nom_alumno"] . " " . $parte_alumno["ape_alumno"]) . "<br>";
          echo " Total partes" . $parte_alumno["total_partes"] . "<br>";
          echo " Total Puntos" . $parte_alumno["total_puntos"] . "<br> <br>";
         */
        $html .= ' 
            <tr >
                <td>' . $parte_alumno["nom_alumno"] . " " . $parte_alumno["ape_alumno"] . '</td>
                <td>' . $parte_alumno["total_partes"] . '</td>
                <td>' . $parte_alumno["total_puntos"] . '</td>
            </tr> ';

        //include 'plantillas/creacion_varible_pdf_partes_tutores.inc.php';
    }

    $html .= '  </table> <br>
    
    <table style="background-color:#A9D0F5" border: 1px solid gray" width ="100%">  
            <tr style="border-bottom : 1px solid gray">
                <td> <b> EXPULSIONES</b> </td>
            </tr>
        </table>
       <table style="border-radius :5px;  border: 1px solid gray" width ="100%"> 
            <tr >
                <td width ="30%"> <b> ALUMNO:</b> </td>
                <td width ="30%"> <b> FECHA INICIO:</b> </td>
                <td width ="30%"> <b> FECHA FIN:</b> </td>
                
            </tr>';
    foreach ($expulsiones_alumno as $expulsion_alumno) {
        $html .= ' 
            <tr >
                <td>' . $expulsion_alumno["nom_alumno"] . " " . $expulsion_alumno["ape_alumno"] . '</td>
                <td>' . date("d-m-Y", strtotime($expulsion_alumno["fecha_inicio_expulsion"])) . '</td>
                <td>' . date("d-m-Y", strtotime($expulsion_alumno["fecha_fin_expulsion"])) . '</td>
            </tr> ';

        //include 'plantillas/creacion_varible_pdf_partes_tutores.inc.php';
    }

    $html .= '  </table>';
    echo $html . "<br>";
    //include 'segunda_parte.php';
}
Conexion::cerrarConexion();














