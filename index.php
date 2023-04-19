<?php
  
    require "init.php";
    check_login();
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>Riddley</title>
        <link rel="icon" href="favicon.png" type="image/x-icon">
        <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    </head>
    <body>
        <div class="container">
            <div id="home" class="flex-column flex-center">
                <img src="logo.png" alt="logo">
                <h1> Riddley with Mr Smiley  </h1>
                <a href="login.php" class="btn">Start</a>
                <a href="login.php" class="login-btn">Login</a>
                <a href="highscores.html" id="highscore-btn">Highscores</a>

            </div>
        </div>
    </body>
</html>