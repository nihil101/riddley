<?php

class DB
{
    protected $con;
    public function __construct()
    {
       $string = "mysql:host=localhost;dbname=riddley_db";
       $this->con = new PDO($string, "root","");
    }

    public function write($query, $data = array())
    {
        $stm = $this->con->prepare($query);
        $check = $stm->execute($data);

        if($check){
            return true;
        }

        return false;
    }

    public function read($query, $data = array())
    {
        $stm = $this->con->prepare($query);
        $check = $stm->execute($data);

        if($check){

            $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
            if(is_array($rows) && count($rows) > 0){
                return $rows;
            }
        }

        return false;
    } 

}

class User
{
    protected $errors = array();
    public function create($POST)
    {
        $this->errors = array();

        $username = $POST['username'];
        $email = $POST['email'];
        $password = $POST['password'];

        if(empty($username)){
            $this->errors[] = "Please enter a valid username";
        }

        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $this->errors[] = "Please enter a valid email";
        }

        if(empty($password) || strlen($password) < 4){
            $this->errors[] = "Password must be atleast 4 characters";
        }

        if(count($this->errors) == 0)
        {
           $POST['date'] = date("Y-m-d H:i:s");
           $POST['password'] = hash("sha1",$POST['password']);
           $query = "insert into users (username,password,email,date) values (:username,:password,:email,:date)";
           $db = new DB();
           $db->write($query,$POST);
        }
        return $this->errors;
    }

    public function login($POST)
    {
        $this->errors = array();

        $POST['password'] = hash("sha1",$POST['password']);

        $query = "select * from users where email = :email && password = :password limit 1";
        $db = new DB();
        $db->write($query,$POST);
        $data = $db->read($query,$POST);

        if(is_array($data))
        {
            $_SESSION['hashed_user'] = $data[0]['username'];

        }else{
            $this->errors[] = "Wrong username or password";
        }  
        
        return $this->errors;

    }


}