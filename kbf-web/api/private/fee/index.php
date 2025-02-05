<?php
    include_once '../../db.php';
    include_once '../../../helpers.php';
    include_once (__DIR__ . '/../../classes/ClimbInfo.php');
    include_once (__DIR__ . '/../../classes/TagInfo.php');
    
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

    function addFee($item, $pnr, $member, $tmp_pnr, $customer_name, $mysqli) {
        $name = cleanField($item["name"], $mysqli);
        $price = cleanField($item["price"], $mysqli);
        $customer_name = cleanField($customer_name, $mysqli);
        $signed = $_SESSION["pnr"];
        $sql = "SELECT price, member_price, type, `table` FROM prices WHERE name = '$name' AND is_fee = 1";
        $result = $mysqli->query($sql);
        if($result && $result->num_rows === 1) {
            $row = $result->fetch_row();
            if($price == $row[0] || ($price == $row[1] && $member)) {
                $type = $row[2];
                $table = $row[3];
                $sql = "";
                $token = bin2hex(random_bytes(25));
                $card = "";
                if($table == "ten_card") {
                    $card = rand (1000000, 9999999);
                    $sql = "INSERT INTO ten_card (pnr, card, signed, receipt, customer_name) VALUES ('$pnr', '$card', '$signed', '$token', '$customer_name')";
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
                    $sql = "INSERT INTO `$table` (pnr, `type`, signed, tmpPnr, receipt) VALUES ('$pnr', '$type', '$signed', '$tmp_pnr', '$token')";
                } else if($table == "climbing_fee") {
                    $climbInfo = new ClimbInfo($pnr);
                    if($climbInfo->getFeeValid() != "-") {
                        error("Duplicate fee");
                        return false;
                    }
                    $sql = "INSERT INTO `$table` (pnr, `type`, signed, receipt) VALUES ('$pnr', $type ,'$signed', '$token')";
                } else if($table == "tag") {
                    $tagInfo = new TagInfo($pnr);
                    if($tagInfo->getTagValid() != "-") {
                        error("Duplicate tag");
                        return false;
                    }
                    $sql = "INSERT INTO `$table` (pnr, `type`, signed, receipt) VALUES ('$pnr', $type ,'$signed', '$token')";
                }
                //Create into correct table
                $result = $mysqli->real_query($sql);
                if($result) {
                    if($table == "ten_card") {
                        $sql = "INSERT INTO item  (name, price, signed, pnr) VALUES ( '$name($card)', '$price', '$signed', '$pnr')";
                    } else {
                        $sql = "INSERT INTO item  (name, price, signed, pnr) VALUES ('$name', '$price', '$signed', '$pnr')";
                    }
                   
                    //Create item
                    $result = $mysqli->real_query($sql);
                    if($result) {
                        return true;
                    }
                }

                if(strpos($mysqli->error, "member_person_fk")) {
                    error("Could not find user with id: $pnr");
                } else {
                    error("Failed to create fee $name. " . $mysqli->error);
                }
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
                    $token = bin2hex(random_bytes(25));
                    $customerName = $input["name"];
                    $sql = "INSERT INTO ten_card  (card, signed, receipt, customer_name) VALUES ('$card', '$signed', '$token', '$customerName')";
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
                } else if($row[1] != "ten_card") {
                    error("Not ten card. Missing member id");
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
            if(strlen($tmp_pnr) < 10) {
                error("Bad tmp_pnr");
                $mysqli->close();
                return;
            }
        }
        //Person needs to be member to buy climbing fee
        $member = checkMember($pnr, $mysqli);
        if(!$member) {
            //If person is not already a member, make sure membership  is in the items
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
            $allOk = addFee($items[$i], $pnr, $member, $tmp_pnr, $input["name"], $mysqli);
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