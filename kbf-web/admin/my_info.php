<?php
    include '../helpers.php';
    include '../api/classes/MiscInfo.php';
    $config = require '../kbf.config.php';
    session_start([
        'cookie_lifetime' => 86400,
        'read_and_close'  => true,
    ]);
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
                    getHeader("my_info");
                ?>
                </ul>
            </nav>
        </div>
        <div id="unexpected_error" class="alert alert-danger hidden" role="alert">
            <strong>Ett oväntat fel inträffade! Var vänlig försök igen, om felet kvarstår, kontakta webbansvarig.</strong>
        </div>
        <div id="checked_in" class="alert alert-success hidden" role="alert">
            <strong>Du är incheckad!</strong>
        </div>
        <div id="checkin_error" class="alert alert-danger hidden" role="alert">
            <strong>Det gick inte att checka in dig. Var vänlig kontakta kvällens öppetansvariga.</strong>
        </div>
        <div class="row content">
            <div class="col-lg-12 ">
                <?php
                    if(isResponsible()) {
                        echo '<div id="responsibleInfo" class="contained">';
                        echo '<div>';
                        echo '<h4 class="text-center">Information för öppetansvariga</h4>';
                        $info = new MiscInfo(1);
                        $info->print();
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo '<div id="tagInfo" class="contained hidden">';
                        echo '<div>';
                        echo '<h4 class="text-center">Information till tagg</h4>';
                        $info = new MiscInfo(4);
                        $info->print();
                        echo '</div>';
                        echo '</div>';
                    }
                ?>
                <div id="open" class="contained hidden">
                    <div>
                        <h4 class="text-center">Klubben är öppen</h4>
                        <button id="checkin" type="button" class="btn btn-success form-control">Checka in!</button>
                    </div>
                </div>

                <div class="contained">
                    <div>
                        <h5 id="member-id" class="heading"><span id="name"></span>, medlemsnummer: <span id="number"></span></h5>
                    </div>
                </div>

                <div class="contained">
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

                        <div id="climb" class="card text-center hidden">
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
                                10-kort(<span id="personInfoTenCard"></span>)
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
        </div>

        <footer class="footer">
            <p>&copy; Karlskrona Bergsportsförening <?php echo date("Y"); ?></p>
        </footer>

    </div>
    <!-- /container -->

    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/jquery.cookie.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
        crossorigin="anonymous"></script>
    <script src="../js/bootstrap/bootstrap.js"></script>
    <script src="../js/bootstrap/ie10-viewport-bug-workaround.js"></script>
    <script src="../js/moment.js"></script>
    <script src="../js/helpers.js"></script>
    <script src="../js/prePaid.js"></script>


    <script>
        var doAfterShowInfo = undefined;
        var cardValue = function(value){
            return value;
        };

        var loggedInUser = $.cookie("user");
        logoutIfNotSet(loggedInUser);
        $("#number").html(loggedInUser);

        $.get("../api/private/search/person?search=" + loggedInUser + "&exact=1", function (response) {
            $("#name").html(response[0].name);
        }, "json").fail(function (response) {
            show($("#unexpected_error"));
        });

        $.get("../api/private/search/person/lite?pnr=" + loggedInUser, handlePrePaid, "json").fail(function (response) {
            show($("#unexpected_error"));
        });

        $.get( "../api/private/checkin", function(response) {
            show($("#open"));   
        }, "json").fail(function(response) {
            hide($("#open"));
        });

        $.get( "../api/private/tag", function(response) {
            show($("#tagInfo"));   
        }, "json").fail(function(response) {
            hide($("#tagInfo"));
        });

        $("#checkin").click(function(){
            if(logoutIfNotSet(loggedInUser)) {
                return;
            }
            hide($("#checked_in"));
            hide($("#checkin_error"));
            hide($("#unexpected_error"))
            var request = {
                pnr: loggedInUser
            };
            $.post( "../api/private/checkin/", JSON.stringify(request), function() {
                show($("#checked_in"));
            }, "json").fail(function(response) {
                show($("#checkin_error"));
            });
        });
    </script>
</body>

</html>