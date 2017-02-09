<?php
    include '../../db.php';
    include '../../../helpers.php';
    
    $config = require "../../../kbf.config.php";
    session_start();
    forceHttps($config);
    checkSessionApi($config);
    checkResponsible();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //TODO Check logged in PNR=RESPONSIBLE
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, TRUE); //convert JSON into array
        if(isset($input['responsible'])) {
            //create open
            $mysqli = getDBConnection($config);
            $responsible = cleanField($input['responsible'], $mysqli);
            try {
                $responsible = handlePersonalNumber($responsible);
            } catch ( Exception $e ) {
                error("Bad personal number");
                $mysqli->close();
                return;
            }
            if(isset($_SESSION["pnr"]) && $responsible === $_SESSION["pnr"]) {
                $sql="INSERT INTO `open` (`responsible`) VALUES ('$responsible')";
                handleResult($mysqli->real_query($sql));
            } else {
                error("Session does not match responsible");
            }
            
            
        } else {
            error("Missing parameter responsible");
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if(isset($_GET['since'])) {
            //list since
        } else {
            //current open
            $mysqli = getDBConnection($config);
		    $open = "SELECT o.id, o.responsible, o.date, p.name FROM `open` as o INNER JOIN `person` as p ON p.pnr = o.responsible WHERE o.`signed` IS NULL LIMIT 1";
            $result = $mysqli->query($open);
            while($row = $result->fetch_row()) {
                echo "{";
                echo "\"id\":$row[0],";
                echo "\"responsible\":\"$row[1]\",";
                echo "\"date\":\"$row[2]\",";
                echo "\"responsible_name\":\"" . getStringcolumn($row, 3) . "\"";
                echo "}";
            }
            if($result->num_rows === 0) {
                error("No open");
            }
            $mysqli->close();
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
     // update
    }

   
?> 