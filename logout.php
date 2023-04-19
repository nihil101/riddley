<?php

if(isset($_SESSION['hashed_user']))
{
    unset($_SESSION['hashed_user']);
}

header("Location: login.php");
die;

?>
