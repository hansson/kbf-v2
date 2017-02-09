<?php
    include '../../db.php';
    include '../../../helpers.php';
    
    $config = require "../../../kbf.config.php";
    forceHttps($config);

    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, TRUE); //convert JSON into array
        if(isset($input['email']) && isset($input['password'])) {
            $mysqli = getDBConnection($config);
            $email = cleanField($input['email'], $mysqli);
            $password = $input['password'];
            $sql = "SELECT password, pnr, active, responsible FROM `person` WHERE `email` = '$email'";
            $result  = $mysqli->query($sql);
            if($result && $result->num_rows === 1) {
                $row = $result->fetch_row();
                $hash = $row[0];
                $pnr = $row[1];
                $active = $row[2];
                $responsible = $row[3];
                if($active == 0) {
                    error("Not active");
                } else {
                    $options = array('cost' => 10);
                    if (true === password_verify($password, $hash)) {
                        if (true === password_needs_rehash($hash, PASSWORD_DEFAULT, $options)) {
                            $new_hash = password_hash($password, PASSWORD_DEFAULT, $options);
                            $sql="UPDATE `person` SET `password`='$new_hash' WHERE `email` = '$email'";
                            $mysqli->real_query($sql);
                        }
                        $_SESSION["pnr"] = $pnr;
                        $_SESSION["responsible"] = $responsible;
                        echo "{\"status\":\"ok\",\"pnr\":\"$pnr\"}";
                    } else {
                        invalidateSession("Wrong Email or Password");
                    }
                }
            } else {
                invalidateSession("Wrong Email or Password");
            }
            $mysqli->close();
        } else {
            invalidateSession("Missing Email or password");
        }
    } else {
        error("Not implemented");
    }
    
?>