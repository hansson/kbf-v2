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
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Öppna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Registrera <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Kontrollera</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="administer.php">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="my_info.php">Min info</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div id="unexpected_error" class="alert alert-danger hidden" role="alert">
            <strong>Ett oväntat fel inträffade! Var vänlig försök igen, om felet kvarstår, kontakta webbansvarig.</strong>
        </div>

        <div class="row content">
            <div class="col-lg-6">
                <div class="contained">
                    <h5 class="heading">Lägg till avgift</h5>
                    <div>
                        <p>Personnummer behöver bara fyllas i om man köper medlemsavgift.</p>
                        <div id="paySuccess" class="alert alert-success hidden" role="alert">
                            <strong>Köp genomfört för <span id="payReference"></span>!</strong>
                        </div>
                        <div class="form-group">
                            <input id="item_pnr" class="form-control" type="text" placeholder="Medlemsnummer">
                        </div>
                        <div class="form-group">
                            <input id="item_tmp_pnr" class="form-control" type="text" placeholder="Personnummer">
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <label class="custom-control custom-checkbox">
                                    <input id="item_1" type="checkbox" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Medlemsavgift</span>
                                </label>
                            </div>

                            <div class="form-check">
                                <label class="custom-control custom-checkbox">
                                    <input id="item_2" type="checkbox" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Medlemsavgift(0-17 år)</span>
                                </label>
                            </div>

                            <div class="form-check">
                                <label class="custom-control custom-checkbox">
                                    <input id="item_3" type="checkbox" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Årskort</span>
                                </label>
                            </div>

                            <div class="form-check">
                                <label class="custom-control custom-checkbox">
                                    <input id="item_4" type="checkbox" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Terminskort</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="custom-control custom-checkbox">
                                    <input id="item_5" type="checkbox" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">10-kort</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="custom-control custom-checkbox">
                                    <input id="item_9" type="checkbox" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Årskort(barn)</span>
                                </label>
                            </div>

                            <div class="form-check">
                                <label class="custom-control custom-checkbox">
                                    <input id="item_10" type="checkbox" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Terminskort(barn)</span>
                                </label>
                            </div>
                        </div>

                        <div class="contained">
                            <div>
                                <h5 id="total">Totalt: 0 kr</h5>
                                <button id="pay" type="button" class="btn btn-primary form-control">Betala</button>
                            </div>
                        </div>
                        <div id="payError" class="alert alert-danger hidden" role="alert">
                            <strong>Något gick fel, kontrollera uppgifterna och försök igen!</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="contained">
                    <h5 class="heading">Sök användare</h5>
                    <div>
                        <div class="form-group">
                            <input id="searchNumber" class="form-control" type="text" placeholder="Födelsedatum">
                        </div>
                        <button id="search" type="button" class="btn btn-primary form-control">Sök</button>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Medlemsnummer</th>
                                <th>Namn</th>
                                <th>E-post</th>
                            </tr>
                        </thead>
                        <tbody id="searchTable">
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
    <script src="../js/paymentItems.js"></script>
    

    <script>
        var items = [
            {
                "id": 1,
                "name": "Medlemsavgift",
                "price": 250,
                "item_type": "checkbox"
            },
            {
                "id": 2,
                "name": "Medlemsavgift(0-17 år)",
                "price": 150,
                "item_type": "checkbox"
            },
            {
                "id": 3,
                "name": "Årskort",
                "price": 800,
                "item_type": "checkbox"
            },
            {
                "id": 4,
                "name": "Terminskort",
                "price": 500,
                "item_type": "checkbox"
            },
            {
                "id": 5,
                "name": "10-kort",
                "price": 400,
                "price_member": 300,
                "item_type": "checkbox"
            },
            {
                "id": 9,
                "name": "Årskort(barn)",
                "price": 600,
                "item_type": "checkbox"
            },
            {
                "id": 10,
                "name": "Terminskort(barn)",
                "price": 400,
                "item_type": "checkbox"
            }
        ];

        var loggedInUser = $.cookie("user");

        handlePaymentItems();
        
        $("#pay").click(function() {
            hide($("#payError"));
            hide($("#paySuccess"));
            var request = {
                signed: loggedInUser,
                items: []
            }
            var nameOrPnr = $("#item_pnr").val();
            if(checkPersonalNumber(nameOrPnr)) {
                request.pnr = nameOrPnr;
            }
            var tmpPnr = $("#item_tmp_pnr").val();
            if(tmpPnr != "") {
                request.tmp = tmpPnr;
            }

            for(var i = 0 ; i < items.length ; i++) {
                var item = items[i];
                if(item.item_type == "checkbox") {
                    var requestItem = itemFromCheckbox($("#item_" + item.id), item, request, getRequestItem);
                    if(requestItem) {
                        request.items.push(requestItem);
                    }
                } else if(item.item_type == "amount") {
                    request.items = request.items.concat(itemsFromAmount($("#item_" + item.id), item, request, getRequestItem));
                }
            }

            $.post( "../api/private/fee/", JSON.stringify(request), function(response) {
                //TODO make dynamic
                show($("#paySuccess"));
                $("#payReference").html(response.reference);
                

                for(var i = 0 ; i < items.length ; i++) {
                    var item = items[i];
                    var html_item = $("#item_" + item.id);
                    if(item.item_type === "checkbox" && html_item.is(":checked")) {
                        html_item.prop('checked', false);
                    } else if(item.item_type === "amount" && html_item.val() > 0) {
                        html_item.val("0");
                    }
                }
                $("#total").html("Totalt: 0 kr");
                $("#item_pnr").val("");
            }, "json").fail(function() {
                show($("#payError"));
            });
        });

        $("#search").click(function(){
            var pnr = $("#searchNumber").val();
            $.get( "../api/private/search/person?pnr=" + pnr, function(response) {
                for(var i = 0 ; i < response.length ; i++) {
                    addSearchPerson(response[i]);
                }
            }, "json").fail(function(response) {
                alert(response);
            });
        });

        function addSearchPerson(person) {
            var row = "<tr>";
            row += "<td>" + person.pnr + "</td>";
            row += "<td>" + person.name + "</td>";
            row += "<td>" + person.email + "</td>";
            row += "</tr>";
            $("#searchTable").append(row);
        };

        function getRequestItem(item, request) {
            var requestItem;
            if(request.pnr) {
                requestItem = {
                    name: item.name,
                    price: item.price_member ? item.price_member : item.price
                };
            } else {
                requestItem = {
                    name: item.name,
                    price: item.price
                };
            }
            return requestItem;
        };
    </script>
</body>

</html>