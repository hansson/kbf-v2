<?php
    include '../../db.php';
    include '../../../helpers.php';

    $config = require "../../../kbf.config.php";
    session_start();
    forceHttps($config);
    checkSessionApi($config);
    checkResponsible();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        error("Not implemented");
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if(isset($_GET['pnr'])) {
            $mysqli = getDBConnection($config);

            $pnr = cleanField($_GET['pnr'], $mysqli);
            try {
                $pnr = handlePersonalNumber($pnr);
            } catch ( Exception $e ) {
                error("Bad personal number");
                $mysqli->close();
                return;
            }
            
            
            $mysqli->close();            
        } else {
           error("Missing parameter pnr");
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        error("Not implemented");
    }
?>

