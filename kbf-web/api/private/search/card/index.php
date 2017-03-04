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

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/search/card/ - " . http_build_query($_GET));
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
    } else {
        error("Not implemented");
    }
?>

