<?php

function check_login()
{

  if(!isset($_SESSION['hashed_user']))
  {
     header("Location: login.php");
     die;
  }
}