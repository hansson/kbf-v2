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

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/search/person/ - " . http_build_query($_GET));
        if(isset($_GET['search'])) {
            $mysqli = getDBConnection($config);
            $search = cleanField($_GET["search"], $mysqli);
            if($search == $_SESSION["pnr"] || checkResponsible()) {
                $wildcard = "%";
                if(isset($_GET['exact'])) {
                    $wildcard = "";
                }
                $sql = "SELECT pnr FROM person WHERE pnr LIKE '$search$wildcard'";
                $result = $mysqli->query($sql);
                $json_result = "[";
                while($row = $result->fetch_row()) {
                    $person = new Person($row[0]);
                    $json_result .= $person->print() . ",";
                }
                $sql = "SELECT pnr FROM person WHERE `name` LIKE '$search$wildcard'";
                $result = $mysqli->query($sql);
                while($row = $result->fetch_row()) {
                    $person = new Person($row[0]);
                    $json_result .= $person->print() . ",";
                }
                $json_result = endJsonList($json_result, 1);
                echo $json_result . "]";
            }          
            $mysqli->close();
        } else {
           error("Missing parameter search");
        }
    } else {
        error("Not implemented");
    }
?>

