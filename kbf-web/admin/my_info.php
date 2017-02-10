<?php
    include '../helpers.php';
    $config = require '../kbf.config.php';
    session_start();
    forceHttps($config);
    checkSession();
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
        <div class="header clearfix">
            <nav>
                <ul class="nav nav-pills float-right">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Min info <span class="sr-only">(current)</span></a>
                    </li>
                    <!--<li class="nav-item">
                        <a class="nav-link" href="#">Mina Uppgifter</a>
                    </li>-->
                </ul>
            </nav>

            <a href="../index.php"><h3 class="text-muted"><img class="logo" src="../img/logo.png">Karlskrona Bergsportsförening</h3></a>
        </div>
        <div id="unexpected_error" class="alert alert-danger hidden" role="alert">
            <strong>Ett oväntat fel inträffade! Var vänlig försök igen, om felet kvarstår, kontakta webbansvarig.</strong>
        </div>
        <div class="row content">
            <div class="col-lg-12 contained">
                <div>
                    <h5 id="member-id" class="heading">Ditt medlemsnummer: </h5>
                    <div>
                        <p><span id="name"></span>, för tillfället kan du som medlem inte se se mer information än ditt medlemsnummer</p>
                    </div>
                </div>
            </div>
        </div>

        <div id="check-in" class="row content hidden">
            <div class="col-lg-12 contained">
                <div>
                    <h5 class="heading">Hittade inget öppet kassablad!</h5>
                    <div>
                        <button id="open_btn" type="button" class="btn btn-primary">Öppna</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="info" class="row content hidden">
            <div class="col-lg-12 contained">
                <div id="personInfo" class="card-deck">
                    <div id="member" class="card text-center hidden">
                        <div class="card-header">
                            Medlem
                        </div>
                        <div class="card-block">
                            <i id="personInfoMember" class="fa fa-check big-icon green hidden" aria-hidden="true"></i>
                            <i id="personInfoAttentionMember" class="fa fa-exclamation-triangle big-icon yellow  hidden" aria-hidden="true"></i>
                            <i id="personInfoNoMember" class="fa fa-remove big-icon red hidden" aria-hidden="true"></i>
                            <p id="personInfoMemberUntil"></p>
                        </div>

                    </div>

                    <div id="climb"  class="card text-center hidden">
                        <div class="card-header">
                            Klättringsavgift
                        </div>
                        <div class="card-block">
                            <i id="personInfoClimb" class="fa fa-check big-icon green hidden" aria-hidden="true"></i>
                            <i id="personInfoAttentionClimb" class="fa fa-exclamation-triangle big-icon yellow hidden" aria-hidden="true"></i>
                            <i id="personInfoNoClimb" class="fa fa-remove big-icon red hidden" aria-hidden="true"></i>
                            <p id="personInfoClimbUntil"></p>
                        </div>
                    </div>

                    <div id="ten" class="card text-center hidden">
                        <div class="card-header">
                            10-kort
                        </div>
                        <div class="card-block">
                            <i id="personInfoTen" class="fa fa-check big-icon green hidden" aria-hidden="true"></i>
                            <i id="personInfoAttentionTen" class="fa fa-exclamation-triangle big-icon yellow hidden" aria-hidden="true"></i>
                            <i id="personInfoNoTen" class="fa fa-remove big-icon red hidden" aria-hidden="true"></i>
                            <p id="personInfoTenUntil"></p>
                        </div>
                    </div>

                    <div>


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

        var loggedInUser = $.cookie("user");
        
        $("#member-id").html("Ditt medlemsnummer: " + loggedInUser);

        $.get( "../api/private/search/person?pnr=" + loggedInUser, function(response) {
            $("#name").html(response[0].name);
        }, "json").fail(function(response) {
            show($("unexpected_error"));
        });
    </script>
</body>

</html>