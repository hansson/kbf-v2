<?php
    include '../../../db.php';
    include '../../../../helpers.php';

    $config = require "../../../../kbf.config.php";
    session_start();
    forceHttps($config);
    checkSessionApi($config);
    checkResponsible();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //TODO Check logged in PNR=RESPONSIBLE
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, TRUE); //convert JSON into array
        if(!isset($input['responsible'])) {
            error("No responsible set");
        } else if(!isset($input['openId'])) {
            error("No openId set");
        } else {
            $mysqli = getDBConnection($config);
            $responsible = cleanField($input['responsible'], $mysqli);
            try {
                $responsible = handlePersonalNumber($responsible);
            } catch ( Exception $e ) {
                error("Bad personal number");
                $mysqli->close();
                return;
            }
            if(isset($_SESSION["pnr"]) && $responsible === $_SESSION["pnr"]) {
                $open_id = cleanField($input['openId'], $mysqli);
                $sql = "UPDATE `open` SET `signed`='$responsible' WHERE `id`=$open_id";
                handleResult($mysqli->real_query($sql));
            } else {
                error("Session does not match responsible");
            }
            $mysqli->close();
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        error("Not implemented");
    } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        error("Not implemented");
    }

   
?> 