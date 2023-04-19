<?php
$error = array();

require "mail.php";
require "init.php";

 if(!$con = mysqli_connect("localhost","root","","riddley_db")){
    die("could not connect");
}

$mode = "enter_email";
if(isset($_GET['mode'])){
    $mode = $_GET['mode'];
}

if(count($_POST) > 0){

    switch ($mode) {
        case 'enter_email':
            $email = $_POST['email'];
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $error[] = "Please enter a valid email";
            }elseif(!valid_email($email)){
                $error[] = "That email was not found";
            }else{

            $_SESSION['forgot']['email'] = $email;
            send_email($email);
            header("Location: forgot.php?mode=enter_code");
            die;

           }
           break;

        case 'enter_code':
            $code = $_POST['code'];
            $result = is_code_correct($code);

            if($result == "The code is correct!"){

                $_SESSION['forgot']['code'] = $code;
                header("Location: forgot.php?mode=enter_password");
                die;
            }else{
                $error[] = $result;
            }
            break;

        case 'enter_password':
            $password = $_POST['password'];
            $password2 = $_POST['password2'];

            if($password !== $password2){
                $error[] = "Passwords do not match";
            }elseif(!isset($_SESSION['forgot']['email']) || !isset($_SESSION['forgot']['code'])){
                header("Location: forgot.php");
                die;
            }else{
                save_password($password);
                if(isset($_SESSION['forgot'])){
                    unset($_SESSION['forgot']);
            }

            header("Location: login.php");
            die;
           }
           break;

        default:
            break;
    }
}

function send_email($email){

    global $con;

    $expire = time() + (60 * 2);
    $code = rand(10000,99999);
    $email = addslashes($email);

    $query = "insert into codes (email,code,expire) value ('$email','$code','$expire')";
    mysqli_query($con,$query);

    send_mail($email, 'Riddley: Reset password', "Your code is " . $code);
}

function save_password($password){

    global $con;

    $password = hash("sha1",$POST['password']);
    $email = addslashes($_SESSION['forgot'][$email]);

    $query  = "update users set password = '$password' where email = '$email' limit 1";
    mysqli_query($con,$query);

}

function valid_email($email){

    global $con;

    $email = addslashes($email);

    $query = "select * from users where email = '$email' limit 1";
    $result = mysqli_query($con,$query);
    if($result){
        if(mysqli_num_rows($result) > 0)
        {
            return true;   
        }
            
    }
    return false;
}


function is_code_correct($code){
    global $con;

    $code = addslashes($code);
    $expire = time();
    $email = addslashes($_SESSION['forgot']['email']);

    $query = "select * from codes where code = '$code' && email = '$email' && expire > '$expire' order by user_id desc limit 1";
    $result = mysqli_query($con,$query);
    if($result){
        if(mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_assoc($result);
            if($row['expire'] > $expire){

                return "The code is correct!";
            }else{
                return "The code is expired!";
            }
        }else{
            return "The code is incorrect!";
        }
    }
    return "The code is incorrect!";
}

?>


<!DOCTYPE html>
<html>
    <head>
        <title>Forgot password?</title>
        <link rel="icon" href="favicon.png" type="image/x-icon">
        <link rel="stylesheet" href="login.css?v=<?php echo time(); ?>">
</head>

<body>
    <?php
      
     switch ($mode) {
            case 'enter_email':
                ?>
                  <div id="box">
                 <form method="post" action="forgot.php?mode=enter_email">
                   <h1> Forgot Password<a href ="index.php"><img src="logo.png" alt=""></a></h1>
                   <h3> Enter your email below </h3>
                   <span style = "font-size: 13px; color: red;">
                   <?php
                        foreach ($error as $err) {
                            echo $err . "<br>";
                        }
                    ?>
                    </span>
                   <input class="textbox" type="email" name="email" placeholder= "Email" ><br><br>

                    <input id="btn" type="submit" value="Next"><br><br>
                   <div><a href="login.php">Login</a><br><br></div>
                 </form>
                  </div>
                <?php
                break;
    
            case 'enter_code':
                ?>
                  <div id="box">
                    <form method="post" action="forgot.php?mode=enter_code">
                     <h1> Forgot Password<a href ="index.php"><img src="logo.png" alt=""></a></h1>
                     <h3> Enter the code sent to your Email </h3>
                     <span style = "font-size: 13px; color: red;">
                   <?php
                        foreach ($error as $err) {
                            echo $err . "<br>";
                        }
                    ?>
                    </span>
                     <input class="textbox" type="text" name="code" placeholder= "Code" ><br><br>

                      <input id="btn" type="submit" value="Next" style="float: right;">
                      <a href="forgot.php">
                         <input id="btn" type="button" value="Resend"><br><br>
                       </a>
                    </form>
                   </div>
                <?php
                break;
    
            case 'enter_password':
                ?>
                  <div id="box">
                    <form method="post" action="forgot.php?mode=enter_password">
                     <h1> Forgot Password<a href ="index.php"><img src="logo.png" alt=""></a></h1>
                     <h3> Enter your new password </h3>
                     <span style = "font-size: 13px; color: red;">
                   <?php
                        foreach ($error as $err) {
                            echo $err . "<br>";
                        }
                    ?>
                    </span>
                     <input class="textbox" type="text" name="password" placeholder="Password"><br><br>
                     <input class="textbox" type="text" name="password2" placeholder= "Retype Password"><br><br>

                      <input id="btn" type="submit" value="Set password" style="float: right; width:32%;"><br><br>
                    </form>
                   </div>
                <?php
                break;
    
            default:
                break;
        }
      
    ?>

 </body>
 </html>