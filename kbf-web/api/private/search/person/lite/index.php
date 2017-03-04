<?php
    include '../../../../classes/ClimbInfo.php';
    include_once '../../../../../helpers.php';

    $config = require "../../../../../kbf.config.php";
    session_start([
        'cookie_lifetime' => 86400,
        'read_and_close'  => true,
    ]);
    forceHttps($config);
    checkSessionApi($config);

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/person/lite/ - " . http_build_query($_GET));
        if(isset($_GET['pnr'])) {
            $pnr = $_GET['pnr'];
            if($pnr == $_SESSION['pnr'] || checkResponsible()) {
                $pnr = checkPnr($pnr);
                $climbInfo = new ClimbInfo($pnr);
                $member_valid = $climbInfo->getMemberValid();
                $fee_valid = $climbInfo->getFeeValid();
                $left = $climbInfo->getLeft();

                $json_result = "{";
                $json_result .= "\"memberValid\":\"$member_valid\",";
                $json_result .= "\"feeValid\":\"$fee_valid\",";
                $json_result .= "\"left\":\"$left\"";
                $json_result .= "}";
                echo $json_result;
            }         
        } else {
           error("Missing parameter pnr");
        }
    } else {
        error("Not implemented");
    }
?>

