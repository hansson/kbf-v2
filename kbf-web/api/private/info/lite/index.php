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
        if(isset($_GET['pnr']) || isset($_GET['card'])) {
            $mysqli = getDBConnection($config);
            if(isset($_GET['pnr'])) {
                $pnr = cleanField($_GET['pnr'], $mysqli);
                try {
                    $pnr = handlePersonalNumber($pnr);
                } catch ( Exception $e ) {
                    error("Bad personal number");
                    $mysqli->close();
                    return;
                }
                $sql = "SELECT `left`, card FROM `ten_card` WHERE `pnr` = '$pnr' AND `left` > 0";
                $result = $mysqli->query($sql);
                $left = "-";
                $card = "-";
                if($result && $result->num_rows === 1) {
                    $row = $result->fetch_row();
                    $left = $row[0];
                    $card = $row[1];
                }
                $year = date('Y');
                $month = date('n');
                if($month > "6") {
                    $sql = "SELECT paymentDate, `type` FROM `climbing_fee` WHERE `pnr` = '$pnr' AND (paymentDate > '$year-07-01 00:00:00' OR (paymentDate > '$year-01-01 00:00:00' AND `type` = 2)) LIMIT 1";
                } else {
                    $sql = "SELECT paymentDate, `type` FROM `climbing_fee` WHERE `pnr` = '$pnr' AND paymentDate > '$year-01-01 00:00:00' LIMIT 1";
                }

                $result = $mysqli->query($sql);
                $fee_valid = "-";
                if($result && $result->num_rows === 1) {
                    $row = $result->fetch_row();
                    if( $row[1] == 2 || $month > "6") { //year or later part of year
                        $fee_valid = "$year-12-31";
                    } else { //half year, begining of year
                        $fee_valid = "$year-06-30";
                    }
                }
                $sql = "SELECT paymentDate FROM `membership` WHERE `pnr` = '$pnr' AND paymentDate > '$year-01-01 00:00:00' ORDER BY paymentDate DESC LIMIT 1";
                $result = $mysqli->query($sql);
                $member_valid = "-";
                if($result && $result->num_rows === 1) {
                    $member_valid = "$year-12-31";
                }

                $json_result = "{";
                $json_result .= "\"memberValid\":\"$member_valid\",";
                $json_result .= "\"feeValid\":\"$fee_valid\",";
                $json_result .= "\"left\":\"$left\"";
                $json_result .= "}";
                echo $json_result;
            } else if(isset($_GET['card'])) {
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

            }
            $mysqli->close();            
        } else {
           error("Missing parameter pnr or card");
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        error("Not implemented");
    }
?>

