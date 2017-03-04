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
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/search/person/ - " . http_build_query($_GET));
        if(isset($_GET['pnr'])) {
            try {
                $pnr = handlePersonalNumber($_GET['pnr']);
            } catch ( Exception $e ) {
                error("Bad personal number");
                return;
            }
            if($pnr == $_SESSION["pnr"] || checkResponsible()) {
                $mysqli = getDBConnection($config);
                $wildcard = "%";
                if(isset($_GET['exact'])) {
                    $wildcard = "";
                }
                $sql = "SELECT pnr, name, email FROM person WHERE pnr LIKE '$pnr$wildcard'";
                $result = $mysqli->query($sql);
                $json_result = "[";
                while($row = $result->fetch_row()) {
                    $pnr = getStringcolumn($row, 0);
                    $name = getStringcolumn($row, 1);
                    $email = getStringcolumn($row, 2);
                    $json_result .= "{";
                    $json_result .= "\"pnr\":\"$pnr\",";
                    $json_result .= "\"name\":\"$name\",";
                    $json_result .= "\"email\":\"$email\"";
                    $json_result .= "},";
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

