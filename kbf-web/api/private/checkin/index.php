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
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/checkin/ - $inputJSON");
        $input = json_decode($inputJSON, TRUE); //convert JSON into array
        if(!isset($input['pnr'])) {
            error("Missing parameter pnr");
        } else {
            $pnr = checkPnr($input['pnr']);
            if($pnr == $_SESSION["pnr"]) {
                $open = new CurrentOpen(NULL);
                $result = $open->add($input['pnr']);
                if($result) {
                    echo "{\"status\":\"ok\"}";
                }
            } else {
                error("pnr does not match logged in user");
            }
        }
    } else if( $_SERVER['REQUEST_METHOD'] === 'GET' ) {
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/checkin/ - " . http_build_query($_GET));
        $open = new CurrentOpen(NULL);
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