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
                        <a class="nav-link active sv" href="#">Medlem<span class="sr-only">(Aktiv)</span></a>
                        <a class="nav-link active en hidden" href="#">Member</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link sv" href="contact.php">Kontakt</a>
                        <a class="nav-link en hidden" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link sv" href="faq.php">Vanliga frågor</a>
                        <a class="nav-link en hidden" href="faq.php">FAQ</a>
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
                <h4 class="sv">Medlem</h4>
                <p class="sv">
                    Som medlem i Karlskrona Bergsportsförening får du tillgång till rabatterade priser på våra klätteravgifter
                    och du får också möjligheten att köpa våra träningskort som gäller för en termin eller för resten av året.
                </p>
                <p class="sv">
                    När du blir medlem hos oss blir du dessutom ansluten till Svenska Klätterförbundet vilket bland annat ger dig tillgång till deras klätterförsäkring och tidningen Bergsport. Mer information finns på denna <a href="http://bergsport.se/klatterforbundet/medlemskap/bli-klubbmedlem/">länk</a>
                </p>

                <p class="sv"> 
                    En medlemsavgift hos oss(och även våra träningskort) gäller för kalenderår. Så tänk på att du alltid behöver
                    förnya ditt medlemskap och träningskort i början av året, eller i början av terminen om du köper terminskort.
                </p>

                <h4 class="en hidden">Member</h4>
                <p class="en hidden">
                    As a member in Karlskrona Bergsportsförening you get access to our discount prices on climbing fees and you will
                    also get the opportunity to purchase our traning fees that are valid for a single semester or for the rest of the year.
                </p>
                <p class="en hidden">
                    When you become a member you will automatically be connected to the Swedish climbing association. This will give you 
                    access to their climbing insurance and the climbing magazine "Bergsport". More information on <a href="http://bergsport.se/klatterforbundet/medlemskap/bli-klubbmedlem/">Bergsport.se</a>
                </p>

                <p class="en hidden">
                    A membership fee(as well as the training fees) are valid for a calendar year. So remember that you always need to renew your
                    membership and training fee in the start of the year, or in the start of the semester if you are buying the single semester card.
                </p>
            </div>

            <div class="col-lg-6">
                <h4 class="sv">Hur blir jag medlem?</h4>
                <p class="sv">När du bestämt dig för att bli medlem i Karlskrona Bergsportsförening så behöver du följa nedastående steg:</p>
                <ul class="sv">
                    <li>Registrera dig <a href="admin/register.php">här</a> på vår hemsida</li>
                    <li>Betala in medlemsavgiften till PlusGiro, 835 43 78-5 eller Swish 123 265 84 41, skriv ditt personnummer och namn som meddelande</li>
                    <li>Om du ska köpa träningskort går detta också bra att betala in på vårt PlusGiro/Swish. Märk även detta med personnummer och namn</li>
                    <li>Om du har gjort din betalning via PlusGiro, ta med bevis på betalningen vid nästa öppettillfälle eller skicka ett mail till kontakt@karlskronabergsport.se</li>
                </ul>

                <h4 class="en hidden">How do I become a member?</h4>
                <p class="en hidden">When you have decided to become a member you need to follow the steps below:</p>
                <ul class="en hidden">
                    <li>Register <a href="admin/register.php">here</a> on our website</li>
                    <li>Pay the membership fee to PlusGiro, 835 43 78-5 or Swish 123 265 84 41, write your civic number and name as the message</li>
                    <li>If you want to buy a training fee, this can be paid to the PlusGiro/Swish account as well. Mark it with civic number and name</li>
                    <li>If your payment was made with PlusGiro,  bring proof of payment to the next open session or send an email to kontakt@karlskronabergsport.se</li>
                </ul>
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