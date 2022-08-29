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
        <div id="registered" class="alert alert-success hidden" role="alert">
            <strong>Du är nu registrerad. För att kunna använda din användare behöver den aktiveras. Detta sköts av våra administratörer och sker vanligtvis inom 24 timmar.</strong>
        </div>
        <div id="sessionError" class="alert alert-danger hidden" role="alert">
            <strong>Din session har gått ut, var vänlig logga in på nytt.</strong>
        </div>
        <div id="notActive" class="alert alert-danger hidden" role="alert">
            <strong>Din användare är inte aktiverad. Detta tar vanligtvis en dag. Om du inte blivit aktiverad inom 24 timmar var vänlig kontakta oss.</strong>
        </div>
        <div id="badPassword" class="alert alert-danger hidden" role="alert">
            <strong>Felaktig epost eller lösenord</strong>
        </div>

        <form id="loginForm" class="form-signin">
            <h2 class="form-signin-heading">Logga in</h2>
            <label for="inputEmail" class="sr-only">Epost</label>
            <input type="text" id="inputEmail" class="form-control" placeholder="Epost" inputmode="email" autocomplete="email" required autofocus>
            <label for="inputPassword" class="sr-only">Lösenord</label>
            <input type="password" id="inputPassword" class="form-control" placeholder="Lösenord" autocomplete="current-password" required>
            <button id="loginBtn" class="btn btn-lg btn-primary btn-block" type="submit">Logga in</button>
            <button id="registerBtn" class="btn btn-lg btn-primary btn-block">Registrera</button>
            <a id="forgotBtn" href="#">Glömt lösenord</a>
        </form>


    </div> <!-- /container -->

    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/jquery.cookie.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="../js/bootstrap/bootstrap.js"></script>
    <script src="../js/bootstrap/ie10-viewport-bug-workaround.js"></script>
    <script src="../js/helpers.js"></script>
    <script>
        var registered = getUrlParameter("registered")
        if(registered == 1) {
            show($("#registered"));
        }
        var error = getUrlParameter("error")
        if(error == 1) {
            show($("#sessionError"));
        }
        $("#loginForm").submit(function(e){
            e.preventDefault();
            hide($("#notActive"));
            hide($("#badPassword"));
            var request = {
                email: $("#inputEmail").val().toLowerCase(),
                password: $("#inputPassword").val()
            }
            $.post( "../api/public/login/", JSON.stringify(request), function(response) {
                $.cookie("user", response.pnr);
                var target = getUrlParameter("target");
                if(!target || target === "") {
                    target = "index.php";
                }
                window.location = target;
            }, "json").fail(function(response){
                if(response.responseText && JSON.parse(response.responseText).error === "Not active") {
                    show($("#notActive"));
                } else if (response.responseText && JSON.parse(response.responseText).error === "Wrong Email or Password") {
                    show($("#badPassword"));
                }
                
            });
        });

        $("#registerBtn").on("click", function() {
            var email = $("#inputEmail").val();
            var url = "";
            if(email != "") {
                url += "?email=" + email;
            }
            window.location = "register.php" + url;
        });

        $("#forgotBtn").on("click", function() {
            var email = $("#inputEmail").val();
            var url = "";
            if(email != "") {
                url += "?email=" + email;
            }
            window.location = "forgot.php" + url;
        });
    </script>
  </body>
</html>
