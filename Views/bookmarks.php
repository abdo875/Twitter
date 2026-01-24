<?php include 'includes/header.php'; ?>
<?php
session_start();
if(isset($_SESSION['uname'])){?>
    <div class="container">
        <div class="row">
            <!-- Start Sidebar-->
            <?php include 'sidebar.php'; ?>
            <!-- End sidebar -->
            <div class="col-2"></div>
            <div class="col-6 post-container" id="post-container">
            <p class="bookmark_title">Bookmarks</p>
            <?php
            if(isset($_SESSION['Aid'])){$id = $_SESSION['Aid'];}
            elseif(isset($_SESSION['CCid'])){$id = $_SESSION['CCid'];}
            elseif(isset($_SESSION['Uid'])){$id = $_SESSION['Uid'];}
            require_once '../Controllers/PostController.php';
            require_once '../Controllers/personController.php';
            require_once '../Controllers/interactiveController.php';
            require_once '../Controllers/retweetPrintController.php';
            $retweetPrintController= new RetweetPrintController;
            $interactiveController = new InteractiveController;
            $postControl = new PostController;
            $personControl = new PersonController;
            $hashtag2 = new HashtagController;
            $groups = $retweetPrintController->getGroups($id);
            if($groups){
                if(isset($_GET['groupid'])){
                    $saveTweets = $retweetPrintController->getSavedTweet($id,$_GET['groupid']);
                    $saveRetweets = $retweetPrintController->getSavedRetweet($id,$_GET['groupid']);
                    for($i = 0 ; $i <count($saveTweets); $i++){?>
                        <div class="post">
                            <img class="pimage-post" src="../Uploads/<?php echo $saveTweets[$i]['pimage'];?>" alt="">
                            <p class="title"><?php echo $personControl->getPersonData($saveTweets[$i]['pid'])->Fname.' '.$personControl->getPersonData($saveTweets[$i]['pid'])->Lname ;?></p>
                            <div class="dropdown drop-down">
                                <button class="btn btn-secondary drop-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <ul class="dropdown-menu menu">
                                    <?php
                                        if($personControl->checkFollow('follow',$id,$saveTweets[$i]['pid'])){ ?>
                                            <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?unfollow=<?php echo $saveTweets[$i]['pid']; ?>"><i class='bx bx-user-minus' ></i> Unfollow</a></li>
                                    <?php
                                        } else{ ?>
                                            <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?follow=<?php echo $saveTweets[$i]['pid']; ?>"><i class='bx bx-user-plus' ></i> Follow</a></li>
                                    <?php
                                        }
                                    ?>
                                    <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?mute=<?php echo $saveTweets[$i]['pid']; ?>"><i class='bx bx-volume-mute' ></i> Mute</a></li>
                                    <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?block=<?php echo $saveTweets[$i]['pid']; ?>"><i class="fa-solid fa-ban"></i> Block</a></li>
                                    <?php
                                    if($postControl->checkSaved('tweet',$saveTweets[$i]['postid'],$id)){
                                        ?>
                                        <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_post.php?unSaveTweet=<?php echo $saveTweets[$i]['postid'] ?>&pid=<?php echo $id ?>"><i class="fa-regular fa-bookmark"></i> Unsave post</a></li>
                                    <?php
                                    }
                                    else{
                                        ?>
                                        <li><a class="dropdown-item" href="?saveTweet=<?php echo $saveTweets[$i]['postid'] ?>"><i class="fa-regular fa-bookmark"></i> Save post</a></li>
                                        <?php
                                    }
                                    ?>
                                    <li><a class="dropdown-item" href="http://localhost/twitter/Views/00.php?report=<?php echo $saveTweets[$i]['pid']; ?>"><i class='bx bx-file-blank' ></i> Report User</a></li>
                                </ul>
                            </div>
                            <?php if ($saveTweets[$i]['image'] != null){?>
                                <span>
                                    <img src="../Uploads/<?php echo $saveTweets[$i]['image'];?>" alt="" width="600" height="200">
                                </span>
                            <?php
                            }
                            ?>
                            <p class="content">
                                <?php echo $saveTweets[$i]['content'];?>
                            </p>
                            <?php
                            if($saveTweets[$i]['hid'] !=null){
                                $hash = $hashtag2->getOneHashtag($saveTweets[$i]['hid']);
                                ?>
                                <span class="postHash">##  <?php echo $hash [0]['content'];?></span>
                            <?php 
                            }?>
                            <div class="interactive">
                                <?php
                                if($postControl->checkSaved("tweet_like",$saveTweets[$i]['postid'],$id)){?>
                                    <span class="co_Like">
                                        <a class="a" href="manage_post.php?removeTweetLike=<?php echo $saveTweets[$i]['postid']; ?>">
                                            <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                            <span><?php echo $interactiveController->numberOfLikes("tweet",$saveTweets[$i]['postid'])[0]['count(*)'] ?> Like</span>
                                        </a>
                                    </span>
                                    <?php
                                }
                                else{?>
                                    <span class="co">
                                        <a class="a" href="manage_post.php?addTweetLike=<?php echo $saveTweets[$i]['postid']; ?>">
                                            <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                            <span><?php echo $interactiveController->numberOfLikes("tweet",$saveTweets[$i]['postid'])[0]['count(*)'] ?> Like</span>
                                        </a>
                                    </span>
                                    <?php
                                }
                                ?>
                                <span class="co">
                                    <a class="comment_btn" href="?addComment=<?php echo $saveTweets[$i]['postid'];?>" id="comment-btn">
                                        <span class="icon"><i class="fa-solid fa-comments"></i></span>
                                        <span><?php echo $interactiveController->numberOfComments("tweet",$saveTweets[$i]['postid'])[0]['count(*)'] ?> Comment</span>
                                    </a>
                                </span>
                                <span class="co">
                                    <a class="retweet_btn" href="?retweet=<?php echo $saveTweets[$i]['postid'];?>&oldid=<?php echo $result[$i]['pid'];?>" id="comment-btn">
                                        <span class="icon"><i class="fa-solid fa-retweet"></i></span>
                                        <span><?php echo $interactiveController->numberOfRetweets($saveTweets[$i]['postid'])[0]['count(*)'] ?> Retweet</span>
                                    </a>
                                </span>
                                <span class="share">
                                    <a href="?share=<?php echo $saveTweets[$i]['postid'] ?>">
                                        <span class="icon"><i class="fa-regular fa-share-from-square"></i></span>
                                        <span>Share</span>
                                    </a>
                                </span>
                                <?php
                                if(isset($_GET['share'])){?>
                                    <div class="retweet_for" id="myForm_retweet">
                                        <form action="" method="POST" class="retweet_form">
                                            <p id="textToCopy"><?php echo "http://localhost/twitter/Views/oneItem.php?postid=".$_GET['share']."" ?></p>
                                            <button class="copy_btn" onclick="copyText()">Copy</button>
                                            <a href="http://localhost/twitter/Views/00.php" class="closeForm2" id="closeForm2">&times;</a>
                                        </form>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    <?php
                    }
                    for($i=0; $i<count($saveRetweets) ; $i++){
                        ?>
                        <div class="sharePost">
                            <img class="userShareimage" src="../Uploads/<?php  echo $personControl->getPersonData($saveRetweets[$i]['id'])->pimage ?>" alt="">
                            <p class="title"><?php echo $personControl->getPersonData($saveRetweets[$i]['retweetpid'])->Fname." ".$personControl->getPersonData($saveRetweets[$i]['retweetpid'])->Lname ?></p>
                            <p class="newContent">
                                <?php echo $saveRetweets[$i]['newContent'];?>
                            </p>
                            <div class="dropdown drop-down">
                                <button class="btn btn-secondary drop-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <ul class="dropdown-menu menu">
                                    <?php
                                        if($personControl->checkFollow('follow',$id,$saveRetweets[$i]['retweetpid'])){ ?>
                                            <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?unfollow=<?php echo $saveRetweets[$i]['retweetpid']; ?>"><i class='bx bx-user-minus' ></i> Unfollow</a></li>
                                    <?php
                                        } else{ ?>
                                            <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?follow=<?php echo $saveRetweets[$i]['retweetpid']; ?>"><i class='bx bx-user-plus' ></i> Follow</a></li>
                                    <?php
                                        }
                                    ?>
                                    <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?mute=<?php echo $saveRetweets[$i]['retweetpid']; ?>"><i class='bx bx-volume-mute' ></i> Mute</a></li>
                                    <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?block=<?php echo $saveRetweets[$i]['retweetpid']; ?>"><i class="fa-solid fa-ban"></i> Block</a></li>
                                    <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_post.php?unSaveRetweet=<?php echo $saveRetweets[$i]['shareid'] ?>&pid=<?php echo $id ?>"><i class="fa-regular fa-bookmark"></i></i> Unsave post</a></li>
                                    <li><a class="dropdown-item" href="http://localhost/twitter/Views/00.php?report=<?php echo $saveRetweets[$i]['retweetpid']; ?>"><i class='bx bx-file-blank' ></i> Report User</a></li>
                                </ul>
                            </div>
                            <div class="old_data">
                                <img class="oldimage" src="../Uploads/<?php  echo $personControl->getPersonData($saveRetweets[$i]['oldid'])->pimage ?>" alt="">
                                <?php
                                ?>
                                <p class="oldtitle"><?php echo $personControl->getPersonData($saveRetweets[$i]['oldid'])->Fname." ".$personControl->getPersonData($saveRetweets[$i]['oldid'])->Lname ?></p>
                                <?php
                                if ($saveRetweets[$i]['image'] != null){?>
                                    <span>
                                        <img src="../Uploads/<?php echo $saveRetweets[$i]['image'];?>" alt="" width="600" height="200" class="postimage">
                                    </span>
                                <?php
                                }
                                ?>
                                <p class="content">
                                    <?php echo $saveRetweets[$i]['content'];?>
                                </p>
                                <?php
                                if($saveRetweets[$i]['hid'] !=null){
                                    $hash1 = $hashtag3->getOneHashtag($saveRetweets[$i]['hid']);
                                    ?>
                                    <span class="postHash">##  <?php echo $hash1 [0]['content'];?></span>
                                <?php 
                                }?>
                                
                            </div>
                            <div class="interactive">
                                <?php
                                if($postControl->checkSaved("retweet_like",$saveRetweets[$i]['shareid'],$id)){?>
                                    <span class="co_Like">
                                        <a class="a" href="manage_post.php?removeRetweetLike=<?php echo $saveRetweets[$i]['shareid']; ?>">
                                            <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                            <span>Like</span>
                                        </a>
                                    </span>
                                    <?php
                                }
                                else{?>
                                    <span class="co">
                                        <a class="a" href="manage_post.php?addRetweetLike=<?php echo $saveRetweets[$i]['shareid']; ?>">
                                            <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                            <span><?php echo $interactiveController->numberOfLikes("retweet",$saveRetweets[$i]['shareid'])[0]['count(*)'] ?> Like</span>
                                        </a>
                                    </span>
                                    <?php
                                }
                                ?>
                                <span class="co">
                                    <a class="comment_btn" href="?retweets&addRetweetComment=<?php echo $saveRetweets[$i]['shareid'];?>" id="comment-btn">
                                        <span class="icon"><i class="fa-solid fa-comments"></i></span>
                                        <span><?php echo $interactiveController->numberOfComments("retweet",$saveRetweets[$i]['shareid'])[0]['count(*)'] ?> Comment</span>
                                    </a>
                                </span>
                                
                                <span class="co">
                                    <a class="retweet_btn" href="?retweetRetweet=<?php echo $saveRetweets[$i]['postid'];?>&oldid=<?php echo $saveRetweets[$i]['oldid'];?>" id="comment-btn">
                                        <span class="icon"><i class="fa-solid fa-retweet"></i></span>
                                        <span><?php echo $interactiveController->numberOfRetweets($saveRetweets[$i]['shareid'])[0]['count(*)'] ?> Retweet</span>
                                    </a>
                                </span>
                                <span class="share">
                                    <a href="?shareretweet=<?php echo $saveRetweets[$i]['shareid'] ?>">
                                        <span class="icon"><i class="fa-regular fa-share-from-square"></i></span>
                                        <span>Share</span>
                                    </a>
                                </span>
                                <?php
                                if(isset($_GET['shareretweet'])){?>
                                    <div class="retweet_for" id="myForm_retweet">
                                        <form action="" method="POST" class="retweet_form">
                                            <p id="textToCopy2"><?php echo "http://localhost/twitter/Views/oneItem.php?retweetid=".$_GET['shareretweet']."" ?></p>
                                            <button class="copy_btn" onclick="copyText2()">Copy</button>
                                            <a href="http://localhost/twitter/Views/00.php" class="closeForm2" id="closeForm2">&times;</a>
                                        </form>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    <?php
                    }
                }
                elseif (isset($_GET['addRetweetComment'])){?>
                    <div class="com_form" id="myForm_com">
                        <form action="http://localhost/twitter/Views/manage_comments.php?retweetid=<?php echo $_GET['addRetweetComment'];?>" method="POST" class="comment_form">
                            <textarea class="post_area" name="content" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' placeholder="Post your reply"></textarea>
                            <div class="easy"><input type="submit" name="reply" value="reply" class="reply_btn"></div>
                            <a href="http://localhost/twitter/Views/00.php" class="closeForm2" id="closeForm2">&times;</a>
                        </form>
                    </div>
                <?php
                }
                elseif (isset($_GET['retweetRetweet'])){?>
                    <div class="retweet_for" id="myForm_retweet">
                        <form action="http://localhost/twitter/Views/manage_post.php?postid=<?php echo $_GET['retweetRetweet'];?>&oldid=<?php echo $_GET['oldid'];?>" method="POST" class="retweet_form">
                            <textarea class="post_area" name="newContent" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' placeholder="Enter New Content if you want!"></textarea>
                            <div class="easy"><input type="submit" name="retweet" value="retweet" class="retweet_btn"></div>
                            <a href="http://localhost/twitter/Views/00.php" class="closeForm2" id="closeForm2">&times;</a>
                        </form>
                    </div>
                <?php
                }
                elseif (isset($_GET['addComment'])){?>
                    <div class="com_form" id="myForm_com">
                        <form action="http://localhost/twitter/Views/manage_comments.php?postid=<?php echo $_GET['addComment'];?>" method="POST" class="comment_form">
                            <textarea class="post_area" name="content" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' placeholder="Post your reply"></textarea>
                            <div class="easy"><input type="submit" name="reply" value="reply" class="reply_btn"></div>
                            <a href="http://localhost/twitter/Views/00.php" class="closeForm2" id="closeForm2">&times;</a>
                        </form>
                    </div>
                <?php
                }
                elseif (isset($_GET['retweet'])){?>
                    <div class="retweet_for" id="myForm_retweet">
                        <form action="http://localhost/twitter/Views/manage_post.php?postid=<?php echo $_GET['retweet'];?>&oldid=<?php echo $_GET['oldid'];?>" method="POST" class="retweet_form">
                            <textarea class="post_area" name="newContent" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' placeholder="Enter New Content if you want!"></textarea>
                            <div class="easy"><input type="submit" name="retweet" value="retweet" class="retweet_btn"></div>
                            <a href="http://localhost/twitter/Views/00.php" class="closeForm2" id="closeForm2">&times;</a>
                        </form>
                    </div>
                <?php
                }
                elseif(isset($_GET['report'])){ ?>
                    <div class="com_form" id="myForm_com">
                        <form action="http://localhost/twitter/Views/manage_users.php?reportPid=<?php echo $_GET['report'];?>" method="POST" class="comment_form">
                            <textarea class="post_area" name="reportContent" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' placeholder="Write you Report..."></textarea>
                            <div class="easy"><input type="submit" name="report" value="Report" class="reply_btn"></div>
                            <a href="http://localhost/twitter/Views/00.php" class="closeForm2" id="closeForm2">&times;</a>
                        </form>
                    </div>
                <?php
                }
                else{?>
                <div class="groups">
                    <?php
                    for($i = 0 ; $i <count($groups); $i++){?>
                        <div class="group">
                            <a href="?groupid=<?php echo $groups[$i]['groupid'];  ?>" class="groupName"><?php echo $groups[$i]['groupName'] ?></a>
                            <span  class="deleteGroup">
                                <a href="http://localhost/twitter/Views/manage_post.php?deleteGroup=<?php echo $groups[$i]['groupid'] ;?>"><i class="fa-solid fa-trash"></i> Delete Group</a>
                            </span>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <?php
                }
                ?>
            <?php
            }
            else{
                echo "<div class='empty'> No Groups </div>";
            }
            ?>
                
            </div>
                            <!-- Start Right bar-->
            <?php include 'rightbar.php'; ?>
            <!-- End Right bar-->
        </div>
    </div>
    <?php 
include 'includes/footer.php' ;

}
else{
    header("location: http://localhost/twitter/Views/Auth/auth.php");
}
?>