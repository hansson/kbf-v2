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
        if(isset($_GET['pnr'])) {
            $pnr = checkPnr($_GET['pnr']);
            if($pnr == $_SESSION["pnr"] || checkResponsible()) {
                $mysqli = getDBConnection($config);
                $wildcard = "%";
                if(isset($_GET['exact'])) {
                    $wildcard = "";
                }
                $sql = "SELECT pnr FROM person WHERE pnr LIKE '$pnr$wildcard'";
                $result = $mysqli->query($sql);
                $json_result = "[";
                while($row = $result->fetch_row()) {
                    $person = new Person($pnr);
                    $json_result .= $person->print() . ",";
                }
                $json_result = endJsonList($json_result, 1);
                echo $json_result . "]";
                $mysqli->close();
            }          
        } else {
           error("Missing parameter pnr");
        }
    } else {
        error("Not implemented");
    }
?>

