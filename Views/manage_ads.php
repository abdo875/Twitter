<?php
if(session_status() == 0){
    session_start();
}
elseif(session_status() == 1){
    session_start();
}
if(isset($_SESSION['Aid'])){$id = $_SESSION['Aid'];}
elseif(isset($_SESSION['CCid'])){$id = $_SESSION['CCid'];}
elseif(isset($_SESSION['Uid'])){$id = $_SESSION['Uid'];}
require_once '../Models/advertisement.php';
require_once '../Controllers/AdController.php';
$AdController = new AdController;
if (isset($_SESSION['uname'])){
    if (isset($_POST['Ad']) && (isset($_POST['content']) || isset($_FILES['image']) )){
        if(!empty($_POST['content']) || !empty($_FILES['image'])){
            $Ad = new Advertisement;
            if($_FILES['image']['name'] != null){
                $imageName  = $_FILES['image']['name'];
                $imageType  = $_FILES['image']['type'];
                $imageSize  = $_FILES['image']['size'];
                $imageTmp   = $_FILES['image']['tmp_name'];
                $image = rand(0,100000000) . '_' . $imageName;
                move_uploaded_file($imageTmp, '..\\Uploads\\' . $image);
                $Ad->image = $image;
                echo $imageName;
            }
            $Ad->ccid = $id;
            $Ad->content = $_POST['content'];
            if (trim($_POST['content']) == ''){
                $_SESSION['errMsg'] = 'You cannot Add content of Spaces.';
                header( "location: http://localhost/twitter/Views/err.php" );
            }
            else{
                if($AdController->addAd($Ad)){
                    header('location: http://localhost/twitter/Views/00.php');
                } else{
                    echo 'fuck it';
                }
            }
            
            
        }
        else {
            $_SESSION['errMsg'] = 'At least fill the textarea or choose an image.';
            header( "location: http://localhost/twitter/Views/err.php" );
            return false;
        }
    }
    elseif(isset($_GET['deleteAd'])){
        if($AdController->deleteAd($_GET['deleteAd'])){
            header( "location: http://localhost/twitter/Views/00.php" );
        }
        else{
            echo 'fuck it';
        }
    }
    elseif(isset($_GET['addAdLike'])){
        if($AdController->addAdLike($id,$_GET['addAdLike'])){
            header( "location: http://localhost/twitter/Views/00.php" );
        }
    }
    elseif(isset($_GET['removeAdLike'])){
        if($AdController->removeAdLike($id,$_GET['removeAdLike'])){
            header( "location: http://localhost/twitter/Views/00.php" );
        }
    }
}
else{
    header( "location: http://localhost/twitter/Views/Auth/auth.php" );
}