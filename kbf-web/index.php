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
                        <a class="nav-link active sv" href="#">Hem <span class="sr-only">(Aktiv)</span></a>
                        <a class="nav-link active en hidden" href="#">Home</a>
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
                        <a class="nav-link sv" href="contact.php">Kontakt</a>
                        <a class="nav-link en hidden" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link sv" href="admin/login.php">Logga in</a>
                        <a class="nav-link en hidden" href="admin/login.php">Login</a>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="row content">
            <div id="facebook-container" class="col-lg-6">
                    <iframe
                    src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FKarlskrona-Bergsportsf%25C3%25B6rening%2F135038336545237&amp;height=590&amp;width=600&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=true&amp;show_border=true&amp;appId=264286240383714"
                    style="border: none; overflow: hidden; width: 600px; height: 600px;" class="hidden-sm-down"></iframe>
                    <iframe id="facebook-iframe"
                    src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FKarlskrona-Bergsportsf%25C3%25B6rening%2F135038336545237&amp;height=590&amp;width=280&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=true&amp;show_border=true&amp;appId=264286240383714"
                    style="border: none; overflow: hidden; width: 280px; height: 600px; display: block" class="hidden-md-up mx-auto"></iframe>
            </div>
            <div class="col-lg-6">
                <iframe src="https://www.google.com/calendar/embed?showTitle=0&amp;showDate=0&amp;showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;showTz=0&amp;mode=AGENDA&amp;height=600&amp;wkst=2&amp;bgcolor=%23FFFFFF&amp;src=karlskronabergsport%40gmail.com&amp;color=%23125A12&amp;ctz=Europe%2FStockholm"
                    style="border-width: 0; width: 100%; height: 600px; overflow: none;"></iframe>
            </div>

        </div>

        <footer class="footer">
            <p>&copy; Karlskrona Bergsportsförening 2017</p>
        </footer>
        
    </div>

    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/jquery.cookie.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="js/bootstrap/bootstrap.js"></script>
    <script src="js/bootstrap/ie10-viewport-bug-workaround.js"></script>
    <script src="js/helpers.js"></script>

    <script>
        initi18n();
    </script>

</body>

</html>