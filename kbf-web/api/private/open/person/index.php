<?php
    include '../../../classes/CurrentOpen.php';
    include_once '../../../db.php';
    include_once '../../../../helpers.php';

    $config = require "../../../../kbf.config.php";
    session_start([
        'cookie_lifetime' => 86400,
        'read_and_close'  => true,
    ]);
    forceHttps($config);
    checkSessionApi($config);
    checkResponsible();


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //create open person
        $inputJSON = file_get_contents('php://input');
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/open/person/ - $inputJSON");
        $open = new CurrentOpen($_SESSION["pnr"]);
        if($open->getResponsible() != $_SESSION["pnr"]) {
            error("Wrong responsible");
        } else {
            $input = json_decode($inputJSON, TRUE); //convert JSON into array
            if(!isset($input['openId'])) {
                error("Missing openId parameter");
            } else if(isset($input['name']) || isset($input['pnr'])) {
                $mysqli = getDBConnection($config);
                $mysqli->autocommit(FALSE);
                $name = "";
                $pnr = NULL;
                if(isset($input['name'])) {
                    $name = cleanField($input['name'], $mysqli);
                    if($name === "") {
                        error("Name empty!");
                        $mysqli->close();
                        return;
                    }
                } else {
                    $pnr = getPnr($input['pnr'], $mysqli);
                }
                $open_id = cleanField($input['openId'], $mysqli);
                $sql = "";
                if($pnr) {
                    $name = $pnr;
                }
                $token = bin2hex(random_bytes(25));
                $sql="INSERT INTO `open_person` (`open_id`, `name`, `receipt`) VALUES ($open_id,'$name', '$token')";
                $result  = $mysqli->real_query($sql);
                $sql = "SELECT id FROM `open_person` WHERE `open_id` = $open_id AND name = '$name' ORDER BY id DESC LIMIT 1";
                $result_person  = $mysqli->query($sql);
                $open_person = NULL;
                while($row = $result_person->fetch_row()) {
                    $open_person = $row[0];
                }
                $item_result = insertItems($input, $open_person, $pnr, $mysqli);
                if($result && $item_result) {
                    echo "{\"id\":\"$open_person\", \"receipt\":\"$token\"}";
                    $mysqli->commit();
                } else {
                    error("Failed to insert row");
                    $mysqli->rollback();
                }
            } else {
                error("Missing name or pnr parameter");
            }
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/open/person/ - " . http_build_query($_GET));
        if(isset($_GET['openId'])) {
            //get persons for open-id
            $mysqli = getDBConnection($config);
            $open_id = cleanField($_GET['openId'], $mysqli);
            
            $sql = "SELECT op.id, op.pnr, op.name, p.name, op.receipt
	                    FROM `open_person` as op 
	                    LEFT JOIN `person` as p on p.pnr = op.pnr
	                    WHERE `open_id` = $open_id";
                        
            $result = $mysqli->query($sql);
            if($result && $result->num_rows > 0) {
                $open_person_result = "[";
                while($row = $result->fetch_row()) {
                    $open_person_result .= "{";
                    $open_person_result .= "\"id\":$row[0],";
                    $open_person_result .= "\"receipt\":\"" . getStringcolumn($row, 4) . "\",";
                    $pnr_row = "";
                    if($row[1]) {
                        $pnr_row = "$row[1]($row[3])";
                    }
                    $open_person_result .= "\"pnr\":\"$pnr_row\",";
                    $open_person_result .= "\"name\":\"" . getStringcolumn($row, 2) . "\",";
                    $open_person_result .= "\"items\":[" . getItems($row[0], $mysqli) . "]";
                    $open_person_result .= "},";
                }
                $open_person_result = endJsonList($open_person_result, 1);
                echo $open_person_result . "]";
            } else {
                echo "[]";
            }
            $mysqli->close();
        } else {
           error("Missing parameter open_id");
        }
    } else if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $inputJSON = file_get_contents('php://input');
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/open/person/ - $inputJSON");
        $open = new CurrentOpen($_SESSION["pnr"]);
        if($open->getResponsible() != $_SESSION["pnr"]) {
            error("Wrong responsible");
        } else {
            $input = json_decode($inputJSON, TRUE); //convert JSON into array
            if(!isset($input['id'])) {
                error("Missing id parameter");
            } else  {
                $mysqli = getDBConnection($config);
                $mysqli->autocommit(FALSE);
                $person_id = cleanField($input['id'], $mysqli);
                //Check if ten-card,  give back when removed
                $sql = "SELECT name FROM `open_person` WHERE `id` = $person_id";
                $open_preson_result = $mysqli->query($sql);
                while($row = $open_preson_result->fetch_row()) {
                    $plusPos = strpos($row[0], "+");
                    if($plusPos) {
                        $ten_card = substr($row[0], 0, $plusPos);
                        $sql = "SELECT `id`, `left` FROM `ten_card` WHERE `card` = $ten_card";
                        $ten_card_result = $mysqli->query($sql);
                        while($row_ten_card = $ten_card_result->fetch_row()) {
                            $id = $row_ten_card[0];
                            $left = $row_ten_card[1] + 1;
                            $update_ten_card_sql = "UPDATE `ten_card` SET `left`='$left' WHERE `id`=$id";
                            $mysqli->real_query($update_ten_card_sql);
                        }
                    }
                }

                $sql = "DELETE FROM `open_item` WHERE `open_person` = $person_id";
                $item_result  = $mysqli->real_query($sql);
                $sql = "DELETE FROM `open_person` WHERE `id` = $person_id";
                $result  = $mysqli->real_query($sql);
                handleResults($result, $item_result, $mysqli);
            }
        }
    } else {
        error("Not implemented");
    }

    function getItems($id, $mysqli) {
        $person_items = "SELECT * FROM `open_item` WHERE `open_person` = $id";
        $result = $mysqli->query($person_items);
        $person_item_result = "";
        while($row = $result->fetch_row()) {
            $person_item_result .= "{";
            $person_item_result .= "\"id\":$row[0],";
            $person_item_result .= "\"name\":\"" . getStringcolumn($row, 2) . "\",";
            $person_item_result .= "\"price\":$row[3]";
            $person_item_result .= "},";
        }

        $person_item_result = endJsonList($person_item_result, 0);

        return $person_item_result;
    }

    function insertItems($input, $open_person, $pnr, $mysqli) {
        if(isset($input['items'])) {
            $items = $input['items'];
            $items = getNameForItems($items, $mysqli);
            foreach($items as $item) {
                if(isset($item['name']) && isset($item['price'])) {
                    $name = $item['name'];
                    $sql = "SELECT price, member_price FROM prices WHERE name = '$name'";
                    $result = $mysqli->query($sql);
                    if($result) {
                        $row = $result->fetch_row();
                        $price = cleanField($item['price'], $mysqli);
                        if($row &&  ($price == $row[0] || ($price == $row[1] && $pnr)) ) {
                            $sql = "INSERT INTO `open_item` (`open_person`, `name`, `price`) VALUES ('$open_person','$name','$price')";
                            $result = $mysqli->real_query($sql);
                            if(!$result) {
                                return $result;
                            }
                         } else {
                             return false;
                         }
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }
        return true;
    }

    function respond($pnr,$name, $open_id) {
        $sql = "";
        if($pnr) {
            $sql="SELECT id FROM `open_person` WHERE `pnr`='$pnr' AND `open_id`=$open_id AND `name`=NULL";
        } else {
            $sql="SELECT id FROM `open_person` WHERE `pnr`=NULL AND `open_id`=$open_id AND `name`='$name'";
        }
        $result = $mysqli->query($sql);
        if($result &&  $result->num_rows === 1) {
            $row = $result->fetch_row();
            echo "{\"id\":\"$row[0]\"}";
        } else {
            error("Failed to get person");
        }
    }
?>

