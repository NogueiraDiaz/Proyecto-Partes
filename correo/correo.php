<?php
use PHPMailer\PHPMailer\PHPMailer;
    
    function enviarcorreo($direcciondeenvio,$asunto,$cuerpodecorreo){
        require "../vendor/autoload.php";

        $mail = new PHPMailer();
        $mail->IsSMTP();
        //creamos la conexion
        $mail->SMTPDebug = 0; //2 para que aprarezcan errores. 0 para que no aparezca nada
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls"; // protocolo de seguridad
        $mail->Host = "smtp.gmail.com"; // host 
        $mail->Port = 587; //puerto

        $mail->Username ="incidenciasiesbargas@gmail.com"; // nombre del usuario 
        $mail->Password = "dfwgkgfckkdytjlk"; //constraseña de aplicacion generada en configuracion 
        
        $mail->SetFrom("incidenciasiesbargas@gmail.com","Departamento de incidencias"); // quien lo envia y el nombre con el que te ve

        $mail->Subject = $asunto; //asunto del mensaje

        $mail->MSgHTML($cuerpodecorreo); // cuerpo del correo

        $address = $direcciondeenvio; // a quien se lo vas a enviar
        $mail->AddAddress($address,"Usuario"); //Test es un nombre que tendra ese usuario para ti 

        $resul = $mail->Send(); //hace el envio
        if(!$resul){//si el envido da falso salta un error
            echo "<br><br><br>Error". $mail->ErrorInfo . "<br><br><br>";
        }else{//si el envido da true salta el mensaje enviado 
            echo "<br>Correo enviado";
        }
    }
    //recogemos los inputs y validamos que no esten vacios 
    if(!isset($_POST['direccion'])||!isset($_POST['cuerpo'])||!isset($_POST['asunto'])){
        //echo ("campos vacios");
    }else{
    $direcciondeenvio=$_POST["direccion"];
    $cuerpodecorreo=$_POST["cuerpo"];
    $asunto=$_POST["asunto"];
    //llamamos a la funcion para enviar los valores de los inputs
    enviarcorreo($direcciondeenvio,$cuerpodecorreo,$asunto);
    }
?>