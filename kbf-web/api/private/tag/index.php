<?php
    include '../../classes/TagInfo.php';
    include_once '../../../helpers.php';
    
    $config = require "../../../kbf.config.php";
    session_start([
        'cookie_lifetime' => 86400,
        'read_and_close'  => true,
    ]);
    forceHttps($config);
    checkSessionApi($config);

    if( $_SERVER['REQUEST_METHOD'] === 'GET' ) {
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/tag/ - " . http_build_query($_GET));
        $tag = new TagInfo($_SESSION["pnr"]);
        if($tag->getTagValid() != "-") {
            echo "{";
            echo "\"valid\": true";
            echo "}";
        } else {
            error("No tag");
        }
    } else {
     error("Not implemented");
    }
   
?> 