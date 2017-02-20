<?php
    include '../../../db.php';
    include '../../../../helpers.php';

    $config = require "../../../../kbf.config.php";
    session_start([
        'cookie_lifetime' => 86400,
        'read_and_close'  => true,
    ]);
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
            $responsible = getPnr($input['responsible'], $mysqli);
            if(isset($_SESSION["pnr"]) && $responsible === $_SESSION["pnr"]) {
                $open_id = cleanField($input['openId'], $mysqli);
                $sql = "UPDATE `open` SET `signed`='$responsible' WHERE `id`=$open_id";
                handleResult($mysqli->real_query($sql));
            } else {
                error("Session does not match responsible");
            }
            $mysqli->close();
        }
    } else {
        error("Not implemented");
    }

   
?> 