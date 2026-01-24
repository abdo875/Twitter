<?php
session_start();
    require_once '../../Controllers/AuthController.php';
    require_once '../../Models/user.php';
    if(isset($_POST['uname']) && isset($_POST['Fname']) && isset($_POST['Lname']) && isset($_POST['email']) && isset($_POST['password'])){
        if(!empty($_POST['uname']) && !empty($_POST['Fname']) && !empty($_POST['Lname']) && !empty($_POST['email']) && !empty($_POST['password'])){
            $person = new User;
            $auth = new AuthController;
            $person->uname = trim($_POST['uname']);
            $person->pass = trim($_POST['password']);
            $person->Fname = trim($_POST['Fname']);
            $person->Lname = trim($_POST['Lname']);
            $person->email = trim($_POST['email']);
            $person->role = $_POST['role'];
            $person->FPQ ='';
            $person->phone ='';
            $person->pimage = 'abstract-user-flat-4.webp';
            $person->cimage = 'pexels-felixmittermeier-1146134.jpg';
            if((trim($_POST['Fname']) == "" && $_POST['Fname'] != null) || (trim($_POST['Lname']) == "" && $_POST['Lname'] != null) || (trim($_POST['email']) == "" && $_POST['email'] != null) || (trim($_POST['uname']) == "" && $_POST['uname'] != null)){
                $_SESSION['errMsg'] = "The fields Cannot be Spaces.";
                header("location: ../err.php");
            }
            elseif(($_POST['uname'] != null && strlen(trim($_POST['uname'])) < 3) || ($_POST['Fname'] != null && strlen(trim($_POST['Fname'])) < 3) || ($_POST['Lname'] != null && strlen(trim($_POST['Lname'])) < 3)){
                $_SESSION['errMsg'] = "The first Name And Last name is too short.";
                header("location: ../err.php");
            }
            elseif($_POST['Fname'] == null || $_POST['Lname'] == null){
                $_SESSION['errMsg'] = "The first Name And Last name Cannot Be Empty.";
                header("location: ../err.php");
            }
            elseif($_POST['password'] != null && strlen($_POST['password']) < 6){
                $_SESSION['errMsg'] = "The password is too short.";
                header("location: ../err.php");
            }
            else{
                if($auth->register($person)){
                    header("location: ../00.php");
                }
            }
            
        }
    }