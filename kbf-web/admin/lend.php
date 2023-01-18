<?php
    include '../helpers.php';
    $config = require '../kbf.config.php';
    session_start([
        'cookie_lifetime' => 86400,
        'read_and_close'  => true,
    ]);
    forceHttps($config);
    checkSession();
    redirectNotResponsible();
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
                        getHeader("lend");
                    ?>
                </ul>
            </nav>
        </div>

        <div class="row content">
            <div class="col-lg-6">
                <div class="contained">
                    <h5 class="heading">Låna</h5>
                    <div>
                        <div class="form-group">
                            <div class="form-group">
                                <input id="lend_member" class="form-control" type="text" placeholder="Medlemsnummer" inputmode="numeric" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input id="lend_item" class="form-control" type="text" placeholder="Beskrivning" inputmode="text" autocomplete="off">
                            </div>
                            <div class="contained">
                                <div>
                                    <button id="lend" type="button" class="btn btn-primary form-control">Låna</button>
                                </div>
                            </div>
                        </div>
                        <div id="lendError" class="alert alert-danger hidden" role="alert">
                            <strong>Något gick fel, kontrollera uppgifterna och försök igen!</strong>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="contained">
                    <h5 class="heading">Utlånat</h5>
                    <div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Lånat</th>
                                    <th>Medl.</th>
                                    <th>Ansv.</th>
                                    <th>Datum</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="lendList">
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="contained">
                    <h5 class="heading">Historik</h5>
                    <div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Lånat</th>
                                    <th>Medl.</th>
                                    <th>Ansv.</th>
                                    <th>Datum</th>
                                </tr>
                            </thead>
                            <tbody id="historicLendList">
                            </tbody>
                        </table>
                        
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
    <script src="../js/paymentItems.js"></script>
    

    <script>
        var loggedInUser = $.cookie("user");
        logoutIfNotSet(loggedInUser);

        function reloadLendList() {
            $("#lendList").html("");
            $.get( "../api/private/lending/", function(response) {
                for(var i = 0 ; i < response.length ; i++) {
                    var id = response[i].id;
                    var member = response[i].member;
                    var lendedAt = moment(response[i].lended_at).format("YYYY-MM-DD");
                    var lended = response[i].lended;
                    var responsible = response[i].responsible;
                    var lendRow = "<tr><td>" + lended + "</td>" + "<td>" + member + "</td>" + "<td>" + responsible + "</td>" + "<td>" + lendedAt + "</td>" + "<td><button id=\"lend-row-" + id + "\" type=\"button\" class=\"btn btn-success form-control\"><i class=\"fa fa-check\"></i></button></td></tr>";
                    $("#lendList").append(lendRow);
                    $("#lend-row-" + id).click(function() {
                        $.ajax({
                            url: "../api/private/lending?id=" + id,
                            type: 'DELETE',
                            success: function(result) {
                                reloadLendList();
                            }
                        });
                    });
                }
            }, "json");

            $("#historicLendList").html("");
            $.get( "../api/private/lending/historic/", function(response) {
                for(var i = 0 ; i < response.length ; i++) {
                    var id = response[i].id;
                    var member = response[i].member;
                    var returnedAt = moment(response[i].returned_at).format("YYYY-MM-DD");
                    var lended = response[i].lended;
                    var responsible = response[i].responsible;
                    var lendRow = "<tr><td>" + lended + "</td>" + "<td>" + member + "</td>" + "<td>" + responsible + "</td>" + "<td>" + returnedAt + "</td></tr>";
                    $("#historicLendList").append(lendRow);
                }
            }, "json");
        };

        $("#lend").click(function() {
            if(logoutIfNotSet(loggedInUser)) {
                return;
            }
            hide($("#lendError"));
            var request = {
                responsible: loggedInUser,
                member: $("#lend_member").val(),
                lended: $("#lend_item").val()
            }

            $.post( "../api/private/lending/", JSON.stringify(request), function(response) {
                reloadLendList();
            }, "json").fail(function(response) {
                show($("#lendError"));
            });
        });

        reloadLendList();

    </script>
</body>

</html>