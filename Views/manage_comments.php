<?php       
session_start();
require_once '../Models/PostComment.php';
require_once '../Models/AdComment.php';
require_once '../Controllers/PostCommentController.php';
if(isset($_SESSION['uname'])){
    if(isset($_SESSION['Aid'])){$id = $_SESSION['Aid'];}
    elseif(isset($_SESSION['CCid'])){$id = $_SESSION['CCid'];}
    elseif(isset($_SESSION['Uid'])){$id = $_SESSION['Uid'];}
    $post_comment = new PostComment;
    $ad_comment = new AdComment;
    $commentControl = new PostCommentController;
    if (isset($_POST['reply']) && isset($_POST['content']) && isset($_GET['postid'])){
        if($_POST['content'] != null){
            $post_comment->pid = $id;
            $post_comment->postid = $_GET['postid'];
            $post_comment->comment = $_POST['content'];
            if(trim($_POST['content']) == ""){
                $_SESSION['errMsg'] = "You cannot Add Spaces.";
                header( "location: http://localhost/twitter/Views/err.php" );
            }
            else{
                if($commentControl->addComment($post_comment)){
                    header( "location: http://localhost/twitter/Views/00.php" );
                }
                else{
                    echo 'fuck it';
                }
            }
            
        }
        else{
            $_SESSION['errMsg'] = 'You cannot comment empty text.';
            header( "location: http://localhost/twitter/Views/err.php" );
        }
        
    } 
    elseif (isset($_POST['reply']) && isset($_POST['content']) && isset($_GET['adid'])) {
        if($_POST['content'] != null){
            $ad_comment->pid = $id;
            $ad_comment->Adid = $_GET['adid'];
            $ad_comment->comment = $_POST['content'];
            if(trim($_POST['content']) == ""){
                $_SESSION['errMsg'] = "You cannot Add Spaces.";
                header( "location: http://localhost/twitter/Views/err.php" );
            }
            else{
                if($commentControl->addAdComment($ad_comment)){
                    header( "location: http://localhost/twitter/Views/00.php" );
                }
                else{
                    echo 'fuck it';
                }
            }
        }
        else{
            $_SESSION['errMsg'] = 'You cannot comment empty text. from retweet';
            header( "location: http://localhost/twitter/Views/err.php" );
        }
    }
    elseif (isset($_POST['reply']) && isset($_POST['content']) && isset($_GET['retweetid'])) {
        if($_POST['content'] != null){
            $post_comment->pid = $id;
            $post_comment->postid = $_GET['retweetid'];
            $post_comment->comment = $_POST['content'];
            if(trim($_POST['content']) == ""){
                $_SESSION['errMsg'] = "You cannot Add Spaces.";
                header( "location: http://localhost/twitter/Views/err.php" );
            }
            else{
                if($commentControl->addRetweetComment($post_comment)){
                    header( "location: http://localhost/twitter/Views/00.php" );
                }
                else{
                    echo 'fuck it';
                }
            }
        }
        else{
            $_SESSION['errMsg'] = 'You cannot comment empty text. from retweet';
            header( "location: http://localhost/twitter/Views/err.php" );
        }
    }
    elseif(isset($_GET['deletePostComment'])){
        if($commentControl->deleteComment("tweet", $_GET['deletePostComment'])){
            $url= $_SERVER['HTTP_REFERER'];
            header("location: $url");
        }
    }
    elseif(isset($_GET['deleteRetweetComment'])){
        if($commentControl->deleteComment("retweet", $_GET['deleteRetweetComment'])){
            $url= $_SERVER['HTTP_REFERER'];
            header("location: $url");
        }
    }
    elseif(isset($_GET['deleteAdComment'])){
        if($commentControl->deleteComment("ad", $_GET['deleteAdComment'])){
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


