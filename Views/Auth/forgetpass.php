<?php


?>
<!DOCTYPE html>
<html>
<head>
	<title>Forget Pass</title>
	<link rel="stylesheet" type="text/css" href="../assessts/css/style.css">
    <link rel="stylesheet" href= "../assessts/css/all.min.css">

</head>
<body>
<?php
require_once '../../Controllers/AuthController.php';
$auth = new AuthController;
if(isset($_GET['FPQ']) && isset($_POST['submit'])){
    $uname =$_POST['uname'];
    $FPQ =$_POST['FPQ'];
    if($auth->forgetPass("check",$uname,$FPQ) && $FPQ != null){
        ?>
        <div class="forget_form">
            <form action="forgetpass.php?newPass=<?php echo $uname; ?>" method="POST">
                <input type="password" placeholder="Enter the new Password." name="newPass1" required>
                <input type="password" name="newPass2" placeholder="Enter The new Password Again." required>
                <input type="submit" value="Submit" class="forget_btn">
            </form>
        </div>
        <?php
        
    }
    else{
        session_start();
        $_SESSION['errMsg'] = "Username or The answer is wrong.";
        header('location: ../err.php');
    }
}
elseif(isset($_GET['newPass'])){
    if(($_POST['newPass1'] == $_POST['newPass2']) && strlen(trim($_POST['newPass1']))  > 5 ){
        if($auth->forgetPass("add",$_GET['newPass'],$_POST['newPass1'])){
            header("location: auth.php");
        }
    }
    else{
        session_start();
        $_SESSION['errMsg'] = "The password Does not Match OR The password is Short.";
        header('location: ../err.php');
    }

}
else{
?>
<div class="forget_form">
    <form action="forgetpass.php?FPQ" method="POST">
        <input type="text" placeholder="Enter Username" name="uname" required>
        <p class="q">What is your Best Friend name?</p>
        <input type="text" name="FPQ" placeholder="Enter The answer of Question." required>
        <input type="submit" name="submit" value="Submit" class="forget_btn">
    </form>
</div>
<?php
}
