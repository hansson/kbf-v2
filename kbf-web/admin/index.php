<?php
    include '../helpers.php';
    $config = require '../kbf.config.php';
    session_start();
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
        <div class="header clearfix">
            <nav>
                <ul class="nav nav-pills float-right">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Öppna <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="administer.php">Registrera</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Kontrollera</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="my_info.php">Min info</a>
                    </li>
                </ul>
            </nav>

            <a href="../index.php"><h3 class="text-muted"><img class="logo" src="../img/logo.png">Karlskrona Bergsportsförening</h3></a>
        </div>
        <div id="unexpected_error" class="alert alert-danger hidden" role="alert">
            <strong>Ett oväntat fel inträffade! Var vänlig försök igen, om felet kvarstår, kontakta webbansvarig.</strong>
        </div>
        <div id="closed" class="row content hidden">
            <div class="col-lg-12 contained">
                <div>
                    <h5 class="heading">Hittade inget öppet kassablad!</h5>
                    <div>
                        <button id="open_btn" type="button" class="btn btn-primary">Öppna</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="open" class="row content hidden">
            <div class="col-lg-6">
                <div class="contained">
                    <h5 class="heading">Lägg till engångsavgifter</h5>
                    <div>
                        <p>Använd födelsedatum om det är en medlem som betalar, annars skriv namn.</p>
                        <div class="form-group">
                            <input id="item_pnr" class="form-control" type="text" placeholder="Namn eller födelsedatum">
                        </div>
                        <div class="form-group">
                            <input id="item_1" class="form-control" type="number" placeholder="Antal Skor">
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <label class="custom-control custom-checkbox">
                                    <input id="item_2" type="checkbox" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Klättringsavgift</span>
                                </label>
                            </div>

                            <div class="form-check">
                                <label class="custom-control custom-checkbox">
                                    <input id="item_3" type="checkbox" class="custom-control-input">
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
                            <input id="prePaidNumber" class="form-control" type="text" placeholder="Medlemsnummer / kortnummer">
                        </div>
                        <button id="addPrePaid" type="button" class="btn btn-primary form-control">Lägg till</button>
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

            <div class="col-lg-6">
                <div class="contained">
                    <h4 class="heading">Kassablad</h4>
                    <p id="responsible">Öppetansvarig:</p>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Namn</th>
                                <th>Skor</th>
                                <th>Klättringsavgift</th>
                                <th>Kritboll</th>
                            </tr>
                        </thead>
                        <tbody id="openTable">
                        </tbody>
                    </table>
                    <div>
                        <button type="button" class="btn btn-primary form-control" data-toggle="modal" data-target="#signModal">Signera</button>
                        <!-- Modal -->
                        <div class="modal fade" id="signModal" tabindex="-1" role="dialog" aria-labelledby="signModalLabel" aria-hidden="true">
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
        var items = [
            {
                "id": 1,
                "name": "Skor",
                "price": 20,
                "type": "amount"
            },
            {
                "id": 2,
                "name": "Klättringsavgift",
                "price": 50,
                "price_member": 40,
                "type": "checkbox"
            },
            {
                "id": 3,
                "name": "Kritboll",
                "price": 50,
                "type": "checkbox"
            }
        ];

        var loggedInUser = $.cookie("user");
        var openId = -1;
        var attendees = [];
        var responsible = -1;
        var openDate = undefined;
        checkOpen(function(id, responsibleId, date) {
            openId = id;
            responsible = responsibleId;
            openDate = date;
            populateOpenTable();
        });

        $("input[id^='item_']").change(function() {
            //Recalculate price
            var total = 0;
            var nameOrPersonalNumber = $("#item_pnr").val();
            var member = false;
            if(checkPersonalNumber(nameOrPersonalNumber)) {
                member = true;
            }
            for(var i = 0 ; i < items.length ; i++) {
                var item = items[i];
                var html_item = $("#item_" + item.id);
                if(item.type === "checkbox" && html_item.is(":checked")) {
                    if(item.price_member && member) {
                        total += item.price_member;
                    } else {
                        total += item.price;
                    }
                } else if(item.type === "amount" && html_item.val() > 0) {
                    if(html_item.val() > 100) {
                        html_item.val(0);
                    } else {
                        if(item.price_member && member) {
                            total += item.price_member * html_item.val();
                        } else {
                            total += item.price * html_item.val();
                        }
                    }
                }
            }
            $("#total").html("Totalt: " + total + " kr");
        });

        $("#pay").click(function() {
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
                if(item.type == "checkbox") {
                    var requestItem = itemFromCheckbox($("#item_" + item.id), item, request);
                    if(requestItem) {
                        request.items.push(requestItem);
                    }
                } else if(item.type == "amount") {
                    request.items = request.items.concat(itemsFromAmount($("#item_" + item.id), item, request));
                }
            }

            $.post( "../api/private/open/person/", JSON.stringify(request), function(response) {
                //TODO make dynamic
                var attendee = {
                    id: response.id,
                    nameOrPnr: nameOrPnr,
                    shoes: 0,
                    climbingFee: "",
                    chalk: ""
                };
                for(var i = 0 ; i < request.items.length  ; i++ ) {
                    if(request.items[i].name === "Skor") {
                        attendee.shoes = attendee.shoes + 1;
                    } else if(request.items[i].name === "Klättringsavgift") {
                        attendee.climbingFee = "X"
                    } else if(request.items[i].name === "Kritboll") {
                        attendee.chalk = "X"
                    }
                }
                
                addAttendee(attendee);
                for(var i = 0 ; i < items.length ; i++) {
                    var item = items[i];
                    var html_item = $("#item_" + item.id);
                    if(item.type === "checkbox" && html_item.is(":checked")) {
                        html_item.prop('checked', false);
                    } else if(item.type === "amount" && html_item.val() > 0) {
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
            var request = {
                openId: openId,
                responsible: loggedInUser
            };
            $.post( "../api/private/open/sign/", JSON.stringify(request), function() {
                window.location = "";
            }, "json").fail(function(response){
                alert(response.responseText);
            });
        });

        $("#open_btn").click(function() {
            var request = {
                responsible: loggedInUser
            };
            $.post( "../api/private/open/", JSON.stringify(request), function() {
                window.location = "";
            }, "json").fail(function(response){
                alert(response.responseText);
            });
        });

        $("#addPrePaid").click(function() {
            var prePaidNumber = $("#prePaidNumber").val();
            var request;
            if(checkPersonalNumber(prePaidNumber)) {
                $.get( "../api/private/info/lite?pnr=" + prePaidNumber, JSON.stringify(request), handlePrePaid, "json").fail(function(response){
                    $("#prePaidNumber").val("");
                    alert(response.responseText);
                });
            } else {
                $.get( "../api/private/info/lite?card=" + prePaidNumber, JSON.stringify(request), handlePrePaid, "json").fail(function(response){
                    $("#prePaidNumber").val("");
                    alert(response.responseText);
                });
            }
        });

        function populateOpenTable() {
            $.get( "../api/private/open/person?openId=" + openId, function(response) {
                attendees = response;
                for(var i = 0 ; i < response.length ; i++) {
                    var attendee = {
                        id: -1,
                        nameOrPnr: "",
                        shoes: 0,
                        climbingFee: "",
                        chalk: ""
                    };
                    attendee.id = response[i].id;
                    if(response[i].name && response[i].name != "") {
                        attendee.nameOrPnr = response[i].name;
                    } else {
                        attendee.nameOrPnr = response[i].pnr
                    }

                    var items = response[i].items;
                    for(var j = 0 ; j < items.length ; j++) {
                        if(items[j].name === "Skor") {
                            attendee.shoes++;
                        } else if(items[j].name === "Klättringsavgift") {
                            attendee.climbingFee = "X"
                        } else if(items[j].name === "Kritboll") {
                            attendee.chalk = "X"
                        }
                    }

                    addAttendee(attendee);
                }
            }, "json").fail(function(response) {
                alert(response);
            });
        }

        function addAttendee(attendee) {
            var row = "<tr id=\"attendee_" + attendee.id + "\">";
            row += "<td>" + attendee.nameOrPnr + "</td>";
            row += "<td>" + attendee.shoes + "</td>";
            row += "<td>" + attendee.climbingFee + "</td>";
            row += "<td>" + attendee.chalk + "</td>";
            row += "</tr>";
            $("#openTable").append(row);
        }

        function handlePrePaid(response) {
            resetPersonInfo();
            var triggerNextStep = false;
            if(response.feeValid && response.feeValid != "-") {
                show($("#climb"));
                if(runningOutDate(response.feeValid)) {
                    show($("#personInfoAttentionClimb"));
                } else {
                    show($("#personInfoClimb"));
                }
                triggerNextStep = true;
                $("#personInfoClimbUntil").html(response.feeValid);
            } else if(response.left && response.left != "-") {
                show($("#ten"));
                if(response.left == 0) {
                    show($("#personInfoNoTen"));
                    $("#personInfoTenUntil").html(0);
                } else if(runningOutCard(response.left)) {
                    show($("#personInfoAttentionTen"));
                    $("#personInfoTenUntil").html(response.left - 1);
                    triggerNextStep = true;
                } else {
                    show($("#personInfoTen"));
                    $("#personInfoTenUntil").html(response.left - 1);
                    triggerNextStep = true;
                }
            } else {
                show($("#climb"));
                show($("#personInfoNoClimb"));
                $("#personInfoClimbUntil").html("Ingen giltig betalning");
            }

            if(response.memberValid) {
                show($("#member"));
                if(response.memberValid == "-") {
                    show($("#personInfoNoMember"));
                } else if(runningOutDate(response.memberValid)) {
                    show($("#personInfoAttentionMember"));
                } else {
                    show($("#personInfoMember"));
                }
                $("#personInfoMemberUntil").html(response.memberValid);
            }

            if(triggerNextStep) {
                var prePaidNumber = $("#prePaidNumber").val();
                var request = {
                    identification: prePaidNumber,
                    openId: openId
                };
                $.post( "../api/private/open/pre/", JSON.stringify(request), function(response) {
                    var attendee = {
                        id: response.id,
                        nameOrPnr: prePaidNumber,
                        shoes: 0,
                        climbingFee: "",
                        chalk: ""
                    };                    
                    addAttendee(attendee);
                }, "json").fail(function(response){
                    alert(response.responseText);
                }); 
            }

            $("#prePaidNumber").val("");
        }

        function resetPersonInfo() {
            //Ten
            hide($("#ten"));
            hide($("#personInfoNoTen"));
            hide($("#personInfoAttentionTen"));
            hide($("#personInfoTen"));
            //Climb
            hide($("#climb"));
            hide($("#personInfoNoClimb"));
            hide($("#personInfoAttentionClimb"));
            hide($("#personInfoClimb"));
            //Member
            hide($("#member"));
            hide($("#personInfoNoMember"));
            hide($("#personInfoAttentionMember"));
            hide($("#personInfoMember"));
        }

        function itemFromCheckbox(checkbox, item, request) {
            var requestItem = undefined;
            if(checkbox.is(":checked")) {
                requestItem = getRequestItem(item,request);
            }
            return requestItem;
        }

        function itemsFromAmount(amount, item, request) {
            var items = [];
            for(var i = 0 ; i < amount.val() ; i++) {
                items.push(getRequestItem(item,request));
            }
            return items;
        }

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
        }

        function checkOpen(callback) {
            $.get( "../api/private/open/", function(response) {
                show($("#open"));
                hide($("#closed"));
                $("#responsible").html("Öppetansvarig: " + response.responsible_name);
                callback(response.id, response.responsible, response.date);                
            }, "json").fail(function(response) {
                if(response.responseText && JSON.parse(response.responseText).error === "No open") {
                    show($("#closed"));
                    hide($("#open"));
                } else {
                    show($("#unexpected_error"));
                }
            });
        }
    </script>
</body>

</html>