<?php 
    session_start();
    if(isset($_SESSION['errMsg'])){
        $_SESSION['errMsg'] ='';
    }
    if(isset($_SESSION['uname'])){
        header("location: Views/00.php");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twitter</title>
    

    <link rel="stylesheet" href= "layout/css/bootstrap.min.css">
    <link rel="stylesheet" href= "layout/css/all.min.css">
    <link rel="stylesheet" href= "layout/css/fontawesome.min.css">
    <link rel="stylesheet" href= "layout/css/boxicons.min.css">    
    <link rel="stylesheet" href= "layout/css/style.css">
</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-6 icon">
            <a href="Views/00.php"><i class='bx bxl-xing'></i></a>
        </div>
        <div class="col-6">
            <div class="header">Happening now</div>
            <div class="subheader">Join today.</div>
            <div><button class="google"><i class="fa-brands fa-google"></i>   Sign up with Google</button></div>
            <div><button class="apple"><span><i class="fa-brands fa-apple"></i>  </span>Sign up with Apple</button></div>
            <div class="or-con">
                <div class="left-line"></div>
                <span class="or">or</span>
                <div class="right-line"></div>
            </div>
            <div class="browse">
                <a href="Views/00.php">Or Browse now!</a>
            </div>
            <form action="Views/Auth/auth.php">
                <button type="submit" class="sign-up-btn">Create account</button>
                <div class="text"><span>Already have an account?</span></div>
                <button type="submit" class="sign-in-btn">Sign in</button>
            </form>
        </div>
    </div>
</div>


    <!-- Link JS -->
    <script src="layout/js/jquery-3.7.1.min.js"></script>
    <script src="layout/js/main.js"></script>
    <script src="layout/js/all.min.js"></script>
    <script src="layout/js/bootstrap.bundle.min.js"></script>

</body>

</html>