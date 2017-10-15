<?php
    require '../../../classes/PHPMailer/PHPMailerAutoload.php';
    require '../../../classes/Receipt.php';
    include_once '../../../../helpers.php';

    $config = require "../../../../kbf.config.php";
    session_start([
        'cookie_lifetime' => 86400,
        'read_and_close'  => true,
    ]);
    forceHttps($config);
    checkSessionApi($config);
    checkResponsible();


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $inputJSON = file_get_contents('php://input');
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/open/receipt/ - $inputJSON");

        $input = json_decode($inputJSON, TRUE); //convert JSON into array
        if(!isset($input['id'])) {
            error("Missing id parameter");
        } else if(!isset($input['email'])) {
            error("Missing email parameter");
        } else if(!isset($input['type'])) {
            error("Missing type parameter");
        } else if(!isset($input['receipt'])) {
            error("Missing receipt parameter");
        } else {
            $receipt = new Receipt($input['receipt'], $input['id'], $input['type'],  $input['email']);
            mailto($receipt, $config);
        }
    } else {
        error("Not implemented");
    }

    function mailto($receipt, $config) {
        if($config['environment'] === "dev") {
            echo $receipt->print();
        } else {
            $url = $receipt->getUrl();
            
            $mail = new PHPMailer;
    
            $mail->isSMTP();      
            $mail->Host = $config['smtp_server'];  
            $mail->SMTPAuth = true;                 
            $mail->Username = $config['smtp_email'];
            $mail->Password = $config['smtp_password'];
            $mail->SMTPSecure = 'ssl';                 
            $mail->Port = 465;                         
    
            $mail->setFrom('noreply@karlskronabergsport.se', 'Karlskrona Bergsportsförening');
            $mail->addAddress($receipt->getEmail());
            $mail->isHTML(true);    
            $mail->CharSet = 'UTF-8';
    
            $mail->Subject = "Kvitto Karlskrona Bergsportsförening";
            $mail->Body    = $receipt->print();
            $mail->AltBody = "Du har fått ett kvitto från Karlskrona Bergsportsförening. Besök $url för att se det.";
    
            $mail->send();
            echo "{\"status\":\"ok\"}";
        }
    }
?>

