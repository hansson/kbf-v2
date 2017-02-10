<?php
    include '../../../db.php';
    include '../../../../helpers.php';

    $config = require "../../../../kbf.config.php";
    session_start();
    forceHttps($config);
    checkSessionApi($config);
    checkResponsible();

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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //create open person
        $inputJSON = file_get_contents('php://input');
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
                $pnr = cleanField($input['pnr'], $mysqli);
                try {
                    $pnr = handlePersonalNumber($pnr);
                } catch ( Exception $e ) {
                    error("Bad personal number");
                    $mysqli->close();
                    return;
                }
            }
            $open_id = cleanField($input['openId'], $mysqli);
            $sql = "";
            if($pnr) {
                $sql="INSERT INTO `open_person` (`open_id`, `pnr`, `name`) VALUES ($open_id,'$pnr','$name')";
            } else {
                $sql="INSERT INTO `open_person` (`open_id`, `pnr`, `name`) VALUES ($open_id,NULL,'$name')";
            }
            $result  = $mysqli->real_query($sql);
            if($pnr) {
                $sql = "SELECT * FROM `open_person` WHERE `open_id` = $open_id AND name = '$name' AND pnr = '$pnr'";
            } else {
                $sql = "SELECT * FROM `open_person` WHERE `open_id` = $open_id AND name = '$name' AND pnr IS NULL";
            }
            $result_person  = $mysqli->query($sql);
            $open_person = NULL;
            while($row = $result_person->fetch_row()) {
                $open_person = $row[0];
            }
            $item_result = insertItems($input, $open_person, $mysqli);
            handleResults($result, $item_result, $mysqli);
        } else {
            error("Missing name or pnr parameter");
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if(isset($_GET['openId'])) {
            //get persons for open-id
            $mysqli = getDBConnection($config);
            $open_id = cleanField($_GET['openId'], $mysqli);
            
            $sql = "SELECT * FROM `open_person` WHERE `open_id` = $open_id";
            $result = $mysqli->query($sql);
            if($result && $result->num_rows > 0) {
                $open_person_result = "[";
                while($row = $result->fetch_row()) {
                    $open_person_result .= "{";
                    $open_person_result .= "\"id\":$row[0],";
                    $open_person_result .= "\"pnr\":\"$row[2]\",";
                    $open_person_result .= "\"name\":\"" . getStringcolumn($row, 3) . "\",";
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
    } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
     // update
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, TRUE); //convert JSON into array
        if(!isset($input['id'])) {
            error("Missing id parameter");
        } else if(isset($input['name']) || isset($input['pnr'])) {
            $mysqli = getDBConnection($config);
            $name = "";
            $pnr = NULL;
            if(isset($input['name'])) {
                $name = cleanField($input['name'], $mysqli);
            } else {
                $pnr = cleanField($input['pnr'], $mysqli);
                try {
                    $pnr = handlePersonalNumber($pnr);
                } catch ( Exception $e ) {
                    error("Bad personal number");
                    $mysqli->close();
                    return;
                }
            }
            $person_id = cleanField($input['id'], $mysqli);
            $sql = "";
            if($pnr) {
                $sql="UPDATE `open_person` SET `pnr`='$pnr', `name`='$name' WHERE `id` = $person_id";
            }  else {
                $sql="UPDATE `open_person` SET `pnr`=NULL, `name`='$name' WHERE `id` = $person_id";
            }
            handleResult($mysqli->real_query($sql));
        } else {
            error("Missing name or pnr parameter");
        }
    }  else if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, TRUE); //convert JSON into array
        if(!isset($input['id'])) {
            error("Missing id parameter");
        } else  {
            $mysqli = getDBConnection($config);
            $mysqli->autocommit(FALSE);
            $person_id = cleanField($input['id'], $mysqli);
            $sql = "DELETE FROM `open_item` WHERE `open_person` = $person_id";
            $item_result  = $mysqli->real_query($sql);
            $sql = "DELETE FROM `open_person` WHERE `id` = $person_id";
            $result  = $mysqli->real_query($sql);
            handleResults($result, $item_result, $mysqli);
        }
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

    function insertItems($input, $open_person, $mysqli) {
        if(isset($input['items'])) {
            $items = $input['items'];
            foreach($items as $item) {
                if(isset($item['name']) && isset($item['price'])) {
                    $name = cleanField($item['name'], $mysqli);
                    $price = cleanField($item['price'], $mysqli);
                    $sql = "INSERT INTO `open_item` (`open_person`, `name`, `price`) VALUES ('$open_person','$name','$price')";
                    $result = $mysqli->real_query($sql);
                    if(!$result) {
                        return $result;
                    }
                } else {
                    return false;
                }
            }
        }
        return true;
    }
?>

