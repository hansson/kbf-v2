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
                        getHeader("register_fee");
                    ?>
                </ul>
            </nav>
        </div>

        <div class="row content">
            <div class="col-lg-6">
                <div class="contained">
                    <h5 class="heading">Lägg till avgift</h5>
                    <div>
                        <div id="paySuccess" class="alert alert-success hidden" role="alert">
                            <strong>Köp genomfört för <span id="payReference"></span>!</strong>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <label class="custom-control custom-checkbox" id="label_for_item_1">
                                    <input id="item_1" type="checkbox" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Medlemsavgift</span>
                                </label>
                            </div>

                            <div class="form-check">
                                <label class="custom-control custom-checkbox" id="label_for_item_2">
                                    <input id="item_2" type="checkbox" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Medlemsavgift (0-17 år)</span>
                                </label>
                            </div>

                            <div class="form-check">
                                <label class="custom-control custom-checkbox" id="label_for_item_3">
                                    <input id="item_3" type="checkbox" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Årskort</span>
                                </label>
                            </div>

                            <div class="form-check">
                                <label class="custom-control custom-checkbox" id="label_for_item_4">
                                    <input id="item_4" type="checkbox" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Terminskort</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="custom-control custom-checkbox" id="label_for_item_5">
                                    <input id="item_5" type="checkbox" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">10-kort (Endast medlemmar!)</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="custom-control custom-checkbox" id="label_for_item_9">
                                    <input id="item_9" type="checkbox" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Årskort (barn)</span>
                                </label>
                            </div>

                            <div class="form-check">
                                <label class="custom-control custom-checkbox" id="label_for_item_10">
                                    <input id="item_10" type="checkbox" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Terminskort (barn)</span>
                                </label>
                            </div>
                        </div>


                        <div class="form-group">
                            <input id="item_mem_nr" class="form-control" type="text" placeholder="Medlemsnummer" inputmode="numeric" autocomplete="off">
                        </div>

                        <div id="pnr_group" class="form-group hidden">
                            <input id="item_pnr" class="form-control" type="text" placeholder="Personnummer" inputmode="numeric" autocomplete="off">
                        </div>

                        <div id="name_group" class="form-group hidden">
                            <input id="item_name" class="form-control" type="text" placeholder="Namn" autocomplete="off">
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
                        <div id="memberError" class="alert alert-danger hidden" role="alert">
                            <strong>Ej medlem!</strong>
                        </div>
                        <div id="pnrError" class="alert alert-danger hidden" role="alert">
                            <strong>Personnummer saknas!</strong>
                        </div>
                        <div id="duplicateFeeError" class="alert alert-danger hidden" role="alert">
                            <strong>Medlemen har redan betalt denna avgift!</strong>
                        </div>
                        <div id="couldNotFindUser" class="alert alert-danger hidden" role="alert">
                            <strong>Kunde inte hitta någon medlem med det angivna medlemsnumret.</strong>
                        </div>
                        <div id="missingMemberId" class="alert alert-danger hidden" role="alert">
                            <strong>Du måste ange medlemsnummer.</strong>
                        </div>
                        <div id="badTmpPnr" class="alert alert-danger hidden" role="alert">
                            <strong>Personnummer har minst 10 siffror.</strong>
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
    <script src="../js/paymentItems.js"></script>
    

    <script>
        var loggedInUser = $.cookie("user");
        logoutIfNotSet(loggedInUser);

        var items = [
            {
                "id": 1,
                "name": "Medlemsavgift",
                "price": 250,
                "item_type": "checkbox",
                show_pnr: true,
            },
            {
                "id": 2,
                "name": "Medlemsavgift (0-17 år)",
                "price": 150,
                "item_type": "checkbox",
                show_pnr: true,
            },
            {
                "id": 3,
                "name": "Årskort klättring",
                "price": 800,
                "item_type": "checkbox"
            },
            {
                "id": 4,
                "name": "Terminskort klättring",
                "price": 500,
                "item_type": "checkbox"
            },
            {
                "id": 5,
                "name": "10-kort",
                "price": 300,
                "item_type": "checkbox",
                show_name: false,
            },
            {
                "id": 9,
                "name": "Årskort (barn)",
                "price": 600,
                "item_type": "checkbox"
            },
            {
                "id": 10,
                "name": "Terminskort (barn)",
                "price": 400,
                "item_type": "checkbox"
            }
        ];
        
        items.forEach(item => {
            $("#label_for_item_" + item.id).click(e => {
                e.preventDefault();
                e.stopPropagation();

                item.checked = !item.checked;

                $("#item_" + item.id).prop("checked", item.checked);

                if (items.some(item => item.show_pnr && item.checked)) {
                    show($("#pnr_group"));
                } else {
                    hide($("#pnr_group"));
                }

                if (items.some(item => item.show_name && item.checked)) {
                    show($("#name_group"));
                } else {
                    hide($("#name_group"));
                }

                const memberNumber = $("#item_mem_nr").val();
                const member = checkPersonalNumber(memberNumber);

                const totalPrice = items.reduce((sum, item) => {
                    const price = item.price_member && member
                        ? item.price_member
                        : item.price;

                    return item.checked ? sum + price : sum;
                }, 0);

                $("#total").html("Totalt: " + totalPrice + " kr");
            });
        });

        $("#pay").click(function() {
            if(logoutIfNotSet(loggedInUser)) {
                return;
            }
            hide($("#memberError"));
            hide($("#pnrError"));
            hide($("#payError"));
            hide($("#duplicateFeeError"));
            hide($("#couldNotFindUser"));
            hide($("#missingMemberId"));
            hide($("#badTmpPnr"));
            
            hide($("#paySuccess"));
            var request = {
                signed: loggedInUser,
                items: []
            }
            const memberNumber = $("#item_mem_nr").val();
            if(checkPersonalNumber(memberNumber)) {
                request.pnr = memberNumber;
            }
            var tmpPnr = $("#item_pnr").val();
            if(tmpPnr != "") {
                request.tmp = tmpPnr;
            }

            request.name = $("#item_name").val();

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

                items.forEach(item => {
                    $("#item_" + item.id).prop("checked", false);
                    item.checked = false;
                })

                $("#total").html("Totalt: 0 kr");
                $("#item_mem_nr").val("");
                $("#item_pnr").val("");
                $("#item_name").val("");
            }, "json").fail(function(response) {
                if(response.responseText.indexOf("Not a member") != -1) {
                    show($("#memberError"));
                } else if(response.responseText.indexOf("Missing parameter tmp_pnr") != -1) {
                    show($("#pnrError"));
                } else if(response.responseText.indexOf("Duplicate fee") != -1) {
                    show($("#duplicateFeeError"));
                } else if(response.responseText.indexOf("Could not find user") != -1) {
                    show($("#couldNotFindUser"));
                } else if(response.responseText.indexOf("Missing member id") != -1) {
                    show($("#missingMemberId"))
                } else if(response.responseText.indexOf("Bad tmp_pnr") != -1){
                    show($("#badTmpPnr"))
                }else {
                    show($("#payError"));
                }
            });
        });

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