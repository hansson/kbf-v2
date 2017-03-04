<?php
    include '../../db.php';
    include '../../../helpers.php';

    $config = require "../../../kbf.config.php";
    session_start([
        'cookie_lifetime' => 86400,
        'read_and_close'  => true,
    ]);
    forceHttps($config);
    checkSessionApi($config);
    checkAdmin();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/inactive/ - " . http_build_query($_GET));
        $mysqli = getDBConnection($config);
        $sql = "SELECT pnr, name FROM `person` WHERE `active` = 0";
        $result = $mysqli->query($sql);
        $json_result = "[";
        while($row = $result->fetch_row()) {
            $json_result .= "{";
            $json_result .= "\"pnr\":\"$row[0]\",";
            $json_result .= "\"name\":\"$row[1]\"";
            $json_result .= "},";
        }
        $json_result = endJsonList($json_result, 1);
        echo $json_result . "]";
        $mysqli->close();            
    } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $inputJSON = file_get_contents('php://input');
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/inactive/ - $inputJSON");
        $input = json_decode($inputJSON, TRUE); //convert JSON into array
        if(!isset($input['pnr'])) {
            error("Missing parameter pnr");
        } else  if(!isset($input['active'])) {
            error("Missing parameter active");
        } else {
            $mysqli = getDBConnection($config);
            $pnr = getPnr($input['pnr'], $mysqli);
            $active = cleanField($input['active'], $mysqli);
            $sql="UPDATE `person` SET `active`=$active WHERE `pnr` = '$pnr'";
            handleResult($mysqli->real_query($sql));
            $mysqli->close();            
        }
    } else {
        error("Not implemented");
    }
?>

