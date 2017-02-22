<?php
    include '../../../classes/CurrentOpen.php';
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
        //add pre paid
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, TRUE); //convert JSON into array
        if(isset($input['identification'])) {
            try {
                $identification = handlePersonalNumber($input['identification']);
            } catch ( Exception $e ) {
                $identification = $input['identification'];
            }
            if($identification == $_SESSION['pnr'] || isResponsible()) {
                $open = new CurrentOpen();
                $result = $open->add($input['identification']);
                if($result) {
                    echo "{\"id\":\"$result\"}";
                }
            } else {
                error("Logged in user does not match identification or not responsible");
            }

        } else {
            error("Missing identification parameter");
        }
    } else {
        error("Not implemented");
    }

?>

