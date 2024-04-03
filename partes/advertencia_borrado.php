<?php

use FontLib\Table\Type\post;

include_once "app/RepositorioSesion.inc.php";
RepositorioSesion::borrarDatosSesion();

include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";


include_once"app/Conexion.inc.php";

include_once"app/RepositorioProfesor.inc.php";
include_once"app/Profesor.inc.php";

include_once "app/RepositorioAlumno.inc.php";
include_once "app/Alumno.inc.php";

include_once "app/ValidarParte.inc.php";
include_once'MySqlBackup.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


RepositorioSesion::iniciarSesion();

if (isset($_POST["no"])) {
    
header("Location: gestion_BaseDeDatos.php");
}
if (isset($_POST["si"])) {
    try {
        Conexion::abrirConexion();
        $arrayDbConf['host'] = SERVIDOR;
        $arrayDbConf['user'] = USUARIO;
        $arrayDbConf['pass'] = PASSWORD;
        $arrayDbConf['name'] = BASE_DATOS;
        $nombreArchivo = "CopiaBaseDatosPartesJulioVerne.sql";
        $bck = new MySqlBackupLite($arrayDbConf);
        $bck->setFileName($nombreArchivo); // nombre del archivo
        $bck->setFileDir('./copia_temporal/');
        $bck->backUp(); // realizar copia
        $bck->downloadFile(); // Descargar copia
        $bck->saveToFile(); // guardar en un fichero
    
        Conexion::cerrarConexion();
    }
    catch(Exception $e) {
        echo $e;
        Conexion::cerrarConexion();
    }

 $mail = new PHPMailer(true);
 try {
     //Server settings
	 
	 
	 
     $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;                     
     $mail->isSMTP();                     //direccion de SMTP
	 $mail->Host = 'smtp.servidor-correo.net';
     //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;                                  //puerto TCP
     $mail->Port = 587;
     $mail->Username = 'desarrollo@reservas.iesbargas.es';
     $mail->Password = 'Devs@2022';
	 $mail->SMTPAuth   = true;                     //Contraseña SMTP(Correo de emisor)
     //Recipients
     $mail->setFrom('sistemapartes@gmail.com', 'Sistema de alerta partes Julio Verne'); // direcion desde donde se envia
     $mail->addAddress('sistemapartes@gmail.com', 'User Test');     //direccion de envio
     $mail->addAddress('mendezpavonjorge@gmail.com');  
     $mail->addAddress('uvelaherrero@gmail.com'); 
     $mail->addAddress('arturo2000delossantos@gmail.com');//no puede estar vacio si no, no fuinciona.
     //$mail->addAddress('');             
     //$mail->addReplyTo('info@example.com', 'Information');
     //$mail->addCC('cc@example.com');
     //$mail->addBCC('bcc@example.com');
 
     //Attachments

     $mail->addAttachment('./copia_temporal/CopiaBaseDatosPartesJulioVerne.sql');         //Add attachments
     //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
 
     //Content
     $mail->isHTML(true);                                  //activar formato HTML
     $mail->Subject = 'Se ha borrado la base de datos de partes';
     //$mail->Body    = 'El usuario: <b>'.$_SESSION["nombre_profesor"].'</b> ha eliminado la base de datos de profesores,<br> se ha descargado un arschivo .SQL de recuperacion en el dispositivo del usuario';
     $mail->Body = '<div class="es-wrapper-color">
     <!--[if gte mso 9]>
         <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
             <v:fill type="tile" color="#f6f6f6"></v:fill>
         </v:background>
     <![endif]-->
     <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0">
         <tbody>
             <tr>
                 <td class="esd-email-paddings" valign="top">
                     <table class="esd-header-popover es-header" cellspacing="0" cellpadding="0" align="center">
                         <tbody>
                             <tr>
                                 <td class="esd-stripe" align="center">
                                     <table class="es-header-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                                         <tbody>
                                             <tr>
                                                 <td class="esd-structure es-p10t es-p10b es-p20r es-p20l" esd-general-paddings-checked="true" esd-custom-block-id="14346" align="left">
                                                     <!--[if mso]><table width="560" cellpadding="0" cellspacing="0"><tr><td width="268" valign="top"><![endif]-->
                                                     <table class="es-left" cellspacing="0" cellpadding="0" align="left">
                                                         <tbody>
                                                             <tr>
                                                                 <td class="esd-container-frame" width="268" align="left">
                                                                     <table width="100%" cellspacing="0" cellpadding="0">
                                                                         <tbody>
                                                                             <tr>
                                                                                 <td class="esd-block-image es-m-p0l es-m-txt-l" align="left" style="font-size: 0px;"><a href="http://ies-julioverne.centros.castillalamancha.es/sites/ies-julioverne.centros.castillalamancha.es/files/julioverne.png" target="_blank"><img src="http://ies-julioverne.centros.castillalamancha.es/sites/ies-julioverne.centros.castillalamancha.es/files/julioverne.png" alt width="108" style="display: block;"></a></td>
                                                                             </tr>
                                                                         </tbody>
                                                                     </table>
                                                                 </td>
                                                             </tr>
                                                         </tbody>
                                                     </table>
                                                     <!--[if mso]></td><td width="20"></td><td width="272" valign="top"><![endif]-->
                                                     <table class="es-right" cellspacing="0" cellpadding="0" align="right">
                                                         <tbody>
                                                             <tr>
                                                                 <td class="esd-container-frame" width="272" align="left">
                                                                     <table width="100%" cellspacing="0" cellpadding="0">
                                                                         <tbody>
                                                                             <tr>
                                                                                 <td class="esd-block-text es-p10t es-m-txt-l" align="right">
                                                                                     <p>Sistema de alerta</p>
                                                                                     <p>Borrado de base de datos</p>
                                                                                 </td>
                                                                             </tr>
                                                                         </tbody>
                                                                     </table>
                                                                 </td>
                                                             </tr>
                                                         </tbody>
                                                     </table>
                                                     <!--[if mso]></td></tr></table><![endif]-->
                                                 </td>
                                             </tr>
                                         </tbody>
                                     </table>
                                 </td>
                             </tr>
                         </tbody>
                     </table>
                     <table cellpadding="0" cellspacing="0" class="es-content esd-footer-popover" align="center">
                         <tbody>
                             <tr>
                                 <td class="esd-stripe" esd-custom-block-id="14325" align="center">
                                     <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                                         <tbody>
                                             <tr>
                                                 <td class="esd-structure es-p20t es-p20r es-p20l" align="left">
                                                     <table width="100%" cellspacing="0" cellpadding="0">
                                                         <tbody>
                                                             <tr>
                                                                 <td class="esd-container-frame" width="560" valign="top" align="center">
                                                                     <table width="100%" cellspacing="0" cellpadding="0">
                                                                         <tbody>
                                                                             <tr>
                                                                                 <td align="left" class="esd-block-text">
                                                                                     <p style="font-size: 19px;">El usuario: <strong>'.$_SESSION["nombre_profesor"].'</strong> ha realizado un borrado de la base de datos de partes del instituto, se ha adjuntado a este correo un SCRIPT de recuperacion<strong> TOTAL </strong>de la base de datos, este archivo también quedará almacenado de forma temporal en el servidor y habrá sido descargado automáticamente en el dispositivo desde que realizo el borrado.<br></p>
                                                                                 </td>
                                                                             </tr>
                                                                         </tbody>
                                                                     </table>
                                                                 </td>
                                                             </tr>
                                                         </tbody>
                                                     </table>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td class="esd-structure esdev-adapt-off" align="left">
                                                     <table class="esdev-mso-table" width="600" cellspacing="0" cellpadding="0">
                                                         <tbody>
                                                             <tr>
                                                                 <td class="esdev-mso-td" valign="top">
                                                                     <table class="es-left" cellspacing="0" cellpadding="0" align="left">
                                                                         <tbody>
                                                                             <tr>
                                                                                 <td class="es-m-p20b esd-container-frame" width="300" align="left">
                                                                                     <table width="100%" cellspacing="0" cellpadding="0">
                                                                                         <tbody>
                                                                                             <tr>
                                                                                                 <td class="esd-block-spacer es-p5t es-p5b" align="right">
                                                                                                     <table width="15%" height="100%" cellspacing="0" cellpadding="0" border="0">
                                                                                                         <tbody>
                                                                                                             <tr>
                                                                                                                 <td style="border-bottom: 3px solid #31cb4b; background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%; height: 1px; width: 100%; margin: 0px;"></td>
                                                                                                             </tr>
                                                                                                         </tbody>
                                                                                                     </table>
                                                                                                 </td>
                                                                                             </tr>
                                                                                         </tbody>
                                                                                     </table>
                                                                                 </td>
                                                                             </tr>
                                                                         </tbody>
                                                                     </table>
                                                                 </td>
                                                                 <td class="esdev-mso-td" valign="top">
                                                                     <table class="es-right" cellspacing="0" cellpadding="0" align="right">
                                                                         <tbody>
                                                                             <tr>
                                                                                 <td class="esd-container-frame" width="300" align="left">
                                                                                     <table width="100%" cellspacing="0" cellpadding="0">
                                                                                         <tbody>
                                                                                             <tr>
                                                                                                 <td class="esd-block-spacer es-p5t es-p5b" align="left">
                                                                                                     <table width="15%" height="100%" cellspacing="0" cellpadding="0" border="0">
                                                                                                         <tbody>
                                                                                                             <tr>
                                                                                                                 <td style="border-bottom: 3px solid #333333; background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%; height: 1px; width: 100%; margin: 0px;"></td>
                                                                                                             </tr>
                                                                                                         </tbody>
                                                                                                     </table>
                                                                                                 </td>
                                                                                             </tr>
                                                                                         </tbody>
                                                                                     </table>
                                                                                 </td>
                                                                             </tr>
                                                                         </tbody>
                                                                     </table>
                                                                 </td>
                                                             </tr>
                                                         </tbody>
                                                     </table>
                                                 </td>
                                             </tr>
                                         </tbody>
                                     </table>
                                 </td>
                             </tr>
                         </tbody>
                     </table>
                 </td>
             </tr>
         </tbody>
     </table>
 </div>';
     $mail->AltBody = 'El usuario: '.$_SESSION["nombre_profesor"].'ha eliminado la base de datos de profesores, se ha descargado un arschivo .SQL de recuperacion en el dispositivo del usuario'; // contenido alternativo para correos no HTML
     $mail->send(); // Enviar correo
     echo 'Mensaje enviado';
 } catch (Exception $e) {
     echo "Error: {$mail->ErrorInfo}";
 }



       // unlink('./copia_temporal/CopiaBaseDatosPartesJulioVerne.sql');
        
        
        try{ 
            Conexion::abrirConexion();
            $mysqli = new mysqli(SERVIDOR, USUARIO, PASSWORD, BASE_DATOS);
            $mysqli->query("DELETE FROM Partes");
            $mysqli->query("DELETE FROM Expulsiones");
            $mysqli->query("DELETE FROM Alumnos");
            $mysqli->query("DELETE FROM Profesores where Nivel_Acceso <> 0"); 
            $mysqli->close();
            echo "<script>alert('borrado completado');</script>";
        }
        catch(Exception $e){
        echo $e;
        echo "<script>alert('error en borrado');</script>";
        }
        
Conexion::cerrarConexion();
}
?>  

<div class="container">
    <br>
    <br>
    <br>
    <div class="row mifondoGlow">
        <h3 class="text-center mifondo miversalita micoloretiqueta 
            mipaddingtitulo">¿Estás seguro de que desea borrar los datos?</h3>
        <form class="center-block mipadding" method="post" action="<?php $_SERVER["PHP_SELF"] ?>">
            <div class="row"> 
                <div class="col-md-4 col-md-offset-2"> 
                    <button class="btn btn-lg btn-success btn-block miversalita mimargensuperior15" 
                            type="submit" name="no">NO</button>
                </div>
                <div class="col-md-4  "> 
                    <button title="CUIDADO"class=" btn  btn-lg btn-danger btn-block miversalita mimargensuperior15" 
                            type="submit"  name="si">SI</button>                            
                </div>
            </div>
        </form>
    </div>
</div>

<?php
include_once "plantillas/pie.inc.php";
?>