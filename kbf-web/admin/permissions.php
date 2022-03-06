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
        <div id="permissions_success" class="alert alert-success hidden" role="alert">
            <strong>Behörigheter sparade.</strong>
        </div>

        <div class="row content">
            <div class="col-lg-12">
                <nav>
                    <ul class="nav nav-pills flex-column flex-sm-row">
                        <li class="nav-item">
                            <a class="nav-link" href="administer.php">Användare</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Behörigheter</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="row content">
            <div class="col-lg-6">
                <div class="contained">
                    <h5 class="heading">Sök användare</h5>
                    <p>Klicka på en användare för att hantera behörigheter.</p>
                    <div>
                        <div class="form-group">
                            <input id="searchNumber" class="form-control" type="text" placeholder="Namn eller födelsedatum" autocomplete="off">
                        </div>
                        <button id="search" type="button" class="btn btn-primary form-control">Sök</button>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Namn</th>
                                <th>E-post</th>
                            </tr>
                        </thead>
                        <tbody id="searchTable">
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="contained">
                    <h5>Behörigheter</h5>
                    <input id="pnr" type="hidden" />
                    <div class="form-group">
                        <div class="form-check">
                            <label class="custom-control custom-checkbox">
                                <input id="responsible" type="checkbox" class="custom-control-input">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Öppetansvarig</span>
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="custom-control custom-checkbox">
                                <input id="admin" type="checkbox" class="custom-control-input">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Admin</span>
                            </label>
                        </div>
                        <button id="save" type="button" class="btn btn-primary form-control">Spara</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="../js/bootstrap/bootstrap.js"></script>
    <script src="../js/bootstrap/ie10-viewport-bug-workaround.js"></script>
    <script src="../js/moment.js"></script>
    <script src="../js/helpers.js"></script>
    

    <<script>
        var loggedInUser = $.cookie("user");
        logoutIfNotSet(loggedInUser);

        $("#search").click(function(){
            hideAll();
            $("#searchTable").html("");
            var pnr = $("#searchNumber").val();
            if(pnr && pnr.trim() != "") {
                $.get( "../api/private/search/person?search=" + pnr, function(response) {
                    for(var i = 0 ; i < response.length ; i++) {
                        addSearchPerson(response[i]);
                    }
                }, "json").fail(function(response) {
                    $("#unexpectedError strong").html(response.responseJSON.error);
                    show($("#unexpectedError"));
                });
            }
        });

        $("#save").click(function() {
            hideAll();
            var request = {
                pnr: $("#pnr").val(),
                permissions: getPermissions()    
            }
            $.post( "../api/private/person/permissions/", JSON.stringify(request), function(response) {
                show($("#permissions_success"));
            }, "json").fail(function(response){
                $("#unexpectedError strong").html(response.responseJSON.error);
                show($("#unexpected_error"));
            }); 
        });

        function hideAll() {
            hide($("#unexpectedError"));
            hide($("#permissions_success"));
        }

        function addSearchPerson(person) {
            var row = "<tr id=\"search-" + person.pnr + "\">";
            row += "<td>" + person.pnr + "</td>";
            row += "<td id=\"name_"+ person.pnr + "\">" + person.name + "</td>";
            row += "<td id=\"email_"+ person.pnr + "\">" + person.email + "</td>";
            row += "</tr>";
            $("#searchTable").append(row);
            $("#search-" + person.pnr).click(function() {
                populatePermissions(person);
            });
        };

        function populatePermissions(person) {
            $("#pnr").val(person.pnr);
            var responsible = $("#responsible");
            var admin = $("#admin");
            var permissions = person.permissions;

            if(permissions ==  0) {
                responsible.prop('checked', false);
                admin.prop('checked', false);
            } else if(permissions ==  1) {
                responsible.prop('checked', true);
                admin.prop('checked', false);
            } else if(permissions ==  2) {
                responsible.prop('checked', false);
                admin.prop('checked', true);
            } else if(permissions ==  3) {
                responsible.prop('checked', true);
                admin.prop('checked', true);
            }
        }

        function getPermissions() {
            var value = 0;
            if($("#responsible").is(":checked")) {
                value++;
            }
            if($("#admin").is(":checked")) {
                value += 2;
            }
            return value;
        }
    </script>
</body>

</html>