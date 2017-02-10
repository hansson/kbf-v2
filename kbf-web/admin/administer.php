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
                        <a class="nav-link" href="index.php">Öppna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Registrera<span class="sr-only">(Aktiv)</span></a>
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

        <div id="open" class="row content">
            <div class="col-lg-6">
                <div class="contained">
                    <h5 class="heading">Lägg till avgift</h5>
                    <div>
                        <div class="form-group">
                            <input id="item_pnr" class="form-control" type="text" placeholder="Medlemsnummer">
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
                                    <span class="custom-control-description">Årskort</span>
                                </label>
                            </div>

                            <div class="form-check">
                                <label class="custom-control custom-checkbox">
                                    <input id="item_3" type="checkbox" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Terminskort</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="custom-control custom-checkbox">
                                    <input id="item_4" type="checkbox" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">10-kort</span>
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
                    <h5 class="heading">Sök användare</h5>
                    <div>
                        <div class="form-group">
                            <input id="prePaidNumber" class="form-control" type="text" placeholder="Födelsedatum">
                        </div>
                        <button id="addPrePaid" type="button" class="btn btn-primary form-control">Sök</button>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Medlemsnummer</th>
                                <th>Namn</th>
                                <th>E-post</th>
                            </tr>
                        </thead>
                        <tbody id="openTable">
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="contained">
                    <h5 class="heading">Aktivera användare</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Medlemsnummer</th>
                                <th>Namn</th>
                                <th>Godkänn</th>
                                <th>Neka</th>
                            </tr>
                        </thead>
                        <tbody id="personTable">
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
        populatePersonTable();


        function populatePersonTable() {
            $.get( "../api/private/inactive", function(response) {
                for(var i = 0 ; i < response.length ; i++) {
                    addPerson(response[i]);
                }
            }, "json").fail(function(response) {
                alert(response);
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

            })

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

            })
        }
    </script>
</body>

</html>