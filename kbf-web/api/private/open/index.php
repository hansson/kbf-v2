<?php
    include '../../classes/CurrentOpen.php';
    include_once '../../../helpers.php';
    
    $config = require "../../../kbf.config.php";
    session_start([
        'cookie_lifetime' => 86400,
        'read_and_close'  => true,
    ]);
    forceHttps($config);
    checkSessionApi($config);
    checkResponsible();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $inputJSON = file_get_contents('php://input');
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/open/ - $inputJSON");
        $input = json_decode($inputJSON, TRUE); //convert JSON into array
        if(isset($input['responsible'])) {
            //create open
            $mysqli = getDBConnection($config);
            $responsible = getPnr($input['responsible'], $mysqli);
            if(isset($_SESSION["pnr"]) && $responsible === $_SESSION["pnr"]) {
                $sql="INSERT INTO `open` (`responsible`) VALUES ('$responsible')";
                handleResult($mysqli->real_query($sql));
            } else {
                error("Session does not match responsible");
            }
        } else {
            error("Missing parameter responsible");
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/open/ - " . http_build_query($_GET));
        //current open
        $open = new CurrentOpen();
        if(!$open->getOpenId())  {
            error("No open");
        } else if($open->getResponsible() != $_SESSION["pnr"]) {
            error("Wrong responsible, " . $open->getResponsible());
        } else {
            $open->print();
        }
    } else  {
        error("Not implemented");
    }

   
?> 