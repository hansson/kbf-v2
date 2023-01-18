<?php
    include '../../../db.php';
    include '../../../../helpers.php';
    include '../../../classes/Lending.php';
    include '../../../classes/LendingContainer.php';

    $config = require "../../../../kbf.config.php";
    session_start([
        'cookie_lifetime' => 86400,
        'read_and_close'  => true,
    ]);
    forceHttps($config);
    checkSessionApi($config);
    checkResponsible();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $lends = new LendingContainer();
        echo $lends->printHistoric();
    } else {
        error("Not implemented");
    }
?>

