<?php
    include '../../../db.php';
    include '../../../../helpers.php';
    include '../../../classes/Person.php';

    $config = require "../../../../kbf.config.php";
    session_start([
        'cookie_lifetime' => 86400,
        'read_and_close'  => true,
    ]);
    forceHttps($config);
    checkSessionApi($config);
    checkAdmin();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $inputJSON = file_get_contents('php://input');
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/person/permissions/ - $inputJSON");
        $input = json_decode($inputJSON, TRUE); //convert JSON into array
        if(!isset($input['pnr'])) {
            error("Missing parameter pnr");
        } else if(!isset($input['permissions'])) {
            error("Missing parameter permissions");
        } else {
            $pnr = checkPnr($input['pnr']);
            $person = new Person($pnr);
            if($person->setPermissions($input['permissions'])) {
                echo "{\"status\":\"ok\"}";
            }
        }
    } else {
        error("Not implemented");
    }
?>

