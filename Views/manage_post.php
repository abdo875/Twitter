<?php       
session_start();
require_once '../Models/post.php';
require_once '../Models/sharedPost.php';
require_once '../Models/hashtag.php';
require_once '../Controllers/PostController.php';
require_once '../Controllers/HashtagController.php';
require_once '../Controllers/interactiveController.php';

if (isset($_SESSION['uname'])){
    $postController = new PostController;
    $interactiveController = new InteractiveController;
    if(isset($_SESSION['Aid'])){$id = $_SESSION['Aid'];}
    elseif(isset($_SESSION['CCid'])){$id = $_SESSION['CCid'];}
    elseif(isset($_SESSION['Uid'])){$id = $_SESSION['Uid'];}

    if (isset($_POST['add']) && (isset($_POST['content']) || isset($_FILES['image']) )){
        if(!empty($_POST['content']) || !empty($_FILES['image'])){
            $post = new Post;
            if($_FILES['image']['name'] != null){
                $imageName  = $_FILES['image']['name'];
                $imageType  = $_FILES['image']['type'];
                $imageSize  = $_FILES['image']['size'];
                $imageTmp   = $_FILES['image']['tmp_name'];
                $image = rand(0,100000000) . '_' . $imageName;
                move_uploaded_file($imageTmp, '..\\Uploads\\' . $image);
                $post->image = $image;
            }
            if($_POST['newHashtag'] == null){
                $post->pid = $id;
                $post->content = $_POST['content'];
                $post->hid = $_POST['hashtag'];
                $post->visibility = $_POST['visibility'];
                $hash = new HashtagController;
                $hash->updateHashtag($post->hid);
                echo $post->hid;
                if(trim($_POST['content']) == ""){
                    $_SESSION['errMsg'] = 'You cannot Add content of Spaces.';
                    header( "location: http://localhost/twitter/Views/err.php" );
                }
                else{
                    if($postController->addPost($post)){
                        header('location: http://localhost/twitter/Views/00.php');
                    } else{
                        echo 'fuck it';
                    }
                }
            }
            
            else if ($_POST['newHashtag'] != null){
                $hashtag1 = new Hashtag;
                $hashtag1->pid = $id;
                $hashtag1->content = $_POST['newHashtag'];
                $HControl = new HashtagController;
                $resultVal = $HControl->addHashtag($hashtag1);
                if($resultVal){
                    $post->pid = $id;
                    $post->content = $_POST['content'];
                    $post->visibility = $_POST['visibility'];
                    $post->hid = $resultVal;
                    if(trim($_POST['content']) == ""){
                        $_SESSION['errMsg'] = 'You cannot Add content of Spaces.';
                        header( "location: http://localhost/twitter/Views/err.php" );
                    }
                    else{
                        if($postController->addPost($post)){
                            header('location: http://localhost/twitter/Views/00.php');
                        } else{
                            echo 'fuck it';
                        }
                    }
                } else{
                    echo 'fuck it';
                }
            }
            else{
                $post->pid = $id;
                $post->content = $_POST['content'];
                $post->hid = $_POST['hashtag'];
                if(trim($_POST['content']) == ""){
                    $_SESSION['errMsg'] = 'You cannot Add content of Spaces.';
                    header( "location: http://localhost/twitter/Views/err.php" );
                }
                else{
                    if($postController->addPost($post)){
                        header('location: http://localhost/twitter/Views/00.php');
                    } else{
                        echo 'fuck it';
                    }
                }
            }
        }
        else {
            $_SESSION['errMsg'] = 'At least fill the textarea or choose an image.';
            header( "location: http://localhost/twitter/Views/err.php" );
            return false;
        }
        
    } 
    elseif(isset($_POST['retweet'])){
        $sharedpost = new SharedPost;
        $sharedpost->pid =$id;
        $sharedpost->oldpid = $_GET['oldid'];
        $sharedpost->newcontent = $_POST['newContent'];
        $sharedpost->postid = $_GET['postid'];
        echo $sharedpost->pid;
        if(trim($_POST['content']) == "" && $_POST['content'] != null){
            $_SESSION['errMsg'] = 'You cannot Add content of Spaces.';
            header( "location: http://localhost/twitter/Views/err.php" );
        }
        else{
            if($postController->sharePost($sharedpost)){
                header( "location: http://localhost/twitter/Views/00.php" );
            }
            else{
                echo 'fuck it';
            }
        }
        
    }
    elseif(isset($_GET['deleteRetweet'])){
        if($postController->deleteRetweet($_GET['deleteRetweet'])){
            header( "location: http://localhost/twitter/Views/00.php" );
        }
        else{
            echo 'fuck it';
        }
    }
    elseif(isset($_GET['deletePost'])){
        if($postController->deletePost($_GET['deletePost'])){
            header( "location: http://localhost/twitter/Views/00.php" );
        }
        else{
            echo 'fuck it';
        }
    }
    elseif(isset($_GET['saveTweet'])){
        $groupid =$_POST['groupid'];
        $newGroup = $_POST['newGroup'];
        $postid = $_GET['saveTweet'];
        if($newGroup == null){
            if($groupid == 'null'){
                $_SESSION['errMsg'] = 'You Should Choose Group.';
                header( "location: http://localhost/twitter/Views/err.php" );
            }
            else{
                if($interactiveController->saveTweet($id,$postid,$groupid)){
                    header('location: http://localhost/twitter/Views/00.php');
                }
                else{
                    echo 'fuck it';
                }
            }
        }
        else{
            $newgroupid = $postController->addGroup($id,$newGroup);
            if($newgroupid){
                echo $newgroupid;
                if($interactiveController->saveTweet($id,$postid,$newgroupid)){
                    header('location: http://localhost/twitter/Views/00.php');
                    
                }
                else{
                    echo 'fuck it';
                }
            }
            else{
                header( "location: http://localhost/twitter/Views/err.php" );
            }
            
        }
        
    }
    elseif(isset($_GET['unSaveTweet']) && isset($_GET['pid'])){
        if($interactiveController->unSaveTweet($_GET['pid'],$_GET['unSaveTweet'])){
            header( "location: http://localhost/twitter/Views/00.php" );
        }
        else{
            echo 'fuck it';
        }
    }
    elseif(isset($_GET['saveRetweet'])){
        $groupid =$_POST['groupid'];
        $newGroup = $_POST['newGroup'];
        $postid = $_GET['saveRetweet'];
        if($newGroup == null){
            if($groupid == 'null'){
                $_SESSION['errMsg'] = 'You Should Choose Group.';
                header( "location: http://localhost/twitter/Views/err.php" );
            }
            else{
                if($interactiveController->saveRetweet($id,$postid,$groupid)){
                    header('location: http://localhost/twitter/Views/00.php');
                }
                else{
                    echo 'fuck it';
                }
            }
        }
        else{
            $newgroupid = $postController->addGroup($id,$newGroup);
            if($newgroupid){
                echo $newgroupid;
                if($interactiveController->saveRetweet($id,$postid,$newgroupid)){
                    header('location: http://localhost/twitter/Views/00.php');
                    
                }
                else{
                    echo 'fuck it';
                }
            }
            else{
                header( "location: http://localhost/twitter/Views/err.php" );
            }
            
        }
    }
    elseif(isset($_GET['unSaveRetweet'])&& isset($_GET['pid'])){
        if($interactiveController->unSaveRetweet($_GET['pid'],$_GET['unSaveRetweet'])){
            header( "location: http://localhost/twitter/Views/00.php" );
        }
        else{
            echo 'fuck it';
        }
    }
    elseif(isset($_GET['deleteGroup'])){
        if($postController->deleteGroup($id,$_GET['deleteGroup'])){
            header( "location: http://localhost/twitter/Views/00.php" );
        }
    }
    elseif(isset($_GET['addTweetLike'])){
        if($interactiveController->addTweetLike($id,$_GET['addTweetLike'])){
            header( "location: http://localhost/twitter/Views/00.php" );
        }
    }
    elseif(isset($_GET['removeTweetLike'])){
        if($interactiveController->removeTweetLike($id,$_GET['removeTweetLike'])){
            header( "location: http://localhost/twitter/Views/00.php" );
        }
    }
    elseif(isset($_GET['addRetweetLike'])){
        if($interactiveController->addRetweetLike($id,$_GET['addRetweetLike'])){
            header( "location: http://localhost/twitter/Views/00.php" );
        }
    }
    elseif(isset($_GET['removeRetweetLike'])){
        if($interactiveController->removeRetweetLike($id,$_GET['removeRetweetLike'])){
            header( "location: http://localhost/twitter/Views/00.php" );
        }
    }
    elseif(isset($_GET['makePublic'])){
        if($postController->changeVisibility("visible",$_GET['makePublic'])){
            header( "location: profile.php" );
        }
    }
    elseif(isset($_GET['makePrivate'])){
        if($postController->changeVisibility("private",$_GET['makePrivate'])){
            header( "location: profile.php" );
        }
    }
    else {
        //header("location:javascript://history.go(-1)");
        $_SESSION['errMsg'] = 'You Cannot access This page Directly.';
        header( "location: http://localhost/twitter/Views/err.php" );
    }
    
}
else{
    header( "location: http://localhost/twitter/Views/Auth/auth.php" );
}