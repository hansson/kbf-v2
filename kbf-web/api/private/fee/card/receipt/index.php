<?php
    require '../../../../classes/PHPMailer/src/PHPMailer.php';
    require '../../../../classes/PHPMailer/src/SMTP.php';
    require '../../../../classes/PHPMailer/src/Exception.php';
    require '../../../../classes/Receipt.php';
    include_once '../../../../../helpers.php';
    include_once '../../../../db.php';
    
    $config = require "../../../../../kbf.config.php";
    session_start([
        'cookie_lifetime' => 86400,
        'read_and_close'  => true,
    ]);
    forceHttps($config);
    checkSessionApi($config);
    checkResponsible();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $inputJSON = file_get_contents('php://input');
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/fee/card/receipt/ - $inputJSON");
        $input = json_decode($inputJSON, TRUE); //convert JSON into array
        if(!isset($input['card'])) {
            error("Missing parameter card");
        } else if (!isset($input['email'])){
            error("Missing parameter email");
        } else if (!isset($input['receipt'])){
            error("Missing parameter receipt");
        } else {
            $receipt = new Receipt($input['receipt'], $input['card'], "fee",  $input['email']);
            mailto($receipt, $config);
        }
    }  else if( $_SERVER['REQUEST_METHOD'] === 'GET' ) {
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/checkin/ - " . http_build_query($_GET));
        if(!isset($_GET['card'])) {
            error("card");
        } else {
            $mysqli = getDBConnection($config);
            $card = cleanField($_GET['card'], $mysqli);
            $sql = "SELECT receipt FROM `ten_card` WHERE `card` = '$card'";
            $result = $mysqli->query($sql);
            $json_result = "["; //Should really only be once, but who doesn't like an array? 
            while($row = $result->fetch_row()) {
                $json_result .= "{";
                $json_result .= "\"receipt\":\"$row[0]\"";
                $json_result .= "},";
            }
            $json_result = endJsonList($json_result, 1);
            echo $json_result . "]";
            $mysqli->close();            
        }
    } else {
        error("Not implemented");
    }

    function mailto($receipt, $config) {
        if($config['environment'] === "dev") {
            echo $receipt->print();
        } else {
            $url = $receipt->getUrl();
            
            $mail = new PHPMailer\PHPMailer\PHPMailer;
    
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