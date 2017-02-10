<?php
    include '../../../db.php';
    include '../../../../helpers.php';

    $config = require "../../../../kbf.config.php";
    session_start();
    forceHttps($config);
    checkSessionApi($config);
    checkResponsible();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        error("Not implemented");
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if(isset($_GET['card'])) {
            $mysqli = getDBConnection($config);
            $card = cleanField($_GET['card'], $mysqli);
            $sql = "SELECT `left` FROM `ten_card` WHERE `card` = '$card'";
            $result = $mysqli->query($sql);    
            if($result && $result->num_rows === 1) {
                $row = $result->fetch_row();
                $json_result = "{";
                $json_result .= "\"left\":\"$row[0]\"";
                $json_result .= "}";
                echo $json_result;
            } else {
                error("Failed to find card");
            }
            $mysqli->close();            
        } else {
           error("Missing parameter card");
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        error("Not implemented");
    }
?>

