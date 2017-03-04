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
    checkAdmin();

    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $inputJSON = file_get_contents('php://input');
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/inactive/register/ - $inputJSON");
        $input = json_decode($inputJSON, TRUE); //convert JSON into array
        if(!isset($input['tmp_pnr'])) {
            error("Missing tmpPnr parameter");
        } else {
            $mysqli = getDBConnection($config);
            $tmp_pnr = cleanField($input['tmp_pnr'], $mysqli);
            $sql="UPDATE `membership` SET `registered`=1, `tmpPnr` = NULL WHERE `tmpPnr` = '$tmp_pnr'";
            handleResult($mysqli->real_query($sql));
            $mysqli->close();
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/inactive/register/ - " . http_build_query($_GET));
        $mysqli = getDBConnection($config);
        $sql = "SELECT tmpPnr FROM `membership` WHERE `registered` = 0";
        $result = $mysqli->query($sql);
        if($result && $result->num_rows > 0) {
            $tmp_pnr_result = "[";
            while($row = $result->fetch_row()) {
                $tmp_pnr_result .= "{";
                $tmp_pnr_result .= "\"tmp_pnr\":\"$row[0]\"";
                $tmp_pnr_result .= "},";
            }
            $tmp_pnr_result = endJsonList($tmp_pnr_result, 1);
            echo $tmp_pnr_result . "]";
        } else {
            echo "[]";
        }
        $mysqli->close();
    } else {
        error("Not implemented");
    }

   
?>

