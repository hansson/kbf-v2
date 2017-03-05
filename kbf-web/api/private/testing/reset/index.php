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

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if($config["environment"] === "prod") {
            error("Reset not possible on production system");
        }
        $mysqli = getDBConnection($config);
        $sql = "DELETE FROM `ten_card`";
        $result = $mysqli->real_query($sql);

        $sql = "DELETE FROM `item`";
        $result = $mysqli->real_query($sql);    

        $sql = "DELETE FROM `membership`";
        $result = $mysqli->real_query($sql);

        $sql = "INSERT INTO `membership` (pnr, `type`, signed, registered) VALUES ('901103', 2, '901103', 1)";
        $result = $mysqli->real_query($sql);

        $sql = "DELETE FROM `climbing_fee`";
        $result = $mysqli->real_query($sql);

        $sql = "DELETE FROM `open_item`";
        $result = $mysqli->real_query($sql);

        $sql = "DELETE FROM `open_person`";
        $result = $mysqli->real_query($sql);

        $sql = "DELETE FROM `open`";
        $result = $mysqli->real_query($sql);

        $sql = "DELETE FROM `person` WHERE pnr != '901103'";
        $result = $mysqli->real_query($sql);
        
        $mysqli->close();            
        echo "{\"status\":\"ok\"}";
    } else {
        error("Not implemented");
    }
?>

