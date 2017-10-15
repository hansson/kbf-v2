<?php
    require '../../classes/Receipt.php';
    include_once '../../../helpers.php';
    $config = require '../../../kbf.config.php';
    forceHttps($config);


?>

<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../favicon.ico">

    <title>Karlskrona Bergsportsförening</title>

    <link href="css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap/narrow-jumbotron.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
</head>

<body>
    <?php
        $receipt = new Receipt($_GET['receipt'], $_GET['id'],  $_GET['type'], "");
        echo $receipt->print();
    ?>
</body>

</html>