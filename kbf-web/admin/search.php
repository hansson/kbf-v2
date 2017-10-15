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
                        getHeader("search");
                    ?>
                </ul>
            </nav>
        </div>

        <div class="row content">
            <div class="col-lg-6">
                <div class="contained">
                    <h5 class="heading">Sök användare</h5>
                    <p>Om flera resultat visas kan du klicka på användaren för att få mer information.</p>
                    <div>
                        <div class="form-group">
                            <input id="searchNumber" class="form-control" type="text" placeholder="Födelsedatum" autocomplete="off">
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
                    <h5>Betalningar</h5>
                    <p id="tmpHolder"></p>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Betalning</th>
                                <th>Datum</th>
                            </tr>
                        </thead>
                        <tbody id="paymentTable">
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
    <script src="../js/tether.min.js"></script>
    <script src="../js/bootstrap/bootstrap.js"></script>
    <script src="../js/bootstrap/ie10-viewport-bug-workaround.js"></script>
    <script src="../js/moment.js"></script>
    <script src="../js/helpers.js"></script>
    <script src="../js/paymentItems.js"></script>
    

    <script>
        var loggedInUser = $.cookie("user");
        logoutIfNotSet(loggedInUser);

        $("#search").click(function(){
            $("#searchTable").html("");
            var pnr = $("#searchNumber").val();
            if(pnr && pnr.trim() != "") {
                $.get( "../api/private/search/person?pnr=" + pnr, function(response) {
                    for(var i = 0 ; i < response.length ; i++) {
                        addSearchPerson(response[i]);
                    }
                }, "json").fail(function(response) {
                    alert(response);
                });
            }
        });

        function addSearchPerson(person) {
            var row = "<tr id=\"search-" + person.pnr + "\">";
            row += "<td>" + person.pnr + "</td>";
            row += "<td>" + person.name + "</td>";
            row += "<td>" + person.email + "</td>";
            row += "</tr>";
            $("#searchTable").append(row);
            $("#search-" + person.pnr).click(function() {
                populatePayments(person.payments);
            });
        };

        function populatePayments(payments) {
            var paymentHtml = "";
            for(var i = 0 ; i < payments.length ; i++) {
                paymentHtml += "<tr><td>" + payments[i].name + "</td><td>" + payments[i].paymentDate +"</td></tr>"
            }
            $("#paymentTable").html(paymentHtml);
        }

        function getRequestItem(item, request) {
            var requestItem;
            if(request.pnr) {
                requestItem = {
                    id: item.id,
                    price: item.price_member ? item.price_member : item.price
                };
            } else {
                requestItem = {
                    id: item.id,
                    price: item.price
                };
            }
            return requestItem;
        };
    </script>
</body>

</html>