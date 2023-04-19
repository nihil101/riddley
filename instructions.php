<?php
 require "init.php";
 check_login();

 if(!empty($_SESSION['user_data'])){
    echo 'Hi, ' . $_SESSION['user_data']['username'];
 }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>Instructions</title>
        <link rel="icon" href="favicon.png" type="image/x-icon">
        <link rel="stylesheet" href="login.css">
    </head>
    <body>

    <div class ="infobox">
    <h1>Riddley Guide<img src="logo.png" alt=""></h1>
    <div class="infolist">
    <div class="info">1. You have 10 questions to answer.</div>
    <div class="info">2. Once an answer is selected. It cannot be undone.</div>
    <div class="info">3. You will get 10 points for each correct answer.</div>
    <div class="info">4. If you leave while playing the quiz, your score wont be saved.</div>
    <div class="info">5. You must login in order to play the game. Good Luck!</div>
    </div> <br><br>
    <div class ="button">
        <a href ="index.php" class="exit">Exit</a>
        <a href ="game.php" class="play">Play</a>
    </div>
</div>