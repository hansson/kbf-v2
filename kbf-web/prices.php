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
                        <a class="nav-link sv active"  href="#">Priser<span class="sr-only">(Aktiv)</span></a>
                        <a class="nav-link en active hidden" href="#">Prices</a>
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
                <div class="contained">
                <div>
                    <h2>Drop-in</h2>
                    <p class="sv">Vänligen notera att på klubben kan du betala med kontanter eller Swish</p>
                    <p class="en hidden">Please not that we allow payments with cash or Swish only</p>
                </div>
                <div>
                    <h4 class="sv">Avgifter</h4>
                    <h4 class="en hidden">Fees</h4>
                    <table class="table">
                        <tbody>
                            <tr class="sv">
                                <td>Engångsavgift (1 barn under 10 år gratis med betalande vuxen)</td>
                                <td>60 kr</td>
                            </tr>
                            <tr class="sv">
                                <td>Skohyra</td>
                                <td>20 kr</td>
                            </tr>
                            <tr class="sv">
                                <td>Kritboll</td>
                                <td>40 kr</td>
                            </tr>
                            <tr class="sv">
                                <td>T-shirt</td>
                                <td>325 kr</td>
                            </tr>
                            <tr class="en hidden">
                                <td>Single entry (1 child under 10 free with paying adult)</td>
                                <td>60 SEK</td>
                            </tr>
                            <tr class="en hidden">
                                <td>Rent shoes</td>
                                <td>20 SEK</td>
                            </tr>
                            <tr class="en hidden">
                                <td>Chalk ball</td>
                                <td>40 SEK</td>
                            </tr>
                            <tr class="en hidden">
                                <td>T-shirt</td>
                                <td>325 SEK</td>
                            </tr>
                        </tbody>
                    </table>

                    <h4 class="sv">Medlemmar</h4>
                    <h4 class="en hidden">Members</h4>
                    <table class="table">
                        <tbody>
                            <tr class="sv">
                                <td>Engångsavgift (1 barn under 10 år gratis med betalande vuxen)</td>
                                <td>40 kr</td>
                            </tr>
                            <tr class="sv">
                                <td>10-kort</td>
                                <td>300 kr</td>
                            </tr>
                            <tr class="sv">
                                <td>Klättringsavgift (Termin)</td>
                                <td>500 kr</td>
                            </tr>
                            <tr class="sv">
                                <td>Klättringsavgift (Kalenderår)</td>
                                <td>800 kr</td>
                            </tr>
                            <tr class="sv">
                                <td>Medlemsavgift (till 18 år)</td>
                                <td>150 kr</td>
                            </tr>
                            <tr class="sv">
                                <td>Medlemsavgift (18 år och upp)</td>
                                <td>250 kr</td>
                            </tr>
                            <tr class="en hidden">
                                <td>Single entry (1 child under 10 free with paying adult)</td>
                                <td>40 SEK</td>
                            </tr>
                            <tr class="en hidden">
                                <td>10-card</td>
                                <td>300 SEK</td>
                            </tr>
                            <tr class="en hidden">
                                <td>Climbing pass (Semester)</td>
                                <td>500 SEK</td>
                            </tr>
                            <tr class="en hidden">
                                <td>Climbing pass (Calendar year)</td>
                                <td>800 SEK</td>
                            </tr>
                            <tr class="en hidden">
                                <td>Membership fee (Children)</td>
                                <td>150 SEK</td>
                            </tr>
                            <tr class="en hidden">
                                <td>Membership fee (18 years and up)</td>
                                <td>250 SEK</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="contained">
                    <div>
                        <h2 class="sv">Kurser</h2>
                        <h2 class="en hidden">Courses </h2>
                    </div>
                    <div>
                        <p class="sv">
                            Skulle ni vilja ha er klättring instruktörsledd så kan vi erbjuda detta vid förfrågan. Rekommenderad storlek på grupper är 5-10 men vi kan ofta lösa större grupper med. Kontakta kontakt@karlskronabergsport.se för frågor och bokning.
                        </p>
                        <p class="en hidden">
                            If you would like an instructor with you while climbing then we can offer you instructor led climbing in our climbing hall or on one of Blekinges many
                            cliffs. Recommended size of groups are 5-10 persons, but we can often solve bigger groups as well. Please contact kontakt@karlskronabergsport.se for questions and booking.
                        </p>
                        <table class="table">
                            <tbody>
                                <tr class="sv">
                                    <td>Inomhus</td>
                                    <td>150 kr/person</td>
                                </tr>
                                <tr class="en hidden">
                                    <td>Indoor</td>
                                    <td>150 SEK/person</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <h2 class="sv">Prova på klippklättring</h2>
                        <h2 class="en hidden">Try outdoors rock climbing </h2>
                    </div>
                    <div>
                        <p class="sv">
                        Vill ni prova på topprepsklättring så kan vi erbjuda den möjligheten på en av våra klippor i Karlskrona. 
                        Riktar sig till er som aldrig har klättrat och vill prova på, eller er som klättrat inomhus och vill testa på repklättring 
                        utomhus. Maila kontakt@karlskronabergsport.se för frågor och bokning.
                        </p>
                        
                        <p class="en hidden">
                            If you would like to try top-rope climbing outdoors we can provide this on one if our cliffs in Karlskrona. 
                            This is primarily for people that have never climbed before or if you have never tried to climb outdoors on a clif.
                            Send an e-mail to kontakt@karlskronabergsport.se for any questions and booking.
                        </p>
                        <table class="table">
                            <tbody>
                                <tr class="sv">
                                    <td>Max storlek</td>
                                    <td>10 personer</td>
                                </tr>
                                <tr class="en hidden">
                                    <td>Max size</td>
                                    <td>10 persons</td>
                                </tr>

                                <tr class="sv">
                                    <td>Åldersgräns</td>
                                    <td>Året ni fyller 11. Vuxet sällskap behövs om ni är under 18.</td>
                                </tr>
                                <tr class="en hidden">
                                    <td>Age limit</td>
                                    <td>The year you become 11. Adult suppervision required until the age of 18.</td>
                                </tr>

                                <tr class="sv">
                                    <td>Pris</td>
                                    <td>300kr/person</td>
                                </tr>
                                <tr class="en hidden">
                                    <td>Price</td>
                                    <td>300kr/person</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer">
            <p>&copy; Karlskrona Bergsportsförening <?php echo date("Y"); ?></p>
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