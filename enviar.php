<?php

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
    //print_r(json_encode($respuesta));
    $data = json_decode(file_get_contents('php://input'), true);
    //print_r($data);
    //exit;
    $tipo_documento = $data["tipo_documento"];
    $numero_documento = $data["numero_documento"];
    $nombre = $data["nombre"];
    $telefono = $data["telefono"];
    $lugar = $data["lugar"];
    $requerimientos = $data["requerimientos"];
    $validator= array();
    $valida_error = 0;

    //Validaciones
    if (empty($numero_documento)) {
        $validator[] = ['error_numero_documento' => "Numero de documento no puede ser vacio"];
        $valida_error = 1;
    }else{
        $validator[] = ['error_numero_documento' => ""];
    }
    if (empty($nombre)) {
        $validator[] = ['error_nombre' => "Nombres no puede ser vacio"]; 
        $valida_error = 1;
    } 
    else {
        if (!preg_match("/^[a-zA-Z ]*$/",$nombre)) {
            $validator[] = ['error_nombre' => "Solo letras y espacios son permitidos"];
            $valida_error = 1;
        }
        else{
            $validator[] = ['error_nombre' => ""];
        }
    }
    if (empty($telefono)) {
        $validator[] = ['error_telefono' => "Telefono no puede ser vacio"];
        $valida_error = 1;
    } else{
        if (strlen($telefono) != 9) {
            $validator[] = ['error_telefono' => "Telefono es inválido"];
            $valida_error = 1;
        }else{
            $validator[] = ['error_telefono' => ""];
        }
    }
    if (empty($lugar)) {
        $validator[] = ['error_lugar' => "Lugar no puede ser vacio"];
        $valida_error = 1;
    }else{
        $validator[] = ['error_lugar' => ""];
    }
    if (empty($requerimientos)) {
        $validator[] = ['error_requerimientos' => "Requerimientos no puede ser vacio"];
        $valida_error = 1;
    }else{
        $validator[] = ['error_requerimientos' => ""];
    }
    if ( $valida_error==0 ) {

        $mail = new PHPMailer(true);
        $valhtml  = array('%tipo_documento%','%numero_documento%','%nombre%', '%telefono%', '%lugar%', '%requerimientos%');
        $valphp = array($tipo_documento, $numero_documento, $nombre, $telefono, $lugar, $requerimientos);
        $content = str_replace($valhtml, $valphp, file_get_contents('./public/mailer/index.html'));
        
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'lhuaman@creasoftweb.com';
            $mail->Password   = 'Lhuaman1812';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            //Recipients
            $mail->setFrom('lhuaman@creasoftweb.com', 'SERVICIO DE NOTIFICACIONES DE LANDEV'); //tu email
            $mail->addAddress('lhuaman@creasoftweb.com');
            //Content
            $mail->isHTML(true);

            // Activo condificación utf-8
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $subject ='Contacto Formulario LANDEV';
            $mail->Subject = $subject; // Titulo der correo
            $mail->Body = utf8_decode($content); //Cuerpo del correo
            //language
            $mail->setLanguage('es');
            $mail->send();
            $respuesta = (array("estado"=> 1,"mensaje"=>"Email enviado exitosamente"));
            die(json_encode($respuesta));
        } catch (Exception $e) {
            $respuesta = (array("estado"=> 2,"mensaje"=>"Error al enviar email, $e"));
            die(json_encode($respuesta));
        } 
    }else{
        $respuesta = (array("estado"=> 0,"mensaje"=>$validator));
        die(json_encode($respuesta));
        //echo json_encode($data);
    }

?>

