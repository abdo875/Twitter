<?php 
    session_start();
    if(isset($_SESSION['uname'])){
        header("location: ../00.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>SignUp and Login</title>
	<link rel="stylesheet" type="text/css" href="auth.css">
    <link rel="stylesheet" href= "../assessts/css/all.min.css">

</head>
<body>
    <?php
        /**if(isset($_SESSION['errMsg']) && !empty($_SESSION['errMsg'])){
            echo '<div class="alert alert-danger err" role="alert">';
                echo '<span>'. $_SESSION['errMsg'].'</span>';
            echo '</div>';
        }*/
    ?>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="register.php" method="POST">
                <h1>Create Account</h1>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="social"><i class="fab fa-google"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin"></i></a>
                </div>
                <span>or use your email for registration</span>
                <input type="text" name="uname" placeholder="User Name" required>
                <div class="name">
                    <input class="fname" type="text" name="Fname" placeholder="First Name" required>
                    <input class="lname" type="text" name="Lname" placeholder="Last Name" required>
                </div>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <select class="select" name="role">
                    <option value="3">Normal User</option>
                    <option value="2">Content Creator</option>
                </select>
                <button>SignUp</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="login.php" method="POST">
                <h1>Sign In</h1>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="social"><i class="fab fa-google"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin"></i></a>
                </div>
                <span>or use your account</span>
                <input type="text" name="uname" placeholder="User Name" required>
                <input type="password" name="password" placeholder="Password" required>
                <a href="forgetpass.php">Forgot Your Password</a>
                <button>Sign In</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');

        signUpButton.addEventListener('click', () => {
            container.classList.add("right-panel-active");
        });
        signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
        });
    </script>
