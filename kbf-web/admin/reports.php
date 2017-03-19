<?php
    include '../helpers.php';
    $config = require '../kbf.config.php';
    session_start([
        'cookie_lifetime' => 86400,
        'read_and_close'  => true,
    ]);
    forceHttps($config);
    checkSession();
    redirectNotAdmin();
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

    <link href="../css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap/narrow-jumbotron.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">

</head>

<body>

    <div class="container">
        <div class="row content hidden-md-up">
            <div class="col-lg-12">
                <a href="../index.php"><h3 class="text-muted">Karlskrona Bergsportsförening</h3></a>
            </div>
        </div>
        <div class="header clearfix">
            <a href="../index.php"><h3 class="text-muted hidden-sm-down head-img"><img class="logo" src="../img/logo.png">Karlskrona Bergsportsförening</h3></a>
            <nav>
                <ul class="nav nav-pills flex-column flex-sm-row">
                    <?php
                        getHeader("reports");
                    ?>
                </ul>
            </nav>
        </div>
        

        <div id="open" class="row content">
            <div class="col-lg-12">
                <div class="contained">
                    <h5 class="heading">Välj år och månad att generera rapport från</h5>
                    <div>
                        <div class="form-group">
                            <input id="year" class="form-control" type="number" placeholder="Fyrsiffrigt år">
                        </div>
                        <div class="form-group">
                            <input id="month" class="form-control" type="number" placeholder="Månadsnummer">
                        </div>
                        <div class="contained">
                            <div>
                                <button id="generate" type="button" class="btn btn-primary form-control">Kassablad</button>
                            </div>
                            <div>
                                <button id="generate_fee" type="button" class="btn btn-primary form-control">Avgifter (helår)</button>
                            </div>
                        </div>
                    </div>
                </div>
                            
            </div>
        </div>

        <footer class="footer">
            <p>&copy; Karlskrona Bergsportsförening 2017</p>
        </footer>

    </div>
    <!-- /container -->

    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/jquery.cookie.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="../js/bootstrap/bootstrap.js"></script>
    <script src="../js/bootstrap/ie10-viewport-bug-workaround.js"></script>
    <script src="../js/moment.js"></script>
    <script src="../js/helpers.js"></script>
    
    <script>
        var year = new Date().getFullYear();
        var month = new Date().getMonth();
        if(month == 0) {
            month = 12;
            year = year - 1;
        }
        $("#year").val(year);
        $("#month").val(month);
        $("#generate").on("click", function() {
            year = $("#year").val();
            month = $("#month").val();
            window.location = "../api/private/open/report?month=" + month + "&year=" + year;    
        });
        $("#generate_fee").on("click", function() {
            year = $("#year").val();
            window.location = "../api/private/fee/report?year=" + year;    
        });
    </script>
</body>

</html>