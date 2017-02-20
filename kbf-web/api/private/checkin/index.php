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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, TRUE); //convert JSON into array
        if(!isset($input['pnr'])) {
            error("Missing parameter pnr");
        } else {
            $pnr = checkPnr($input['pnr']);
            if($pnr == $_SESSION["pnr"]) {
                $open = new CurrentOpen();
                $result = $open->add($input['identification']);
                if($result) {
                    echo "{\"status\":\"ok\"}";
                }
            } else {
                error("pnr does not match logged in user");
            }
        }
    } else if( $_SERVER['REQUEST_METHOD'] === 'GET' ) {
        $open = new CurrentOpen();
        if($open->getOpenId()) {
            $open_id = $open->getOpenId();
            echo "{";
            echo "\"id\":$open_id";
            echo "}";
        } else {
            error("No open");
        }
    } else {
     error("Not implemented");
    }
   
?> 