<?php 
    session_start();

    //unset($_SESSION['uname']);
    //unset($_SESSION['errMsg']);


    session_unset();

    session_destroy();

    header('Location: ../1.php ');

    exit();
