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
                        getHeader("administer");
                    ?>
                </ul>
            </nav>
        </div>
        <div id="unexpected_error" class="alert alert-danger hidden" role="alert">
            <strong>Ett oväntat fel inträffade! Var vänlig försök igen, om felet kvarstår, kontakta webbansvarig.</strong>
        </div>

        <div id="open" class="row content">
            <div class="col-lg-6">
                <div class="contained">
                    <h5 class="heading">Aktivera användare</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Namn</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="personTable">
                        </tbody>
                    </table>
                            
                </div>
            </div>

            <div class="col-lg-6">
                <div class="contained">
                    <h5 class="heading">Ej registrerade IdrottOnline</h5>
                    <p>Klicka 'Godkänn' när medlemmen är registrerad på IdrottOnline</p>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="registerTable">
                        </tbody>
                    </table>
                            
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
        logoutIfNotSet(loggedInUser);
        populatePersonTable();
        populateRegisterTable();

        function populateRegisterTable() {
            $.get( "../api/private/inactive/register", function(response) {
                for(var i = 0 ; i < response.length ; i++) {
                    addRegister(response[i]);
                }
            }, "json").fail(function(response) {
                alert(response);
            });
        }
        
        function populatePersonTable() {
            $.get( "../api/private/inactive", function(response) {
                for(var i = 0 ; i < response.length ; i++) {
                    addPerson(response[i]);
                }
            }, "json").fail(function(response) {
                alert(response);
            });
        }

        function addRegister(person) {
            var row = "<tr>";
            row += "<td>" + person.tmp_pnr + "</td>";
            row += "<td><button id=\"register_" + person.tmp_pnr +"\" type=\"button\" class=\"btn btn-success form-control\">Godkänn</button></td>";
            row += "</tr>";
            $("#registerTable").append(row);

            $("#register_" + person.tmp_pnr).on("click", function() {
                var button = $(this);
                var request = {
                    tmp_pnr: person.tmp_pnr,
                };
                $.ajax({
                    url: '../api/private/inactive/register/',
                    type: 'PUT',
                    data: JSON.stringify(request),
                    success: function(response) {
                        hide(button.parent().parent());
                    },
                    error: function(response) {
                        alert(response.responseText);
                    }
                });

            });
        }

        function addPerson(person) {
            var row = "<tr>";
            row += "<td>" + person.pnr + "</td>";
            row += "<td>" + person.name + "</td>";
            row += "<td><button id=\"accept_" + person.pnr +"\" type=\"button\" class=\"btn btn-success form-control\">Godkänn</button></td>";
            row += "<td><button id=\"deny_" + person.pnr + "\" type=\"button\" class=\"btn btn-danger form-control\">Neka</button></td>";
            row += "</tr>";
            $("#personTable").append(row);

            $("#accept_" + person.pnr).on("click", function() {
                var button = $(this);
                //make sibling 100% opacity
                var request = {
                    pnr: person.pnr,
                    active: 1
                };
                $.ajax({
                    url: '../api/private/inactive/',
                    type: 'PUT',
                    data: JSON.stringify(request),
                    success: function(response) {
                        button.css("opacity", 0.2);
                    },
                    error: function(response) {
                        alert(response.responseText);
                    }
                });

            });

            $("#deny_" + person.pnr).on("click", function() {
                var button = $(this);
                var request = {
                    pnr: person.pnr,
                    active: 2
                };
                $.ajax({
                    url: '../api/private/inactive/',
                    type: 'PUT',
                    data: JSON.stringify(request),
                    success: function(response) {
                        button.css("opacity", 0.2);
                    },
                    error: function(response) {
                        alert(response.responseText);
                    }
                });
            });
        }
    </script>
</body>

</html>