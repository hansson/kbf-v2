<?php
    include '../../../db.php';
    include '../../../../helpers.php';

    $config = require "../../../../kbf.config.php";
    session_start();
    forceHttps($config);
    checkSessionApi($config);
    checkResponsible();

    function getCard($card, $pnr, $open_id, $mysqli) {
        $sql = "";
        if($pnr) {
            $sql = "SELECT card, `left` FROM `ten_card` WHERE `pnr` = '$pnr' AND `left` > 0";
        } else {
            $sql = "SELECT card, `left` FROM `ten_card` WHERE `card` = '$card' AND `left` > 0";
        }

        $result = $mysqli->query($sql);    
        if($result && $result->num_rows === 1) {
            $row = $result->fetch_row();
            $card = $row[0];
            $left = $row[1] - 1;

            $sql = "SELECT id FROM `open_person` WHERE open_id = $open_id AND `card` = $card";
            $result = $mysqli->query($sql);
            if(!$result) {
                $sql = "INSERT INTO `open_person` (`open_id`, `pnr`, `name`) VALUES ($open_id,NULL,'$card')";
                $result  = $mysqli->real_query($sql);
                $sql = "UPDATE `ten_card` SET `left`='$left' WHERE `card`=$card";
                $second_result  = $mysqli->real_query($sql);

                if($result && $second_result) {
                    respond(NULL, $card, $open_id, $mysqli);
                    $mysqli->commit();
                } else {
                    error("Failed to insert row");
                    $mysqli->rollback();
                }
            } else {
                error("Card already exist");
            }
            $mysqli->close();
        } else {
            error("Failed to find card");
        }
    }

    function respond($pnr,$card, $open_id, $mysqli) {
        $sql = "";
        if($pnr) {
            $sql="SELECT id FROM `open_person` WHERE `pnr`='$pnr' AND `open_id`=$open_id AND `name` IS NULL";
        } else {
            $sql="SELECT id FROM `open_person` WHERE `pnr` IS NULL AND `open_id`=$open_id AND `name`='$card'";
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
        //add pre paid
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, TRUE); //convert JSON into array
        if(!isset($input['openId'])) {
            error("Missing openId parameter");
        } else if(isset($input['identification'])) {
            $mysqli = getDBConnection($config);
            $mysqli->autocommit(FALSE);
            $pnr = NULL;
            $card = NULL;
            $open_id = cleanField($input['openId'], $mysqli);
            $pnr = cleanField($input['identification'], $mysqli);
            try {
                $pnr = handlePersonalNumber($pnr);
            } catch ( Exception $e ) {
                //Assume number is a card
                $card = $pnr;
                $pnr = NULL;
            }

            if($pnr) {
                $year = date('Y');
                $month = date('n');
                $sql = "";
                if($month > "6") {
                    $sql = "SELECT paymentDate, `type` FROM `climbing_fee` WHERE `pnr` = '$pnr' AND (paymentDate > '$year-07-01 00:00:00' OR (paymentDate > '$year-01-01 00:00:00' AND `type` = 2)) LIMIT 1";
                } else {
                    $sql = "SELECT paymentDate, `type` FROM `climbing_fee` WHERE `pnr` = '$pnr' AND paymentDate > '$year-01-01 00:00:00' LIMIT 1";
                }
                $result = $mysqli->query($sql);
                if($result && $result->num_rows === 1) {
                    $sql="INSERT INTO `open_person` (`open_id`, `pnr`, `name`) VALUES ($open_id,'$pnr',NULL)";
                    $result  = $mysqli->real_query($sql);
                    if($result) {
                        $mysqli->commit();
                        respond($pnr, NULL, $open_id, $mysqli);
                    }  else {
                        $mysqli->rollback();
                        error("Failed to insert row");
                    }
                    $mysqli->close();
                } else {
                    getCard($card, $pnr, $open_id, $mysqli);
                }
            } else {
                getCard($card, $pnr, $open_id, $mysqli);
            }
        } else {
            error("Missing identification parameter");
        }
    }

?>

