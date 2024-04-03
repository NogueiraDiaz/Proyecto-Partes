<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../includes/extras/PHPmailer/Exception.php';
require '../../includes/extras/PHPmailer/PHPMailer.php';
require '../../includes/extras/PHPmailer/SMTP.php';
/**
 * Implementación personalizada de PHPmailer para enviar correos premontados o personalizados.
 * Realizado por: Eloy Rodríguez Martín (ERMtn)
 */
class Mailer extends PHPMailer{
    const siteURL = 'https://40303120.servicio-online.net/reservas/';
    /**
     * @param String $to Email del destinatario
     */
    public function __construct($to){

        $this->isSMTP();

        // MODIFICAR CON EL SERVICIO SMTP FINAL A USAR
        $this->Host = 'smtp.servidor-correo.net';
        $this->Port = 587;
        $this->Username = 'desarrollo@reservas.iesbargas.es';
        $this->Password = 'Devs@2022';
        // CORREO Y NOMBRE A MOSTRAR EN LOS MENSAJES ENVIADOS
        $from = 'direccion@iesbargas.com';
        $fromName = 'ReservApp IES Julio Verne';

        $this->SMTPAuth = true;
        $this->setFrom($from, $fromName);
        $this->addAddress($to);
        $this->CharSet = 'UTF-8';
    }

    public function customMail($subject,$msgHTML,$msgALT){
        $this->Subject = $subject;
        $this->msgHTML($msgHTML);
        $this->AltBody = $msgALT;

        if(!$this->send()){
            return false;
            //echo json_encode(array("isok"=>false,"error"=>$this->ErrorInfo));
        } else{
            return true;
            //echo json_encode(array("isok"=>true,"data"=>"Custom mail sent!"));
        }
    }

    public function passwdRecovery($newPass){
        $this->Subject = 'ReservApp IES Julio Verne. Recuperación de contraseña';
        $this->msgHTML('<h2>Recuperación de contraseña</h2><p>Su nueva contraseña es: <strong>'.$newPass.'</strong></p><strong>Recuerde cambiarla lo antes posible!</strong></p><br><br><p>Si usted no ha solicitado esto, póngase en contacto con jefatura.</p><br><button><a style="padding: 20px; font-weight: bold;" href="'.self::siteURL.'">Inicia sesión aqui</a></button><br><p>IES Julio Verne &nbsp;&nbsp; BARGAS</p>');
        $this->AltBody = 'Recuperación de contraseña. Su nueva contraseña es: '.$newPass.'. Recuerde cambiarla lo antes posible! Si usted no ha solicitado esto, póngase en contacto con jefatura. IES Julio Verne, BARGAS ( https://reservas.iesbargas.es )';

        if(!$this->send()){
            return false;
            //echo json_encode(array("isok"=>false,"error"=>$this->ErrorInfo));
        } else{
            return true;
            //echo json_encode(array("isok"=>true,"data"=>"Password recovery sent!"));
        }
    }

    public function userActivated(){
        $this->Subject = 'ReservApp IES Julio Verne. Usuario activado';
        $this->msgHTML('<h2>¡Usuario activado!</h2><p>Su usuario para ReservApp ya ha sido activado y puede hacer uso de la aplicación.</p><br><p>IES Julio Verne &nbsp;&nbsp; BARGAS</p>');
        $this->AltBody = 'Su usuario para ReservApp ya ha sido activado y puede hacer uso de la aplicación ( https://reservas.iesbargas.es ). Si tiene algún problema, póngase en contacto con jefatura. IES Julio Verne, BARGAS';
        if(!$this->send()){
            return false;
            //echo json_encode(array("isok"=>false,"error"=>$this->ErrorInfo));
        } else{
            return true;
            //echo json_encode(array("isok"=>true,"data"=>"User activated sent!"));
        }
    }
}