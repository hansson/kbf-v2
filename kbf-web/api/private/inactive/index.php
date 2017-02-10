<?php
    include '../../db.php';
    include '../../../helpers.php';

    $config = require "../../../kbf.config.php";
    session_start();
    forceHttps($config);
    checkSessionApi($config);
    checkResponsible();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        error("Not implemented");
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
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
        $input = json_decode($inputJSON, TRUE); //convert JSON into array
        if(!isset($input['pnr'])) {
            error("Missing parameter pnr");
        } else  if(!isset($input['active'])) {
            error("Missing parameter active");
        } else {
            $mysqli = getDBConnection($config);
            $pnr = cleanField($input['pnr'], $mysqli);
            try {
                $pnr = handlePersonalNumber($pnr);
            } catch ( Exception $e ) {
                error("Bad personal number");
                $mysqli->close();
                return;
            }
            $active = cleanField($input['active'], $mysqli);
            $sql="UPDATE `person` SET `active`=$active WHERE `pnr` = '$pnr'";
            handleResult($mysqli->real_query($sql));
            $mysqli->close();            
        }
    }
?>

