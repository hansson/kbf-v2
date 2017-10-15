<?php
    include_once '../../db.php';
    include_once '../../../helpers.php';
    include_once (__DIR__ . '/../../classes/ClimbInfo.php');
    
    $config = require "../../../kbf.config.php";
    session_start([
        'cookie_lifetime' => 86400,
        'read_and_close'  => true,
    ]);
    forceHttps($config);
    checkSessionApi($config);
    checkResponsible();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $inputJSON = file_get_contents('php://input');
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/fee/ - $inputJSON");
        $input = json_decode($inputJSON, TRUE); //convert JSON into array
        if(!isset($input['signed'])) {
            error("Missing parameter signed");
        } else if (!isset($input['items'])){
            error("Missing parameter items");
        } else {
            $signed = $input["signed"];
            if($signed == $_SESSION["pnr"]) {
                if(isset($input["pnr"])) {
                    handleForPnr($config, $input);
                } else {
                    handleNoPnr($config,  $input);
                }
            } else {
                error("Signed does not match logged in user");
            }
        }
    }  else {
        error("Not implemented");
    }

    function addFee($item, $pnr, $member, $tmp_pnr, $mysqli) {
        $name = cleanField($item["name"], $mysqli);
        $price = cleanField($item["price"], $mysqli);
        $signed = $_SESSION["pnr"];
        $sql = "SELECT price, member_price, type, `table` FROM prices WHERE name = '$name' AND is_fee = 1";
        $result = $mysqli->query($sql);
        if($result && $result->num_rows === 1) {
            $row = $result->fetch_row();
            if($price == $row[0] || ($price == $row[1] && $member)) {
                $type = $row[2];
                $table = $row[3];
                $sql = "INSERT INTO `$table` (pnr, `type`, signed) VALUES ('$pnr', $type ,'$signed')"; //Default sql
                if($table == "ten_card") {
                    $card = rand (1000000, 9999999);
                    $sql = "INSERT INTO `$table` (pnr, card, signed) VALUES ('$pnr', '$card', '$signed')";
                } else if($table == "membership") {
                    $climbInfo = new ClimbInfo($pnr);
                    if($climbInfo->getMemberValid() != "-") {
                        error("Duplicate fee");
                        return false;
                    }
                    if(!$tmp_pnr) {
                        error("Missing parameter tmp_pnr");
                        return false;
                    }
                    $sql = "INSERT INTO `$table` (pnr, `type`, signed, tmpPnr) VALUES ('$pnr', '$type', '$signed', '$tmp_pnr')";
                } else if($table == "climbing_fee") {
                    $climbInfo = new ClimbInfo($pnr);
                    if($climbInfo->getFeeValid() != "-") {
                        error("Duplicate fee");
                        return false;
                    }
                }
                //Create into correct table
                $result = $mysqli->real_query($sql);
                if($result) {
                    $sql = "INSERT INTO item  (name, price, signed, pnr) VALUES ('$name', '$price', '$signed', '$pnr')";
                    //Create item
                    $result = $mysqli->real_query($sql);
                    if($result) {
                        return true;
                    }
                } 
                error("Failed create fee $name");
                return false;
            }
            else {
                error("Not a member");
                return false;
            }
        } else {
            error("Could not find fee $name");
            return false;
        }

    }

    function checkMember($pnr, $mysqli) {
        $year = date('Y');
        $sql = "SELECT paymentDate FROM `membership` WHERE `pnr` = '$pnr' AND paymentDate > '$year-01-01 00:00:00' ORDER BY paymentDate DESC LIMIT 1";
        $result = $mysqli->query($sql);
        $member_valid = NULL;
        if($result && $result->num_rows === 1) {
            $member_valid = "$year-12-31";
        }
        return $member_valid;
    }

    function handleNoPnr($config, $input) {
        //Special case for anonymous ten-card.
        $items = $input["items"];
        if(sizeof($items) == 1) {
            $mysqli = getDBConnection($config);
            $mysqli->autocommit(FALSE);
            $items = getNameForItems($items, $mysqli);
            $name = $items[0]["name"];
            $price = cleanField($items[0]["price"], $mysqli);
            $signed = $_SESSION["pnr"];
            $sql = "SELECT price, `table` FROM prices WHERE name = '$name'";
            $result = $mysqli->query($sql);
            if($result) {
                $row = $result->fetch_row();
                if($row && $row[1] == "ten_card" && $price == $row[0]) {
                    $card = rand (1000000, 9999999);
                    $sql = "INSERT INTO ten_card  (card, signed) VALUES ('$card', '$signed')";
                    $result = $mysqli->real_query($sql);
                    if($result) {
                        $sql = "INSERT INTO item  (name, price, signed) VALUES ('$name($card)', '$price', '$signed')";
                        $result = $mysqli->real_query($sql);
                        if($result) {
                            echo "{\"reference\":\"$card\"}";
                            $mysqli->commit();
                            $mysqli->close();
                            return;
                        }
                    }
                } 
            }
            $mysqli->rollback();
            $mysqli->close();
        }
        error("Failed to add anonymous card");
    }

    function handleForPnr($config, $input) {
        $mysqli = getDBConnection($config);
        $mysqli->autocommit(FALSE);
        $items = getNameForItems($input["items"], $mysqli);
        $pnr = getPnr($input['pnr'], $mysqli);
        $tmp_pnr = NULL;
        if(isset($input["tmp"])) {
            $tmp_pnr = cleanField($input["tmp"], $mysqli);
        }
        $member = checkMember($pnr, $mysqli);
        if(!$member) {
            $sql = "SELECT name FROM prices WHERE `table` = 'membership'";
            $result = $mysqli->query($sql);
            $memberships = [];
            while($row = $result->fetch_row()) {
                $memberships[] = $row[0];
            }
            for ($i = 0; $i < sizeof($items); $i++) {
                $item = $items[$i];
                for($j = 0 ; $j < sizeof($memberships) ; $j++) {
                    if($item["name"] == $memberships[$j]) {
                        $member = true;
                    }
                }
            }
        }
        $allOk = true;
        for ($i = 0; $i < sizeof($items); $i++) {
            $allOk = addFee($items[$i], $pnr, $member, $tmp_pnr, $mysqli);
            if($allOk == false) {
                 break;
            }
            
        }
        if($allOk == true) {
            $mysqli->commit();
            echo "{\"reference\":\"$pnr\"}";
        } else {
            $mysqli->rollback();
        }
        $mysqli->close();
    }   
?> 