<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

    date_default_timezone_set('America/Lima');
    ini_set('default_charset', 'utf-8');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('content-type: application/json; charset=utf-8');
    //Respuesta en JSON
    //print_r(json_encode("asd"));
    
    $data = json_decode(file_get_contents('php://input'), true);
    //print_r($data);
    //exit;
    $nombre = $data["name"];
    $lastname = $data["lastname"];
    $email = $data["email"];
    $telefono = $data["phone"];
    $mensaje = $data["message"];
    $validator= array();
   if (empty($nombre)) {
        $validator+=['error_nombre'=>'Nombre es requerido.'];   
    } else {
    if (!preg_match("/^[a-zA-Z ]*$/",$nombre)) {
        $validator+=['error_nombre'=>'Solo letras y espacios son permitidos.'];  
    }
    }
    if (empty($lastname)) {
        $validator+=['error_apellido'=>'Apellido es requerido.'];   
    } else {
    if (!preg_match("/^[a-zA-Z ]*$/",$lastname)) {
        $validator+=['error_apellido'=>'Solo letras y espacios son permitidos.'];  
    }
    }
    if (empty($email)) {
        $validator+=['error_email'=>'Email es requerido.'];
    } else {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $validator+=['error_email'=>'Email inválido.'];
    }
    }
    if (empty($telefono)) {
        $validator+=['error_telefono'=>'Teléfono es requerido.'];
    } else{
    if (strlen($telefono) != 9) {
        $validator+=['error_telefono'=>'Teléfono inválido.'];
    }
    }
    if (empty($mensaje)) {
        $validator+=['error_description'=>'Mensaje es requerido.'];
    }
    if (count($validator)==0){
        $mail = new PHPMailer(true);
        $valhtml  = array('%nombre%','%apellido%','%email%', '%telefono%', '%mensaje%');
        $valphp = array($nombre, $lastname, $email, $telefono, $mensaje);
        $content = str_replace($valhtml, $valphp, file_get_contents('./public/mailer/index.html'));
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'notificaciones@creasoftweb.com';
            $mail->Password   = 'Cr3450ft123';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            //Recipients
            $mail->setFrom('notificaciones@creasoftweb.com', 'SERVICIO DE NOTIFICACIONES DE CGM'); //tu email
            $mail->addAddress('mjota@creasoftweb.com');
            $mail->addAddress('jsilva@creasoftweb.com');
            //Content
            $mail->isHTML(true);

            // Activo condificación utf-8
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $subject ='Contacto Formulario CGM';
            $mail->Subject = $subject; // Titulo der correo
            $mail->Body = utf8_decode($content); //Cuerpo del correo
            //language
            $mail->setLanguage('es');
            $mail->send();
            $respuesta = (array("estado"=> 1,"mensaje"=>"Email enviado exitosamente"));
            echo json_encode($respuesta);
            die();
        } catch (Exception $e) {
            $respuesta = (array("estado"=> 2,"mensaje"=>"Error al enviar email, $e"));
            echo json_encode($respuesta);
            die();
        } 
    }else{
        $respuesta = (array("estado"=> 0,"mensaje"=>array($validator)));
        echo json_encode($respuesta);
        die();
    }

?>

