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

        <div id="unexpectedError" class="alert alert-danger hidden" role="alert">
            <strong>Ett oväntat fel inträffade! Var vänlig försök igen, om felet kvarstår, kontakta webbansvarig.</strong>
        </div>
        <div id="receiptError" class="alert alert-danger hidden" role="alert">
            <strong>Det gick inte att skicka kvitto.</strong>
        </div>

        <div class="row content">
            <div class="col-lg-6">
                <div class="contained">
                    <h5 class="heading">Kvitto 10-kort</h5>
                    <p>Klicka på en användare för att visa betalningar.</p>
                    <div>
                        <div class="form-group">
                            <input id="card" class="form-control" type="text" placeholder="10-kort" inputmode="numeric" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input id="email" class="form-control" type="text" placeholder="Epost" inputmode="email" autocomplete="off">
                        </div>
                        <button id="receiptTenCard" type="button" class="btn btn-primary form-control">Skicka kvitto</button>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="contained">
                    <h5 class="heading">Sök användare</h5>
                    <p>Klicka på en användare för att visa betalningar.</p>
                    <div>
                        <div class="form-group">
                            <input id="searchNumber" class="form-control" type="text" placeholder="Namn eller födelsedatum" inputmode="text" autocomplete="off">
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
            </div>
            <div class="col-lg-6">
                <div class="contained">
                    <h5>Betalningar</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Betalning</th>
                                <th>Datum</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="paymentTable">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <footer class="footer">
            <p>&copy; Karlskrona Bergsportsförening <?php echo date("Y"); ?></p>
        </footer>

    </div>
    <!-- /container -->

    <div class="modal fade" id="receiptModal" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span id="receiptPnr" class="hidden"></span>
                    <span id="receiptToken" class="hidden"></span>
                    <h5 class="modal-title">Skicka kvitto till <span id="receiptName"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input id="receiptEmail" class="form-control" type="text" placeholder="Epost" inputmode="email" autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="receipt" type="button" class="btn btn-primary" data-dismiss="modal">Skicka</button>
                </div>
            </div>
        </div>
    </div>

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

        $("#receiptTenCard").click(function() {
            hideAll();
            var card = $("#card").val();
            var email = $("#email").val();

            $.get("../api/private/fee/card/receipt?card=" + card, function(response) {
                if(response.length > 0) {
                    var receipt = response[0].receipt;
                    request =  {
                        card: card,
                        receipt: receipt,
                        email: email,
                    };
                    $.post( "../api/private/fee/card/receipt/", JSON.stringify(request), function(response) {
                        show($("#receiptSuccess"));
                    }, "json").fail(function(response){
                        show($("#receiptError"));
                    });
                } else {
                    //Some error
                }
            }, "json").fail(function(response) {
                $("#unexpectedError strong").html(response.responseJSON.error);
                show($("#unexpectedError"));
            });
        });

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


        $("#receipt").click(function() {
            hideAll();
            request =  {
                id: $("#receiptPnr").html(),
                receipt: $("#receiptToken").html(),
                email: $("#receiptEmail").val(),
                type: "fee"
            };
            if(request.receipt && request.id) {
                $.post( "../api/private/open/receipt/", JSON.stringify(request), function(response) {
                    show($("#receiptSuccess"));
                }, "json").fail(function(response){
                    show($("#receiptError"));
                });
            } else {
                show($("#receiptError"));
            }
        });

        function hideAll() {
            hide($("#receiptSuccess"));
            hide($("#receiptError"));
            hide($("#unexpectedError"));
        }

        function addSearchPerson(person) {
            var row = "<tr id=\"search-" + person.pnr + "\">";
            row += "<td>" + person.pnr + "</td>";
            row += "<td id=\"name_"+ person.pnr + "\">" + person.name + "</td>";
            row += "<td id=\"email_"+ person.pnr + "\">" + person.email + "</td>";
            row += "</tr>";
            $("#searchTable").append(row);
            $("#search-" + person.pnr).click(function() {
                populatePayments(person);
            });
        };

        function populatePayments(person) {
            $("#paymentTable").html("");
            for(var i = 0 ; i < person.payments.length ; i++) {
                var payment = person.payments[i];
                var paymentHtml = "";
                paymentHtml += "<tr><td>" + 
                payment.name + "</td><td>" + 
                payment.paymentDate +  "</td><td>" +
                "<button id=\"receipt-row-" + person.pnr + "-" + i +
                "\" type=\"button\" class=\"btn btn-success form-control\" data-toggle=\"modal\" data-target=\"#receiptModal\" data-receipt=\"" +
                payment.receipt + "\"><i class=\"fa fa-file-o\"></i></button></td>" +
                "</td></tr>";

                $("#paymentTable").append(paymentHtml);

                $("#receipt-row-" + person.pnr + "-" + i).click(function(evt) {
                    var pnr = evt.currentTarget.id.split("-")[2];
                    var receipt = evt.currentTarget.getAttribute("data-receipt");
                    $("#receiptName").html($("#name_" + pnr).html());
                    $("#receiptPnr").html(pnr);
                    $("#receiptToken").html(receipt);
                    $("#receiptEmail").val($("#email_" + pnr).html());
                });
            }

        }
    </script>
</body>

</html>