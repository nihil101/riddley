<?php
     require "init.php";

    if(count($_POST) > 0)
    {
        $User = new User();
        $errors = $User->create($_POST); 

        if(is_array($errors) && count($errors) == 0)
        {
            header("Location: login.php");
            die;
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>SignUp</title>
        <link rel="icon" href="favicon.png" type="image/x-icon">
        <link rel="stylesheet" href="login.css?v=<?php echo time(); ?>">
</head>

<div id="box">
    <form method="post">

        <?php

             if(isset($errors) && count($errors) > 0){
                foreach ($errors as $error) {
                    echo $error . "<br>";
                }
             }
        ?>
        <hr>
        <h1>SignUp<img src="logo.png" alt=""></h1>
        <input class="textbox" type="username" name="username" placeholder= "Username" value="<?=isset($_POST['username']) ? $_POST['username'] : '';?>"><br><br>
        <input class="textbox" type="email" name="email" placeholder= "Email" value="<?=isset($_POST['email']) ? $_POST['email'] : '';?>"><br><br>
        <input class="textbox" type="password" name="password" placeholder= "Password" value="<?=isset($_POST['password']) ? $_POST['password'] : '';?>"><br><br>

        <input id="btn" type="submit" value="SignUp"><br><br>
        <div><a href="login.php">Click to Login</a><br><br></div>
</form>
</div>
<body>
