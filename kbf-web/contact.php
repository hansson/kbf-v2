<?php
    include 'helpers.php';
    $config = require 'kbf.config.php';
    forceHttps($config);
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

    <link href="css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap/narrow-jumbotron.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB8fbKKpONMk_o65XT8pG-kSnEVRFyzVSY"></script>

    <script type="text/javascript">
        function initialize() {
            var kbfPos = new google.maps.LatLng(56.181358,15.593282);
            var mapOptions = {
                center: kbfPos,
                zoom: 16,
                mapTypeId: google.maps.MapTypeId.SATELLITE
            };
            var map = new google.maps.Map(document.getElementById("map-canvas"),mapOptions);
            var marker = new google.maps.Marker({
                position: kbfPos,
                map: map,
                title: 'Karlskrona Bergsportsf&ouml;rening'
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>

</head>

<body>
    <a id="switch-en" class="top-right" href="#">In english</a>
    <a id="switch-sv" class="top-right hidden" href="#">Svenska</a>
    <div class="container ">
        <div class="row content hidden-md-up">
            <div class="col-lg-12">
                <h3 class="text-muted">Karlskrona Bergsportsförening</h3>
            </div>
        </div>

        <div class="header clearfix">
            <h3 class="text-muted hidden-sm-down head-img"><img class="logo" src="img/logo.png">Karlskrona Bergsportsförening</h3>
            <nav>
                <ul class="nav nav-pills flex-column flex-sm-row">
                    <li class="nav-item">
                        <a class="nav-link sv" href="index.php">Hem</a>
                        <a class="nav-link en hidden" href="index.php">Home</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link sv"  href="prices.php">Priser</a>
                        <a class="nav-link en hidden" href="prices.php">Prices</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link sv" href="member.php">Medlem</a>
                        <a class="nav-link en hidden" href="member.php">Member</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active sv" href="#">Kontakt<span class="sr-only">(Aktiv)</span></a>
                        <a class="nav-link active en hidden" href="#">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link sv" href="admin/login.php">Logga in</a>
                        <a class="nav-link en hidden" href="admin/login.php">Login</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row content">
            <div class="col-lg-6">
                <h4 class="sv">Hitta hit</h4>
                <p class="sv">Ni hittar oss på andra våningen i idrottshallen vid BTH. Ingång på kortsidan.</p>
                <h4 class="en hidden">How to get here</h4>
                <p class="en hidden">You can find us on the second floor of the gym next to BTH. Entrance on the short side of the house.</p>
                <div id="map-canvas" style="height: 300px;"><span class="sr-only">Karta till klubben</span></div>
            </div>

            <div class="col-lg-6">
                <h4 class="sv">Kontakt</h4>
                <p class="sv">Det lättaste sättet att komma i kontakt med oss är på vår <a href="https://www.facebook.com/karlskronabergsport">Facebook-sida</a>, skriv ett meddelande så svarar vi så fort vi kan.</p>
                <p class="sv">Det går också att nå oss på <b>kontakt@karlskronabergsport.se</b> för generella frågor, och <b>kurser@karlskronabergsport.se</b> om du vill ha information om någon av våra barngrupper eller övriga kurser.</p>
                <h4 class="en hidden">Contact</h4>
                <p class="en hidden">The easiest way to get in contact with us is on our <a href="https://www.facebook.com/karlskronabergsport">Facebook page</a>, write us a message and we'll answer as soon as we can.</p>
                <p class="en hidden">You can also reach us on <b>kontakt@karlskronabergsport.se</b> for general questions, and <b>kurser@karlskronabergsport.se</b> if you want to have information about our youth groups or other courses.</p>
            </div>
        
        </div>

        <footer class="footer">
            <p>&copy; Karlskrona Bergsportsförening 2017</p>
        </footer>
        
    </div>

    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="js/bootstrap/bootstrap.js"></script>
    <script src="js/bootstrap/ie10-viewport-bug-workaround.js"></script>
    <script src="js/jquery.cookie.js"></script>
    <script src="js/helpers.js"></script>
    <script>
        initi18n();
    </script>
</body>
</html>