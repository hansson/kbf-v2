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
                </div>
                <div>
                    <h4 class="sv">Avgifter</h4>
                    <h4 class="en hidden">Fees</h4>
                    <table class="table">
                        <tbody>
                            <tr class="sv">
                                <td>Engångsavgift (2 barn gratis med betalande vuxen)</td>
                                <td>60 kr</td>
                            </tr>
                            <tr class="sv">
                                <td>Skohyra</td>
                                <td>20 kr</td>
                            </tr>
                            <tr class="sv">
                                <td>Kritboll</td>
                                <td>50 kr</td>
                            </tr>
                            <tr class="en hidden">
                                <td>Single entry (2 children free with paying adult)</td>
                                <td>60 SEK</td>
                            </tr>
                            <tr class="en hidden">
                                <td>Rent shoes</td>
                                <td>20 SEK</td>
                            </tr>
                            <tr class="en hidden">
                                <td>Chalk ball</td>
                                <td>50 SEK</td>
                            </tr>
                        </tbody>
                    </table>

                    <h4 class="sv">Medlemmar</h4>
                    <h4 class="en hidden">Members</h4>
                    <table class="table">
                        <tbody>
                            <tr class="sv">
                                <td>Engångsavgift (2 barn gratis med betalande vuxen)</td>
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
                                <td>Single entry (2 children free with paying adult)</td>
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

            <div class="col-lg-6 ">
                <div class="contained">
                <div>
                    <h2 class="sv">Kurser</h2>
                    <h2 class="en hidden">Courses </h2>
                </div>
                <div>
                    <h3 class="sv">Barn- och ungdomsgrupper</h3>
                    <p class="sv">Vi har flera grupper för barn och ungdomar upp till 15-års ålder. För frågor och anmälan kontakta kontakt@karlskronabergsport.se.</p>
                    <h3 class="en hidden">Youth groups</h3>
                    <p class="en hidden">We have several groups for children up to the age of 15. To sign up or if you have any questions, please contact kontakt@karlskronabergsport.se.</p>
                    <table class="table">
                        <tbody>
                            <tr class="sv">
                                <td>Medlemsavgift</td>
                                <td>150 kr</td>
                            </tr>
                            <tr class="sv">
                                <td>Terminsavgift</td>
                                <td>400 kr</td>
                            </tr>
                            <tr class="sv">
                                <td>Årsavgift</td>
                                <td>600 kr</td>
                            </tr>
                            <tr class="en hidden">
                                <td>Membership fee</td>
                                <td>150 SEK</td>
                            </tr>
                            <tr class="en hidden">
                                <td>One semester</td>
                                <td>400 SEK</td>
                            </tr>
                            <tr class="en hidden">
                                <td>Yearly fee</td>
                                <td>600 SEK</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div>
                    <h3 class="sv">Kurser</h3>
                    <p class="sv">
                        Skulle ni vilja ha er klättring instruktörsledd, inomhus eller utomhus, 
                        så kan vi erbjuda klättring inomhus i vår hall, eller ute på någon av Blekinges fina klippor tillsammans
                        med våra instruktörer. Rekommenderad storlek på grupper är 5-10 men vi kan ofta lösa större grupper med. Kontakta kontakt@karlskronabergsport.se för frågor och bokning.
                    </p>
                    <h3 class="en hidden">Courses</h3>
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
                            <tr class="sv">
                                <td>Utomhus</td>
                                <td>300 kr/person</td>
                            </tr>
                            <tr class="en hidden">
                                <td>Indoor</td>
                                <td>150 SEK/person</td>
                            </tr>
                            <tr class="en hidden">
                                <td>Outdoor</td>
                                <td>300 SEK/person</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                </div>
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