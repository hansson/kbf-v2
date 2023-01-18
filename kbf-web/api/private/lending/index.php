<?php
    include '../../db.php';
    include '../../../helpers.php';
    include '../../classes/Lending.php';
    include '../../classes/LendingContainer.php';

    $config = require "../../../kbf.config.php";
    session_start([
        'cookie_lifetime' => 86400,
        'read_and_close'  => true,
    ]);
    forceHttps($config);
    checkSessionApi($config);
    checkResponsible();

    //{"responsible":"901103","member":"901103","lended":"Skor 42"}: 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $inputJSON = file_get_contents('php://input');
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/lending/ - $inputJSON");
        $input = json_decode($inputJSON, TRUE); //convert JSON into array
        if(!isset($input['responsible'])) {
            error("Missing parameter responsible");
        } else if(!isset($input['member'])) {
            error("Missing parameter member");
        } else if(!isset($input['lended'])) {
            error("Missing parameter lended");
        } else {
            $lends = new LendingContainer();
            $lends->create($input['member'], $input['responsible'],$input['lended']);
            echo "{\"status\":\"ok\"}";
        }
    }  else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $lends = new LendingContainer();
        echo $lends->print();
    }  else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $container = new LendingContainer();
        $container->delete($_GET['id']);
        echo "{\"status\":\"ok\"}";
    } else {
        error("Not implemented");
    }
?>

