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
                    getHeader("index");
                ?>
                </ul>
            </nav>
        </div>
        <div id="unexpected_error" class="alert alert-danger hidden" role="alert">
            <strong>Ett oväntat fel inträffade! Var vänlig försök igen, om felet kvarstår, kontakta webbansvarig.</strong>
        </div>
        <div id="receiptError" class="alert alert-danger hidden" role="alert">
            <strong>Det gick inte att skicka kvitto.</strong>
        </div>
        <div id="receiptSuccess" class="alert alert-success hidden" role="alert">
            <strong>Kvitto skickat.</strong>
        </div>
        <div id="closed" class="row content hidden">
            <div class="col-lg-12 contained">
                <div>
                    <div id="successfullyClosed" class="alert alert-success hidden" role="alert">
                        <strong>Kassabladet är nu stängt!</strong>
                    </div>
                    <h5 class="heading">Du har inget öppet kassablad!</h5>
                    <div>
                        <button id="open_btn" type="button" class="btn btn-primary">Öppna</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="wrong_responsible" class="row content hidden">
            <div class="col-lg-12 contained">
                <div>
                    <h5 class="heading">Det finns redan ett öppet kassablad för en annan ansvarig!</h5>
                    <h5 class="heading">Öppnat av: <span id="wrong_responsible_name"></span></h5>
                </div>
            </div>
        </div>

        <div id="open" class="row content hidden">
            <div class="col-lg-6">
                <div class="contained">
                    <h5 class="heading">Lägg till engångsavgifter</h5>
                    <div>
                        <p>Använd medlemsnummer om det är en medlem som betalar, annars skriv namn.</p>
                        <div class="form-group">
                            <input id="item_pnr" class="form-control" type="text" placeholder="Namn eller medlemsnummer" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input id="item_6" class="form-control" type="number" placeholder="Antal Skor" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <label class="custom-control custom-checkbox">
                                    <input id="item_7" type="checkbox" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Klättringsavgift</span>
                                </label>
                            </div>

                            <div class="form-check">
                                <label class="custom-control custom-checkbox">
                                    <input id="item_8" type="checkbox" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Kritboll</span>
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
                <div class="contained">
                    <h5 class="heading">Lägg till förbetald</h5>
                    <div>
                        <div class="form-group">
                            <input id="prePaidNumber" class="form-control" type="text" placeholder="Medlemsnummer / kortnummer" inputmode="numeric" autocomplete="off">
                        </div>
                        <button id="addPrePaid" type="button" class="btn btn-primary form-control">Lägg till</button>
                    </div>
                    <div id="prePaidError" class="alert alert-danger hidden" role="alert">
                        <strong>Misslyckades att lägga till förbetald!</strong>
                    </div>
                    <div id="tenNotFound" class="alert alert-danger hidden" role="alert">
                        <strong>Hittade inte 10-kort!</strong>
                    </div>
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

            <div class="col-lg-6">
                <div class="contained">
                    <h4 class="heading">Kassablad</h4>
                    <p id="responsible">Öppetansvarig:</p>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Namn</th>
                                <th>Totalt</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="openTable">
                        </tbody>
                    </table>
                    <div>
                        <button type="button" class="btn btn-primary form-control" data-toggle="modal" data-target="#signModal">Signera</button>
                        <!-- Modal -->
                        <div class="modal fade" id="signModal" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="signModalLabel">Är du säker på att du vill signera kassabladet</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Nej</button>
                                        <button id="sign" type="button" class="btn btn-primary" data-dismiss="modal">Ja</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="receiptModal" tabindex="-1" role="dialog" >
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <span id="receiptId" class="hidden"></span>
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
                        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" >
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <span id="deleteId" class="hidden"></span>
                                        <h5 class="modal-title">Är du säker på att du vill ta bort <span id="deleteName"></span></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Nej</button>
                                        <button id="delete" type="button" class="btn btn-primary" data-dismiss="modal">Ja</button>
                                    </div>
                                </div>
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
    <script src="../js/open/attendees.js"></script>
    <script src="../js/prePaid.js"></script>
    <script src="../js/paymentItems.js"></script>
    

    <script>
        var items = [
            {
                "id": 6,
                "name": "Skor",
                "price": 20,
                "item_type": "amount"
            },
            {
                "id": 7,
                "name": "Klättringsavgift",
                "price": 60,
                "price_member": 40,
                "item_type": "checkbox"
            },
            {
                "id": 8,
                "name": "Kritboll",
                "price": 50,
                "item_type": "checkbox"
            }
        ];
        var loggedInUser = undefined;
        loggedInUser = $.cookie("user");
        var openId = undefined;

        $( document ).ready(function() {
            logoutIfNotSet(loggedInUser);
            var attendees = [];
            var responsible = -1;
            var openDate = undefined;
            openId = -1;
            checkOpen(function(id, responsibleId, date) {
                openId = id;
                responsible = responsibleId;
                openDate = date;
                populateOpenTable();
            });
            var successfullyClosed = getUrlParameter("closed");
            if(successfullyClosed === "true") {
                show($("#successfullyClosed"));
            }

            handlePaymentItems();
        });

        $("#pay").click(function() {
            if(logoutIfNotSet(openId)) {
                return;
            }

            hide($("#payError"));
            var request = {
                openId: openId,
                items: []
            }
            var nameOrPnr = $("#item_pnr").val();
            if(checkPersonalNumber(nameOrPnr)) {
                request.pnr = nameOrPnr;
            } else {
                request.name = nameOrPnr;
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

            $.post( "../api/private/open/person/", JSON.stringify(request), function(response) {
                //TODO make dynamic
                var attendee = {
                    id: response.id,
                    receipt: response.receipt,
                    nameOrPnr: nameOrPnr,
                    total: 0
                };
                for(var i = 0 ; i < request.items.length  ; i++ ) {
                    attendee.total += request.items[i].price;
                }
                
                addAttendee(attendee);
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
            }, "json").fail(function(){
                show($("#payError"));
            });
        });

        $("#sign").click(function() {
            if(logoutIfNotSet(openId) || logoutIfNotSet(loggedInUser)) {
                return;
            }

            var request = {
                openId: openId,
                responsible: loggedInUser
            };
            $.post( "../api/private/open/sign/", JSON.stringify(request), function() {
                window.location = "?closed=true";
            }, "json").fail(function(response){
                alert("12" + response.responseText);
            });
        });

        $("#open_btn").click(function() {
            if(logoutIfNotSet(loggedInUser)) {
                return;
            }

            var request = {
                responsible: loggedInUser
            };
            $.post( "../api/private/open/", JSON.stringify(request), function() {
                window.location = "";
            }, "json").fail(function(response){
                alert("1" + response.responseText);
            });
        });

        $("#addPrePaid").click(function() {
            hide($("#prePaidError"));
            hide($("#tenNotFound"));
            var prePaidNumber = $("#prePaidNumber").val();
            var request;
            if(checkPersonalNumber(prePaidNumber)) {
                $.get( "../api/private/search/person/lite?pnr=" + prePaidNumber, JSON.stringify(request), handlePrePaid, "json").fail(function(response){
                    $("#prePaidNumber").val("");
                });
            } else {
                $.get( "../api/private/search/card?card=" + prePaidNumber, JSON.stringify(request), handlePrePaid, "json").fail(function(response){
                    $("#prePaidNumber").val("");
                    show($("#tenNotFound"));
                });
            }
        });

        $("#receipt").click(function() {
            request =  {
                id: $("#receiptId").html(),
                receipt: $("#receiptToken").html(),
                email: $("#receiptEmail").val(),
                type: "open"
            };
            if(request.receipt && request.id) {
                $.post( "../api/private/open/receipt/", JSON.stringify(request), function(response) {
                    show($("#receiptSuccess"));
                    hide($("#receiptError"));
                }, "json").fail(function(response){
                    hide($("#receiptSuccess"));
                    show($("#receiptError"));
                });
            } else {
                show($("#receiptError"));
            }
        });

        $("#delete").click(function() {
            request =  {
                id: $("#deleteId").html()
            };
            $.ajax({
                url: '../api/private/open/person/',
                type: 'DELETE',
                data: JSON.stringify(request),
                success: function(response) {
                    populateOpenTable();;
                },
                error: function(response) {
                    alert("13" + response.responseText);
                }
            });
        });

        function populateOpenTable() {
            $.get( "../api/private/open/person?openId=" + openId, function(response) {
                $("#openTable").html("");
                attendees = response;
                for(var i = 0 ; i < response.length ; i++) {
                    var attendee = {
                        id: -1,
                        receipt: "",
                        nameOrPnr: "",
                        total: 0
                    };
                    attendee.id = response[i].id;
                    attendee.receipt = response[i].receipt;
                    if(response[i].name && response[i].name != "") {
                        attendee.nameOrPnr = response[i].name;
                    } else {
                        attendee.nameOrPnr = response[i].pnr
                    }

                    var items = response[i].items;
                    for(var j = 0 ; j < items.length ; j++) {
                        attendee.total += items[j].price;
                    }

                    addAttendee(attendee);
                }
            }, "json").fail(function(response) {
                alert("14" + JSON.stringify(response));
            });
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
        }

        function checkOpen(callback) {
            $.get( "../api/private/open/", function(response) {
                show($("#open"));
                hide($("#closed"));
                hide($("#wrong_responsible"));
                $("#responsible").html("Öppetansvarig: " + response.responsible_name);
                callback(response.id, response.responsible, response.date);                
            }, "json").fail(function(response) {
                var error = JSON.parse(response.responseText).error;
                if(response.responseText && error === "No open") {
                    show($("#closed"));
                    hide($("#open"));
                    hide($("#wrong_responsible"));
                } else if(response.responseText && error.indexOf("Wrong responsible") > -1) {
                    show($("#wrong_responsible"));
                    hide($("#closed"));
                    hide($("#open"));
                    populateResponsibleName(error);
                } else {
                    show($("#unexpected_error"));
                }
            });
        }

        function populateResponsibleName(error) {
            var pnr = error.substring(19, error.length);
            $.get("../api/private/search/person?search=" + pnr + "&exact=1", function (response) {
                $("#wrong_responsible_name").html(response[0].name);
            }, "json").fail(function (response) {
                show($("#unexpected_error"));
            });
        }

        function doAfterShowInfo() {
            var prePaidNumber = $("#prePaidNumber").val();
            var request = {
                identification: prePaidNumber,
                openId: openId
            };
            $.post( "../api/private/open/pre/", JSON.stringify(request), function(response) {
                var attendee = {
                    id: response.id,
                    receipt: "",
                    nameOrPnr: prePaidNumber,
                    total: 0
                };                    
                addAttendee(attendee);
            }, "json").fail(function(response){
                show($("#prePaidError"));
            }); 
        }

        function cardValue(value){
            return value - 1;
        };
    </script>
</body>

</html>