<?php
    session_start();
    require_once '../../Controllers/AuthController.php';
    if(isset($_POST['uname']) && isset($_POST['password'])){
        if(!empty($_POST['uname']) && !empty($_POST['password'])){
            $person = new Person;
            $auth = new AuthController;
            $person->uname = $_POST['uname'];
            $person->pass = $_POST['password'];
            if($auth->login($person)){
                session_start();
                header("location: ../00.php");
            }
            else{
                //header("location: auth.php");
                header( "location: http://localhost/twitter/Views/err.php" );
            }
        }
    }

