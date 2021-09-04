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
                        <a class="nav-link sv" href="member.php">Medlem</a>
                        <a class="nav-link en hidden" href="member.php">Member</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link sv" href="contact.php">Kontakt</span></a>
                        <a class="nav-link en hidden" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active sv" href="#">Vanliga frågor<span class="sr-only">(Aktiv)</span></a>
                        <a class="nav-link active en hidden" href="#">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link sv" href="admin/login.php">Logga in</a>
                        <a class="nav-link en hidden" href="admin/login.php">Login</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row content">
            <div class="col-lg-12">
                <h4 class="sv">Vanliga frågor</h4>
                <h4 class="en hidden">FAQ</h4>
                 <ul class="sv">
                    <li><b>Hur gör jag om jag aldrig har klättrat tidigare?</b> På vår klubb håller vi på med bouldering, som är klättring på låga väggar med mattor som skydd. Du behöver därför
                    inga speciella kunskaper för att klättra hos oss. Om du vill testa på att klättra är du välkommen till våra drop-in tider (som du kan se i vår kalender som "Öppet"). På de flesta
                    drop-in tider har vi en bra blandning av nybörjare och mer erfarna klättrare.</li>
                    <li><b>Har ni några åldersgräner?</b> På vår drop-in är det 10 år och uppåt som gäller, är man under 15 måste man ha en en vuxen med sig. Vi har i dagsläget brist på frivilliga som 
                    kan hålla öppet och vi har därför inte något tillfälle för barn under 10 år</li>
                </ul>
                 <ul class="en hidden">
                    <li><b>I've never climbed before, what do I do?</b> In our club we aminly focus on bouldering. Bouldering is climbing on low walls with mattresses as protection. This means that you
                    do not need to have any previous knowledge to be able to climb with us. If you want to try climbing then you are welcome to our drop-in, times can be found in the calendar as "Öppet".</li>
                    <li><b>Do you have any age restrictions?</b> On our drop-in you need to be 10 years or older to climb, if you are under 15 you need to be in company with an adult.</li>
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