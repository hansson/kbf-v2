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
            <strong>Ett oväntat fel inträffade.</strong>
        </div>

      <form id="resetForm" class="form-signin">
        <h2 class="form-signin-heading">Glömt lösenord</h2>
        <label for="inputPassword">Nytt Lösenord</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Nytt Lösenord" required autofocus>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Återställ</button>
      </form>

    </div> <!-- /container -->

    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/jquery.cookie.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="../js/bootstrap/bootstrap.js"></script>
    <script src="../js/bootstrap/ie10-viewport-bug-workaround.js"></script>
    <script src="../js/helpers.js"></script>
    <script>
        var email = getUrlParameter("email");
        var token = getUrlParameter("token");
        $("#resetForm").submit(function(e){
            e.preventDefault();
            hide($("#unexpected_error"));
            var password = $("#inputPassword").val();
            $.get( "../api/public/forgot?email=" + email + "&token=" + token + "&password=" + password, function(response) {
                window.location = "login.php";
            }, "json").fail(function(response){
                show($("#unexpected_error"));
            }); 
        });
    </script>
  </body>
</html>
