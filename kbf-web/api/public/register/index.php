<?php
    include '../../db.php';
    include '../../../helpers.php';
    
    $config = require "../../../kbf.config.php";
    forceHttps($config);

    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, TRUE); //convert JSON into array
        if(!isset($input['firstname'])) {
            error("Missing first name");
        } else if(!isset($input['lastname'])) {
            error("Missing last name");
        } else if(!isset($input['pnr'])) {
            error("Missing birthday");
        } else if(!isset($input['email'])) {
            error("Missing email");
        } else if(!isset($input['password'])) {
            error("Missing password");
        } else {
            $mysqli = getDBConnection($config);
            $name = cleanField($input['firstname'], $mysqli);
            $name .= " " . cleanField($input['lastname'], $mysqli);
            $email = cleanField($input['email'], $mysqli);
            $password = $input['password'];
            $pnr = $input['pnr'];
            try {
                $pnr = handlePersonalNumber($pnr);
                if(strlen($pnr) > 6) { //We do not allow yymmdd-x for registration
                    throw new Exception("Bad personal number");
                }
            } catch ( Exception $e ) {
                error("Bad personal number");
                $mysqli->close();
                return;
            }
            $options = array('cost' => 10);
            $password = password_hash($password, PASSWORD_DEFAULT, $options);
            $sql = "SELECT pnr FROM `person` WHERE `pnr` LIKE '$pnr%'";
            $result  = $mysqli->query($sql);
            if($result && $result->num_rows > 0) {
                $pnr .= "-$result->num_rows";
            }
            $sql = "INSERT INTO person (name, pnr, email, password) VALUES ('$name', '$pnr', '$email', '$password')";
            $result  = $mysqli->real_query($sql);
            handleResult($result, $mysqli);
            $mysqli->close();
        }
    } else {
        error("Not implemented");
    }
    
?>