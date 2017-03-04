<?php
    include '../../../../db.php';
    include '../../../../../helpers.php';

    $config = require "../../../../../kbf.config.php";
    session_start();
    forceHttps($config);
    checkSessionApi($config);
    checkResponsible();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $inputJSON = file_get_contents('php://input');
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/open/person/item/ - $inputJSON");
        $input = json_decode($inputJSON, TRUE); //convert JSON into array
        if(!isset($input['open_person'])) {
            error("Missing open_person parameter");
        } else if(!isset($input['name']) ) {
            error("Missing name parameter");
        }
        else if(!isset($input['price'])) {
            error("Missing price parameter");
        } else {
            $mysqli = getDBConnection($config);
            $open_person = cleanField($input['open_person'], $mysqli);
            $name = cleanField($input['name'], $mysqli);
            $price = cleanField($input['price'], $mysqli);
            $sql = "INSERT INTO `open_item` (`open_person`, `name`, `price`) VALUES ('$open_person','$name','$price')";
            handleResult($mysqli->real_query($sql));
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $inputJSON = file_get_contents('php://input');
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/open/person/item/ - $inputJSON");
        $input = json_decode($inputJSON, TRUE); //convert JSON into array
        if(!isset($input['id'])) {
            error("Missing id parameter");
        } else if(!isset($input['name']) ) {
            error("Missing name parameter");
        }
        else if(!isset($input['price'])) {
            error("Missing price parameter");
        } else {
            $mysqli = getDBConnection($config);
            $id = cleanField($input['id'], $mysqli);
            $name = cleanField($input['name'], $mysqli);
            $price = cleanField($input['price'], $mysqli);
            $sql = "UPDATE `open_item` SET `name`='$name', `price`='$price' WHERE `id`=$id";
            handleResult($mysqli->real_query($sql));
        }
    }  else if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $inputJSON = file_get_contents('php://input');
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/open/person/item/ - $inputJSON");
        $input = json_decode($inputJSON, TRUE); //convert JSON into array
        if(!isset($input['id'])) {
            error("Missing id parameter");
        } else  {
            $mysqli = getDBConnection($config);
            $item_id = cleanField($input['id'], $mysqli);
            $sql = "DELETE FROM `open_item` WHERE `id` = $item_id";
            $result  = $mysqli->real_query($sql);
            handleResult($result, $mysqli);
        }
    } else {
        error("Not implemented");
    }
?>

