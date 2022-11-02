<?php
    include '../../../../classes/CurrentOpen.php';
    include_once '../../../../../helpers.php';
    
    $config = require "../../../../../kbf.config.php";
    session_start([
        'cookie_lifetime' => 86400,
        'read_and_close'  => true,
    ]);
    forceHttps($config);
    checkSessionApi($config);
    checkResponsible();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/open/checkedin/increment");
        if(isset($_SESSION["pnr"])) {
            //current open
            $open = new CurrentOpen($_SESSION["pnr"]);
            echo $open->incrementCurrentCheckedIn();
        } else {
            error("Session does not match responsible");
        }
    } else  {
        error("Not implemented");
    }
?> 