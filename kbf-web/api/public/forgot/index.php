<?php
    require '../../classes/PHPMailer/src/PHPMailer.php';
    require '../../classes/PHPMailer/src/SMTP.php';
    require '../../../classes/PHPMailer/src/Exception.php';
    include '../../db.php';
    include '../../../helpers.php';
    
    $config = require "../../../kbf.config.php";
    forceHttps($config);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, TRUE); //convert JSON into array
        if(!isset($input['email'])) {
            error("Missing email");
        } else {
            $mysqli = getDBConnection($config);
            $email = cleanField($input['email'], $mysqli);
            $sql = "SELECT pnr FROM `person` WHERE `email`='$email'";
            $result  = $mysqli->query($sql);
            if($result && $result->num_rows === 1) {
                $token = bin2hex(random_bytes(25));
                $sql = "UPDATE `person` SET `forgotToken`='$token'  WHERE `email`='$email'";
                $result  = $mysqli->real_query($sql);
                if(!$result) {
                    error("Failed to set token");
                    $mysqli->close();
                    exit();
                }
                mailto($email, $token, $config);
            }
            echo "{\"status\":\"ok\"}"; //Always return ok, to make bruteforce harder.
            $mysqli->close();
        }
    } else if($_SERVER['REQUEST_METHOD'] === 'GET') {
        if(!isset($_GET['email'])) {
            error("Missing email");
        } else if(!isset($_GET['token'])) {
            error("Missing token");
        } else if(!isset($_GET['password'])) {
            error("Missing password");
        } else {
            $mysqli = getDBConnection($config);
            $email = cleanField($_GET['email'], $mysqli);
            $token = cleanField($_GET['token'], $mysqli);
            $password = cleanField($_GET['password'], $mysqli);
            $sql = "SELECT pnr FROM `person` WHERE `email`='$email' AND forgotToken='$token'";
            $result  = $mysqli->query($sql);
            if($result && $result->num_rows === 1) {
                $options = array('cost' => 10);
                $password = password_hash($password, PASSWORD_DEFAULT, $options);
                $sql = "UPDATE `person` SET `password`='$password', `forgotToken`=NULL  WHERE `email`='$email'";
                $result  = $mysqli->real_query($sql);
                handleResult($result, $mysqli);
            } else {
                error("Bad email or token");
            }
            $mysqli->close();
        }
    } else {
        error("Not implemented");
    }


    function mailto($email, $token, $config) {
        $mail = new PHPMailer\PHPMailer\PHPMailer;

        //$mail->SMTPDebug = 3;
        $mail->isSMTP();      
        $mail->Host = $config['smtp_server'];  
        $mail->SMTPAuth = true;                 
        $mail->Username = $config['smtp_email'];
        $mail->Password = $config['smtp_password'];
        $mail->SMTPSecure = 'ssl';                 
        $mail->Port = 465;                         

        $mail->setFrom('noreply@karlskronabergsport.se', 'Karlskrona Bergsportsförening');
        $mail->addAddress($email);
        $mail->isHTML(true);    
        $mail->CharSet = 'UTF-8';

        $mail->Subject = "Bortglömt lösenord";
        $mail->Body    = "Någon har försökt återställa ditt lösenord på karlskronabergsport.se, om det inte var du så kan du ignorera detta mail. <br />
            För att återställa ditt lösenord använd denna länk: http://karlskronabergsport.se/admin/reset.php?email=$email&token=$token";
        $mail->AltBody = "Någon har försökt återställa ditt lösenord på karlskronabergsport.se, om det inte var du så kan du ignorera detta mail.
            För att återställa ditt lösenord använd denna länk: http://karlskronabergsport.se/admin/reset.php?email=$email&token=$token";

        $mail->send();
        // if(!$mail->send()) {
        //     echo 'Message could not be sent.';
        //     echo 'Mailer Error: ' . $mail->ErrorInfo;
        // } else {
        //     echo 'Message has been sent';
        // }
    }
    
?>