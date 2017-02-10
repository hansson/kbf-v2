<?php
    include '../../../db.php';
    include '../../../../helpers.php';

    $config = require "../../../../kbf.config.php";
    session_start();
    forceHttps($config);
    checkSessionApi($config);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        error("Not implemented");
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if(isset($_GET['pnr'])) {
            try {
                $pnr = handlePersonalNumber($_GET['pnr']);
            } catch ( Exception $e ) {
                error("Bad personal number");
                return;
            }
            if($pnr == $_SESSION["pnr"] || checkResponsible()) {
                $mysqli = getDBConnection($config);
                $sql = "SELECT pnr, name, email FROM person WHERE pnr LIKE '$pnr%'";
                $result = $mysqli->query($sql);
                $json_result = "[";
                while($row = $result->fetch_row()) {
                    $json_result .= "{";
                    $json_result .= "\"pnr\":\"$row[0]\",";
                    $json_result .= "\"name\":\"$row[1]\",";
                    $json_result .= "\"email\":\"$row[2]\"";
                    $json_result .= "},";
                }
                $json_result = endJsonList($json_result, 1);
                echo $json_result . "]";
                $mysqli->close();
            }          
        } else {
           error("Missing parameter pnr");
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        error("Not implemented");
    }
?>

