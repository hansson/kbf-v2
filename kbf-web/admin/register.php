<?php
    include '../helpers.php';
    $config = require '../kbf.config.php';
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

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/bootstrap/signin.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    
</head>

  <body>
  
    <div class="container">
        <div id="unexpected_error" class="alert alert-danger hidden" role="alert">
            <strong>Ett oväntat fel inträffade. Är användaren redan registrerad? Kontakta styrelsen@karlskronabergsport.se för hjälp</strong>
        </div>

      <form id="registerForm" class="form-signin">
        <h2 class="form-signin-heading">Registrera</h2>
        <label for="inputFirstName">Förnamn</label>
        <input type="text" id="inputFirstName" class="form-control" placeholder="Förnamn" required autofocus>
        <label for="inputLastName">Efternamn</label>
        <input type="text" id="inputLastName" class="form-control" placeholder="Efternamn" required autofocus>
        <label for="inputPnr">Födelsedatum</label>
        <div id="pnr_error" class="alert alert-danger hidden" role="alert">
            <strong>Felaktigt format.</strong>
        </div>
        <input type="number" id="inputPnr" class="form-control" placeholder="YYMMDD" required autofocus>
        <label for="inputEmail">Epost</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Epost" required autofocus>
        <label for="inputPassword">Lösenord</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Lösenord" required>
        <button id="registerBtn" class="btn btn-lg btn-primary btn-block" type="submit">Registrera</button>
        <p>När du registrerar dig hos oss accepterar du att vi sparar dina användaruppgifter. Du kan läsa mer om hur vi hanterar dina uppgifter <a href="#" data-toggle="modal" data-target="#handleInformationModal">här</a></p>
      </form>

      <div>
        <!-- Modal -->
        <div class="modal fade" id="handleInformationModal" tabindex="-1" role="dialog" aria-labelledby="handleInformationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="handleInformationModalLabel">Hur vi hanterar användaruppgifter</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>För att hålla koll på dina betalningar och för att ge dig en bättre upplevelse hos oss behöver vi spara dina användaruppgifter.
                            Dina uppgifter sparas i en lösenordsskyddad databas hos one.com som levererar databastjänsten, all data som inhämtas skickas krypterat
                            över https. Dina information kommer aldrig att lämnas ut till någon annan tredjepart än Svenska Klätterförbundet som behöver information
                            om dig när vi registrerar dig som medlem. När du betalar medlemsavgift så sparar vi tillfälligt ditt personnummer till du har blivit
                            registrerad hos Svenska Klätterförbundet.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div> <!-- /container -->

    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/jquery.cookie.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="../js/bootstrap/bootstrap.js"></script>
    <script src="../js/bootstrap/ie10-viewport-bug-workaround.js"></script>
    <script src="../js/helpers.js"></script>
    <script>
        var email = getUrlParameter("email")
        $("#inputEmail").val(email);
        $("#registerForm").submit(function(e){
            e.preventDefault();
            hide($("#pnr_error"));
            hide($("#unexpected_error"));
            var request = {
                pnr: $("#inputPnr").val(),
                password: $("#inputPassword").val(),
                firstname: $("#inputFirstName").val(),
                lastname: $("#inputLastName").val(),
                email: $("#inputEmail").val()     
            }
            $.post( "../api/public/register/", JSON.stringify(request), function(response) {
                window.location = "login.php?registered=1";
            }, "json").fail(function(response){
                if(response.responseText && JSON.parse(response.responseText).error === "Bad personal number") {
                    show($("#pnr_error"));
                } else {
                    show($("#unexpected_error"));
                }
            }); 
        });
    </script>
  </body>
</html>
