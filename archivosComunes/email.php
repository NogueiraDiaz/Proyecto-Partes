<?php
use PHPMailer\PHPMailer\PHPMailer;
require "../vendor/autoload.php";

try {
        //Hago la conexion a la base de datos
        // $db = require_once('conexion.php');

    $mail = new PHPMailer();
    $mail->IsSMTP();

    $mail->SMTPDebug = 0; 
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;

    // Datos del remitente:
    $mail->Username = "incidenciasiesbargas@gmail.com";
    $mail->Password = "dfwgkgfckkdytjlk"; 

    // Remitente y asunto:
    $mail->SetFrom("incidencias@iesbargas.com", "Registro de usuario");

    // Título del correo:
    $mail->Subject ="Nuevo usuario registrado";

    // Mensaje que aparece en el correo.
    $mail->MSgHTML("Un nuevo usuario ha sido registrado, por favor acceda a la aplicación para validarlo."); 

    /* // Esto se utiliza para enviar el archivo que deseemos
    $mail->addAttachment("F:/borrar.txt");  */

    // Consulta para sacar los emails de los administradores:
    $sql = $db->query("SELECT email FROM Usuarios WHERE rol = '0'");

        // Bucle que enviará el correo a cada administrador:
        foreach($sql as $email){
            // Añadimos dirección: 
            $mail->AddAddress($email["email"], "Registro IES Julio Verne"); 
            // Enviamos email:
            $result = $mail->Send();
            if(!$result){
                echo "<br><br><br>Error: " . $mail->ErrorInfo . "<br><br><br>";
            }
            $mail->clearAddresses();
        }

    } catch (PDOException $e) {
        echo "Error en la base de datos ".$e->getMessage();
    }

?>