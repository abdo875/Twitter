<?php       
session_start();
require_once '../Models/person.php';
require_once '../Controllers/personController.php';
require_once '../Controllers/adminFunctions.php';
require_once '../Controllers/userSubscriber.php';
if(isset($_SESSION['uname'])){
    if(isset($_SESSION['Aid'])){$id = $_SESSION['Aid'];}
    elseif(isset($_SESSION['CCid'])){$id = $_SESSION['CCid'];}
    elseif(isset($_SESSION['Uid'])){$id = $_SESSION['Uid'];}
    $personControl = new PersonController;
    $adminControl = new AdminFunctions;
    $userSubscriber = new UserSubscriber;
    if (isset($_GET['follow'])){
        if($userSubscriber->follow($id, $_GET['follow'])){
            header("location: http://localhost/twitter/Views/00.php");
        }
    }
    elseif (isset($_GET['unfollow'])){
        if($userSubscriber->unFollow($id, $_GET['unfollow'])){
            header("location: http://localhost/twitter/Views/00.php");
        }
    }
    elseif (isset($_GET['mute'])){
        if($userSubscriber->muteUser($id, $_GET['mute'])){
            header("location: http://localhost/twitter/Views/00.php");
        }
    }
    elseif (isset($_GET['unmute'])){
        if($userSubscriber->unMuteUser($id, $_GET['unmute'])){
            header("location: http://localhost/twitter/Views/00.php");
        }
    }
    elseif (isset($_GET['block'])){
        if($userSubscriber->blockUser($id, $_GET['block'])){
            header("location: http://localhost/twitter/Views/00.php");
        }
    }
    elseif (isset($_GET['unblock'])){
        if($userSubscriber->unBlockUser($id, $_GET['unblock'])){
            header("location: http://localhost/twitter/Views/00.php");
        }
    }
    elseif (isset($_GET['reportPid'])){
        if(trim($_POST['reportContent']) == ""){
            $_SESSION['errMsg'] = "You cannot add Spaces Only.";
            header("location: err.php");
        }
        else{
            if($userSubscriber->reportUser($id,$_GET['reportPid'],$_POST['reportContent'])){
                header("location: http://localhost/twitter/Views/00.php");
            }
        }
        
    }
    elseif(isset($_GET['editProfile'])){
        $person = new Person;
        $person->id =  $_POST['id'];
        $person->uname =  $_POST['uname'];
        $person->email =  $_POST['email'];
        if($_POST['new_pass'] == ''){
            $person->pass =  $_POST['old_pass'];
        }
        else{
            $person->pass =  $_POST['new_pass'];
        }
        $person->Fname =  $_POST['Fname'];
        $person->Lname =  $_POST['Lname'];
        $person->role =  $_POST['role'];
        $person->FPQ =  $_POST['FPQ'];
        $person->phone =  $_POST['phone'];
        if($_FILES['pimage']['name'] == null){
            $person->pimage =  $_POST['old_pimage'];
        }
        else{
            $imageName  = $_FILES['pimage']['name'];
            $imageType  = $_FILES['pimage']['type'];
            $imageSize  = $_FILES['pimage']['size'];
            $imageTmp   = $_FILES['pimage']['tmp_name'];
            $image = rand(0,100000000) . '_' . $imageName;
            move_uploaded_file($imageTmp, '..\\Uploads\\' . $image);
            $person->pimage =  $image;
        }
        if($_FILES['cimage']['name'] == null){
            $person->cimage =  $_POST['old_cimage'];
        }
        else{
            $imageName  = $_FILES['cimage']['name'];
            $imageType  = $_FILES['cimage']['type'];
            $imageSize  = $_FILES['cimage']['size'];
            $imageTmp   = $_FILES['cimage']['tmp_name'];
            $image = rand(0,100000000) . '_' . $imageName;
            move_uploaded_file($imageTmp, '..\\Uploads\\' . $image);
            $person->cimage =  $image;
        }
        if((trim($_POST['Fname']) == "" && $_POST['Fname'] != null) || (trim($_POST['Lname']) == "" && $_POST['Lname'] != null) || (trim($_POST['email']) == "" && $_POST['email'] != null) || (trim($_POST['FPQ']) == "" && $_POST['FPQ'] != null)|| (trim($_POST['new_pass']) == "" && $_POST['new_pass'] != null) || (trim($_POST['phone']) == "" && $_POST['phone'] != null)){
            $_SESSION['errMsg'] = "You cannot add Spaces Only.";
            header("location: err.php");
        }
        elseif($_POST['Fname'] == null || $_POST['Lname'] == null){
            $_SESSION['errMsg'] = "The first Name And Last name Cannot Be Empty.";
            header("location: err.php");
        }
        elseif($_POST['new_pass'] != null && strlen($_POST['new_pass']) < 6){
            $_SESSION['errMsg'] = "The password is too short.";
            header("location: err.php");
        }
        else{
            if($personControl->updateInfo($person)){
                session_start();
                if($person->role == 1){
                    $_SESSION['Aid'] = $person->id;
                }
                elseif($person->role == 2){
                    $_SESSION['CCid'] = $person->id;
                }
                elseif($person->role == 3){
                    $_SESSION['Uid'] = $person->id;
                }
                $_SESSION['uname'] = $person->uname;
                header("location: http://localhost/twitter/Views/00.php");
            }
            else{
                header( "location: http://localhost/twitter/Views/err.php" );
            }
        }
    }
    elseif(isset($_GET['banUser'])){
        if($adminControl->banUser($_GET['banUser'])){
            header("location: http://localhost/twitter/Views/00.php");
        }
    }
    elseif(isset($_GET['approveUser'])){
        if($adminControl->approve($_GET['approveUser'])){
            header("location: http://localhost/twitter/Views/00.php");
        }
    }
    elseif(isset($_GET['deleteUser'])){
        if($adminControl->deleteUser($_GET['deleteUser'])){
            header("location: http://localhost/twitter/Views/00.php");
        }
    }
    elseif(isset($_GET['deleteReport'])){
        if($adminControl->deleteReport($_GET['deleteReport'])){
            $url= $_SERVER['HTTP_REFERER'];
            header("location: $url");
        }
    }
    else {
        //header("location:javascript://history.go(-1)");
        $_SESSION['errMsg'] = 'You Cannot access This page Directly.';
        header( "location: http://localhost/twitter/Views/err.php" );
    }
}
else {
    header( "location: http://localhost/twitter/Views/Auth/auth.php" );
}


