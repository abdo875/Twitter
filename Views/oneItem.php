<?php include 'includes/header.php'; 
require_once '../Controllers/PostController.php';
require_once '../Controllers/HashtagController.php';
require_once '../Controllers/personController.php';
require_once '../Controllers/PostCommentController.php';
require_once '../Controllers/AdController.php';
require_once '../Controllers/interactiveController.php';
require_once '../Controllers/retweetPrintController.php';
require_once '../Controllers/tweetPrintController.php';
    $tweetPrintController = new TweetPrintController;
$retweetPrintController= new RetweetPrintController;
    $interactiveController = new InteractiveController;
if(session_status() == 0){
    session_start();
}
elseif(session_status() == 1){
    session_start();
}
if(isset($_SESSION['Aid'])){$id = $_SESSION['Aid'];}
elseif(isset($_SESSION['CCid'])){$id = $_SESSION['CCid'];}
elseif(isset($_SESSION['Uid'])){$id = $_SESSION['Uid'];}
else{$id = 0;}
$personControl = new PersonController;
$postControl = new PostController;
$hashtag = new HashtagController;
$commentControl = new PostCommentController;
$adControl = new AdController;
?>
    <div class="container">
        <div class="row">
            <!-- Start Sidebar-->
            <?php include 'sidebar.php'; ?>
            <!-- End sidebar -->
            <div class="col-2"></div>
            <div class="col-6 post-container" id="post-container">
                <?php
                if(isset($_GET['postid'])){
                    $result = $tweetPrintController->getOneTweet($_GET['postid']);
                    ?>
                    <div class="co_menu">
                        <a href="?postid=<?php echo $_GET['postid'] ?>&comments">Comments</a>
                        <a href="?postid=<?php echo $_GET['postid'] ?>&likes">Likes</a>
                        <a href="?postid=<?php echo $_GET['postid'] ?>&retweets">Retweets</a>
                    </div>
                    <div class="one_post">
                        <img class="pimage-post" src="../Uploads/<?php echo $result[0]['pimage'];?>" alt="">
                        <p class="title"><?php echo $result[0]['Fname'].' '.$result[0]['Lname'] ;?></p>
                        
                        <div class="dropdown drop-down">
                            <button class="btn btn-secondary drop-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <ul class="dropdown-menu menu">
                                <?php
                                    if($personControl->checkFollow('follow',$id,$result[0]['pid'])){ ?>
                                        <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?unfollow=<?php echo $result[0]['pid']; ?>"><i class='bx bx-user-minus' ></i> Unfollow</a></li>
                                <?php
                                    } else{ ?>
                                        <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?follow=<?php echo $result[0]['pid']; ?>"><i class='bx bx-user-plus' ></i> Follow</a></li>
                                <?php
                                    }
                                ?>
                                <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?mute=<?php echo $result[0]['pid']; ?>"><i class='bx bx-volume-mute' ></i> Mute</a></li>
                                <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?block=<?php echo $result[0]['pid']; ?>"><i class="fa-solid fa-ban"></i> Block</a></li>
                                <?php
                                if($postControl->checkSaved('tweet',$result[0]['postid'],$id)){
                                    ?>
                                    <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_post.php?unSaveTweet=<?php echo $result[0]['postid'] ?>&pid=<?php echo $id ?>"><i class="fa-regular fa-bookmark"></i></i><i class="fa-solid fa-slash slash"></i> Unsave post</a></li>
                                <?php
                                }
                                else{
                                    ?>
                                    <li><a class="dropdown-item" href="?postid=<?php echo $result[0]['postid'];?>&saveTweet=<?php echo $result[0]['postid'] ?>"><i class="fa-regular fa-bookmark"></i> Save post</a></li>
                                    <?php
                                }
                                ?>
                                <li><a class="dropdown-item" href="http://localhost/twitter/Views/00.php?postid=<?php echo $result[0]['postid'];?>&report=<?php echo $result[0]['pid']; ?>"><i class='bx bx-file-blank' ></i> Report User</a></li>
                            </ul>
                        </div>
                        <?php
                        if (isset($_GET['saveTweet'])){
                            ?>
                            <div class="com_form" id="myForm_com">
                                <form action="http://localhost/twitter/Views/manage_post.php?saveTweet=<?php echo $_GET['saveTweet'] ?>" method="POST" class="comment_form">
                                    <input class="newGroup" name="newGroup" placeholder="Enter New Group If you want...">
                                    <select class="group_select" name="groupid">
                                        <?php 
                                            $result3 = $retweetPrintController->getGroups($id);
                                            echo "<option value='null'>Choose Group</option>";
                                            for($j = 0; $j < sizeof($result3); $j++){
                                                echo "<option class='groupName' value='".$result3[$j]['groupid']."'>".$result3[$j]['groupName']."</option>";
                                            }
                                        ?>
                                    </select>
                                    <div class="easy"><input type="submit" name="report" value="Save" class="reply_btn"></div>
                                    <a href="http://localhost/twitter/Views/00.php" class="closeForm2" id="closeForm2">&times;</a>
                                </form>
                            </div>
                        <?php
                        }
                        ?>
                        <?php
                        if (isset($_GET['report'])){?>
                            <div class="com_form" id="myForm_com">
                                <form action="http://localhost/twitter/Views/manage_users.php?reportPid=<?php echo $_GET['report'];?>" method="POST" class="comment_form">
                                    <textarea class="post_area" name="reportContent" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' placeholder="Write you Report..."></textarea>
                                    <div class="easy"><input type="submit" name="report" value="Report" class="reply_btn"></div>
                                    <a href="http://localhost/twitter/Views/00.php" class="closeForm2" id="closeForm2">&times;</a>
                                </form>
                            </div>
                        <?php
                        }
                        ?>
                        <?php
                        if ($result[0]['image'] != null){?>
                            <span>
                                <img src="../Uploads/<?php echo $result[0]['image'];?>" alt="" width="600" height="200">
                            </span>
                            <?php
                        }
                        ?>
                        <p class="content">
                            <?php echo $result[0]['content'];?>
                        </p>
                        <?php
                        if($result[0]['hid'] !=null){
                            $hash = $hashtag->getOneHashtag($result[0]['hid']);
                            ?>
                            <span class="postHash">##  <?php echo $hash [0]['content'];?></span>
                            <?php 
                        }?>
                        <div class="interactive">
                            <?php
                            if($postControl->checkSaved("tweet_like",$result[0]['postid'],$id)){?>
                                <span class="co_Like">
                                    <a class="a" href="manage_post.php?removeTweetLike=<?php echo $result[0]['postid']; ?>">
                                        <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                        <span><?php echo $interactiveController->numberOfLikes("tweet",$result[0]['postid'])[0]['count(*)'] ?> Like</span>
                                    </a>
                                </span>
                                <?php
                            }
                            else{?>
                                <span class="co">
                                    <a class="a" href="manage_post.php?addTweetLike=<?php echo $result[0]['postid']; ?>">
                                        <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                        <span><?php echo $interactiveController->numberOfLikes("tweet",$result[0]['postid'])[0]['count(*)'] ?> Like</span>
                                    </a>
                                </span>
                                <?php
                            }
                            ?>
                            <span class="co">
                                <a class="comment_btn" href="?postid=<?php echo $result[0]['postid'];?>&addComment=<?php echo $result[0]['postid'];?>" id="comment-btn">
                                    <span class="icon"><i class="fa-solid fa-comments"></i></span>
                                    <span><?php echo $interactiveController->numberOfComments("tweet",$result[0]['postid'])[0]['count(*)'] ?> Comment</span>
                                </a>
                            </span>
                            <?php
                            if (isset($_GET['addComment'])){?>
                                <div class="com_form" id="myForm_com">
                                    <form action="http://localhost/twitter/Views/manage_comments.php?postid=<?php echo $_GET['addComment'];?>" method="POST" class="comment_form">
                                        <textarea class="post_area" name="content" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' placeholder="Post your reply"></textarea>
                                        <div class="easy"><input type="submit" name="reply" value="reply" class="reply_btn"></div>
                                        <a href="http://localhost/twitter/Views/00.php" class="closeForm2" id="closeForm2">&times;</a>
                                    </form>
                                </div>
                                <?php
                            }
                            ?>
                            <span class="co">
                                <a class="retweet_btn" href="?postid=<?php echo $result[0]['postid'];?>&retweet=<?php echo $result[0]['postid'];?>&oldid=<?php echo $result[0]['pid'];?>" id="comment-btn">
                                    <span class="icon"><i class="fa-solid fa-retweet"></i></span>
                                    <span><?php echo $interactiveController->numberOfRetweets($result[0]['postid'])[0]['count(*)'] ?> Retweet</span>
                                </a>
                            </span>
                            <?php
                            if (isset($_GET['retweet'])){?>
                                <div class="retweet_for" id="myForm_retweet">
                                    <form action="http://localhost/twitter/Views/manage_post.php?postid=<?php echo $_GET['retweet'];?>&oldid=<?php echo $_GET['oldid'];?>" method="POST" class="retweet_form">
                                        <textarea class="post_area" name="newContent" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' placeholder="Enter New Content if you want!"></textarea>
                                        <div class="easy"><input type="submit" name="retweet" value="retweet" class="retweet_btn"></div>
                                        <a href="http://localhost/twitter/Views/00.php" class="closeForm2" id="closeForm2">&times;</a>
                                    </form>
                                </div>
                                <?php
                            }
                            ?>
                            <span class="share">
                                <a href="?postid=<?php echo $result[0]['postid'];?>&share=<?php echo $result[0]['postid'] ?>">
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
                    if(isset($_GET['comments'])){
                        $result2 = $commentControl->getPostComments($_GET['postid']);
                        if(current($result2) == 0){
                            echo "<div class='empty'>No Comments Here</div>";
                        }
                        else{
                            ?>
                            <div class="comments">
                                <?php
                                for($i =0;$i<count($result2);$i++){?>
                                    <div class="comment">
                                        <img class="pimage-post" src="../Uploads/<?php echo $personControl->getPersonData($result2[$i]['pid'])->pimage ;?>" alt="">
                                        <a href="profile.php?pid=<?php echo $result2[$i]['pid']; ?>" class="title"><?php echo $personControl->getPersonData($result2[$i]['pid'])->Fname.' '.$personControl->getPersonData($result2[$i]['pid'])->Lname ;?></a>
                                        <p class="com_content"><?php echo $result2[$i]['comment'] ;?></p>
                                        <?php
                                        if($result[0]['pid'] == $id){
                                            ?>
                                            <span><a href="manage_comments.php?deletePostComment=<?php echo $result2[$i]['cid']; ?>" class="delete"><i class="fa-solid fa-trash"></i> Delete</a></span>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                    }
                    elseif(isset($_GET['likes'])){
                        $result2 = $interactiveController->getLikes("tweet",$_GET['postid']);
                        if(count($result2) == 0){
                            echo "<div class='empty'>No Likes</div>";
                        }
                        else{
                            ?>
                            <div class="comments">
                                <?php
                                for($i =0;$i<count($result2);$i++){?>
                                    <div class="comment">
                                        <img class="pimage-post" src="../Uploads/<?php echo $personControl->getPersonData($result2[$i]['pid'])->pimage ;?>" alt="">
                                        <a href="profile.php?pid=<?php echo $result2[$i]['pid']; ?>" class="title"><?php echo $personControl->getPersonData($result2[$i]['pid'])->Fname.' '.$personControl->getPersonData($result2[$i]['pid'])->Lname ;?></a>
                                        <?php
                                        if($personControl->checkFollow('follow',$id,$result2[$i]['pid'])){ ?>
                                            <span><a class="follow" href="http://localhost/twitter/Views/manage_users.php?unfollow=<?php echo $result2[$i]['pid']; ?>">- Unfollow</a></span>
                                        <?php
                                            } else{ ?>
                                                <span><a class="follow" href="http://localhost/twitter/Views/manage_users.php?follow=<?php echo $result2[$i]['pid']; ?>">+ Follow</a></span>
                                        <?php
                                            }
                                        ?>
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
                    elseif(isset($_GET['retweets'])){
                        $result2 = $retweetPrintController->getRetweetsInfo($_GET['postid'], $id);
                        if(count($result2) == 0){
                            echo "<div class='empty'>No Retweets</div>";
                        }
                        else{
                            ?>
                            <div class="comments">
                                <?php
                                for($i =0;$i<count($result2);$i++){?>
                                    <div class="comment">
                                        <img class="pimage-post" src="../Uploads/<?php echo $personControl->getPersonData($result2[$i]['retweetpid'])->pimage ;?>" alt="">
                                        <a href="profile.php?pid=<?php echo $result2[$i]['retweetpid']; ?>" class="title"><?php echo $personControl->getPersonData($result2[$i]['retweetpid'])->Fname.' '.$personControl->getPersonData($result2[$i]['retweetpid'])->Lname ;?></a>
                                        <?php
                                        if($personControl->checkFollow('follow',$id,$result2[$i]['retweetpid'])){ ?>
                                            <span><a class="follow" href="http://localhost/twitter/Views/manage_users.php?unfollow=<?php echo $result2[$i]['retweetpid']; ?>">- Unfollow</a></span>
                                        <?php
                                            } else{ ?>
                                                <span><a class="follow" href="http://localhost/twitter/Views/manage_users.php?follow=<?php echo $result2[$i]['retweetpid']; ?>">+ Follow</a></span>
                                        <?php
                                            }
                                        ?>
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
                    ?>
                <?php
                }
                elseif(isset($_GET['retweetid'])){
                    $result5 = $retweetPrintController->getOneRetweet($_GET['retweetid']);
                    ?>
                    <div class="co_menu">
                        <a href="?retweetid=<?php echo $_GET['retweetid'] ?>&comments">Comments</a>
                        <a href="?retweetid=<?php echo $_GET['retweetid'] ?>&likes">Likes</a>
                        <a href="?retweetid=<?php echo $_GET['retweetid'] ?>&retweets=<?php  echo $result5[0]['postid'] ?>">Retweets</a>
                    </div>
                    <div class="sharePost">
                        <img class="userShareimage" src="../Uploads/<?php  echo $personControl->getPersonData($result5[0]['retweetpid'])->pimage ?>" alt="">
                        <p class="title"><?php echo $personControl->getPersonData($result5[0]['retweetpid'])->Fname." ".$personControl->getPersonData($result5[0]['retweetpid'])->Lname ?></p>
                        <p class="newContent">
                            <?php echo $result5[0]['newContent'];?>
                        </p>
                        <div class="dropdown drop-down">
                            <button class="btn btn-secondary drop-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <ul class="dropdown-menu menu">
                                <?php
                                    if($personControl->checkFollow('follow',$id,$result5[0]['pid'])){ ?>
                                        <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?unfollow=<?php echo $result5[0]['pid']; ?>"><i class='bx bx-user-minus' ></i> Unfollow</a></li>
                                <?php
                                    } else{ ?>
                                        <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?follow=<?php echo $result5[0]['pid']; ?>"><i class='bx bx-user-plus' ></i> Follow</a></li>
                                <?php
                                    }
                                ?>
                                <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?mute=<?php echo $result5[0]['pid']; ?>"><i class='bx bx-volume-mute' ></i> Mute</a></li>
                                <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?block=<?php echo $result5[0]['pid']; ?>"><i class="fa-solid fa-ban"></i> Block</a></li>
                                <?php
                                if($postControl->checkSaved('retweet',$result5[0]['shareid'],$id)){
                                    ?>
                                    <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_post.php?unSaveRetweet=<?php echo $result5[0]['shareid'] ?>&pid=<?php echo $id ?>"><i class="fa-regular fa-bookmark"></i></i> Unsave post</a></li>
                                <?php
                                }
                                else{
                                    ?>
                                    <li><a class="dropdown-item" href="?retweetid=<?php echo $_GET['retweetid'];?>&saveRetweet=<?php echo $result5[0]['shareid'] ?>"><i class="fa-regular fa-bookmark"></i> Save post</a></li>
                                    <?php
                                }
                                ?>
                                <li><a class="dropdown-item" href="http://localhost/twitter/Views/00.php?retweetid=<?php echo $_GET['retweetid'];?>&report=<?php echo $result5[0]['retweetpid']; ?>"><i class='bx bx-file-blank' ></i> Report User</a></li>
                            </ul>
                        </div>
                        <?php
                        if (isset($_GET['saveRetweet'])){
                            ?>
                            <div class="com_form" id="myForm_com">
                                <form action="http://localhost/twitter/Views/manage_post.php?saveRetweet=<?php echo $_GET['saveRetweet'] ?>" method="POST" class="comment_form">
                                    <input class="newGroup" name="newGroup" placeholder="Enter New Group If you want...">
                                    <select class="group_select" name="groupid">
                                        <?php 
                                            $result3 = $retweetPrintController->getGroups($id);
                                            echo "<option value='null'>Choose Group</option>";
                                            for($j = 0; $j < sizeof($result3); $j++){
                                                echo "<option class='groupName' value='".$result3[$j]['groupid']."'>".$result3[$j]['groupName']."</option>";
                                            }
                                        ?>
                                    </select>
                                    <div class="easy"><input type="submit" name="report" value="Save" class="reply_btn"></div>
                                    <a href="http://localhost/twitter/Views/00.php" class="closeForm2" id="closeForm2">&times;</a>
                                </form>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="old_data">
                            <img class="oldimage" src="../Uploads/<?php  echo $personControl->getPersonData($result5[0]['oldid'])->pimage ?>" alt="">
                            <?php
                            ?>
                            <p class="oldtitle"><?php echo $personControl->getPersonData($result5[0]['oldid'])->Fname." ".$personControl->getPersonData($result5[0]['oldid'])->Lname ?></p>
                            <?php
                            if ($result5[0]['image'] != null){?>
                                <span>
                                    <img src="../Uploads/<?php echo $result5[0]['image'];?>" alt="" width="600" height="200" class="postimage">
                                </span>
                            <?php
                            }
                            ?>
                            <p class="content">
                                <?php echo $result5[0]['content'];?>
                            </p>
                            <?php
                            if($result5[0]['hid'] !=null){
                                $hash1 = $hashtag->getOneHashtag($result5[0]['hid']);
                                ?>
                                <span class="postHash">##  <?php echo $hash1 [0]['content'];?></span>
                            <?php 
                            }?>
                            
                        </div>
                        <div class="interactive">
                            <?php
                            if($postControl->checkSaved("retweet_like",$result5[0]['shareid'],$id)){?>
                                <span class="co_Like">
                                    <a class="a" href="manage_post.php?removeRetweetLike=<?php echo $result5[0]['shareid']; ?>">
                                        <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                        <span><?php echo $interactiveController->numberOfLikes("retweet",$result5[0]['shareid'])[0]['count(*)'] ?> Like</span>
                                    </a>
                                </span>
                                <?php
                            }
                            else{?>
                                <span class="co">
                                    <a class="a" href="manage_post.php?addRetweetLike=<?php echo $result5[0]['shareid']; ?>">
                                        <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                        <span><?php echo $interactiveController->numberOfLikes("retweet",$result5[0]['shareid'])[0]['count(*)'] ?> Like</span>
                                    </a>
                                </span>
                                <?php
                            }
                            ?>
                            <span class="co">
                                <a class="comment_btn" href="?retweetid=<?php echo $_GET['retweetid'] ?>&addRetweetComment=<?php echo $result5[0]['shareid'];?>" id="comment-btn">
                                    <span class="icon"><i class="fa-solid fa-comments"></i></span>
                                    <span><?php echo $interactiveController->numberOfLikes("retweet",$result5[0]['shareid'])[0]['count(*)'] ?> Comment</span>
                                </a>
                            </span>
                            <?php
                            if (isset($_GET['addRetweetComment'])){?>
                                <div class="com_form" id="myForm_com">
                                    <form action="http://localhost/twitter/Views/manage_comments.php?retweetid=<?php echo $_GET['addRetweetComment'];?>" method="POST" class="comment_form">
                                        <textarea class="post_area" name="content" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' placeholder="Post your reply"></textarea>
                                        <div class="easy"><input type="submit" name="reply" value="reply" class="reply_btn"></div>
                                        <a href="http://localhost/twitter/Views/00.php" class="closeForm2" id="closeForm2">&times;</a>
                                    </form>
                                </div>
                            <?php
                            }
                            ?>
                            <span class="co">
                                <a class="retweet_btn" href="?retweetid=<?php echo $_GET['retweetid'] ?>&retweetRetweet=<?php echo $result5[0]['postid'];?>&oldid=<?php echo $result5[0]['oldid'];?>" id="comment-btn">
                                    <span class="icon"><i class="fa-solid fa-retweet"></i></span>
                                    <span><?php echo $interactiveController->numberOfRetweets($result5[0]['shareid'])[0]['count(*)'] ?> Retweet</span>
                                </a>
                            </span>
                            <?php
                            if (isset($_GET['retweetRetweet'])){?>
                                <div class="retweet_for" id="myForm_retweet">
                                    <form action="http://localhost/twitter/Views/manage_post.php?postid=<?php echo $_GET['retweetRetweet'];?>&oldid=<?php echo $_GET['oldid'];?>" method="POST" class="retweet_form">
                                        <textarea class="post_area" name="newContent" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' placeholder="Enter New Content if you want!"></textarea>
                                        <div class="easy"><input type="submit" name="retweet" value="retweet" class="retweet_btn"></div>
                                        <a href="http://localhost/twitter/Views/00.php" class="closeForm2" id="closeForm2">&times;</a>
                                    </form>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <span class="share">
                                <a href="?retweetid=<?php echo $_GET['retweetid'] ?>&shareretweet=<?php echo $result5[0]['shareid'] ?>">
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
                    if(isset($_GET['comments'])){
                        $result2 = $commentControl->getRetweetComments($_GET['retweetid']);
                        if(current($result2) == 0){
                            echo "<div class='empty'>No Comments Here</div>";
                        }
                        else{
                            ?>
                            <div class="comments">
                                <?php
                                for($i =0;$i<count($result2);$i++){?>
                                    <div class="comment">
                                        <img class="pimage-post" src="../Uploads/<?php echo $personControl->getPersonData($result2[$i]['pid'])->pimage ;?>" alt="">
                                        <a href="profile.php?pid=<?php echo $result2[$i]['pid']; ?>" class="title"><?php echo $personControl->getPersonData($result2[$i]['pid'])->Fname.' '.$personControl->getPersonData($result2[$i]['pid'])->Lname ;?></a>
                                        <p class="com_content"><?php echo $result2[$i]['content'] ;?></p>
                                        <?php
                                        if($result2[$i]['pid'] == $id){?>
                                            <span><a href="manage_comments.php?deleteRetweetComment=<?php echo $result2[$i]['cid']; ?>" class="delete"><i class="fa-solid fa-trash"></i> Delete</a></span>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                    }
                    elseif(isset($_GET['likes'])){
                        $result2 = $interactiveController->getLikes("retweet",$_GET['retweetid']);
                        if(count($result2) == 0){
                            echo "<div class='empty'>No Likes</div>";
                        }
                        else{
                            ?>
                            <div class="comments">
                                <?php
                                for($i =0;$i<count($result2);$i++){?>
                                    <div class="comment">
                                        <img class="pimage-post" src="../Uploads/<?php echo $personControl->getPersonData($result2[$i]['pid'])->pimage ;?>" alt="">
                                        <a href="profile.php?pid=<?php echo $result2[$i]['pid']; ?>" class="title"><?php echo $personControl->getPersonData($result2[$i]['pid'])->Fname.' '.$personControl->getPersonData($result2[$i]['pid'])->Lname ;?></a>
                                        <?php
                                        if($personControl->checkFollow('follow',$id,$result2[$i]['pid'])){ ?>
                                            <span><a class="follow" href="http://localhost/twitter/Views/manage_users.php?unfollow=<?php echo $result2[$i]['pid']; ?>">- Unfollow</a></span>
                                        <?php
                                            } else{ ?>
                                                <span><a class="follow" href="http://localhost/twitter/Views/manage_users.php?follow=<?php echo $result2[$i]['pid']; ?>">+ Follow</a></span>
                                        <?php
                                            }
                                        ?>
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
                    elseif(isset($_GET['retweets'])){?>
                        <?php
                        $result2 = $retweetPrintController->getRetweetsInfo($_GET['retweets'], $id);
                        if(count($result2) == 0){
                            echo "<div class='empty'>No Retweets</div>";
                        }
                        else{
                            ?>
                            <div class="comments">
                                <?php
                                for($i =0;$i<count($result2);$i++){?>
                                    <div class="comment">
                                        <img class="pimage-post" src="../Uploads/<?php echo $personControl->getPersonData($result2[$i]['retweetpid'])->pimage ;?>" alt="">
                                        <a href="profile.php?pid=<?php echo $result2[$i]['retweetpid']; ?>" class="title"><?php echo $personControl->getPersonData($result2[$i]['retweetpid'])->Fname.' '.$personControl->getPersonData($result2[$i]['retweetpid'])->Lname ;?></a>
                                        <?php
                                        if($personControl->checkFollow('follow',$id,$result2[$i]['retweetpid'])){ ?>
                                            <span><a class="follow" href="http://localhost/twitter/Views/manage_users.php?unfollow=<?php echo $result2[$i]['retweetpid']; ?>">- Unfollow</a></span>
                                        <?php
                                            } else{ ?>
                                                <span><a class="follow" href="http://localhost/twitter/Views/manage_users.php?follow=<?php echo $result2[$i]['retweetpid']; ?>">+ Follow</a></span>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                <?php
                }
                elseif(isset($_GET['adid'])){
                    $result = $adControl->getOneAd($_GET['adid']);
                    ?>
                    <div class="ad_menu">
                        <a href="?adid=<?php echo $_GET['adid'] ?>&comments">Comments</a>
                        <a href="?adid=<?php echo $_GET['adid'] ?>&likes">Likes</a>
                    </div>
                    <div class="Ad">
                        <img class="pimage-post" src="../Uploads/<?php echo $result[0]['pimage']; ?>" alt="">
                        <p class="title"><?php echo $result[0]['Fname']; ?> <?php echo $result[0]['Lname']; ?></p>
                        <?php
                        if($result[0]['image'] != ''){?>
                            <span>
                                <img src="../Uploads/<?php echo $result[0]['image']; ?>" alt="" width="600" height="200">
                            </span>
                        <?php
                        }
                        ?>
                        <?php
                        if($result[0]['content'] != ''){?>
                            <p class="content">
                                <?php echo $result[0]['content']; ?>
                            </p>
                        <?php
                        }
                        ?>
                        
                        <div class="interactive">
                            <?php
                            if($adControl->check($result[0]['Adid'],$id)){?>
                                <span class="co_Like">
                                    <a class="a" href="manage_ads.php?removeAdLike=<?php echo $result[0]['Adid']; ?>">
                                        <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                        <span><?php echo $interactiveController->numberOfLikes("ad",$result[0]['Adid'])[0]['count(*)'] ?> Like</span>
                                    </a>
                                </span>
                                <?php
                            }
                            else{?>
                                <span class="co">
                                    <a class="a" href="manage_ads.php?addAdLike=<?php echo $result[0]['Adid']; ?>">
                                        <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                        <span><?php echo $interactiveController->numberOfLikes("ad",$result[0]['Adid'])[0]['count(*)'] ?> Like</span>
                                    </a>
                                </span>
                                <?php
                            }
                            ?>
                            <span class="co">
                                <a class="comment_btn" href="?adid=<?php echo $_GET['adid'] ?>&addComment=<?php echo $result[0]['Adid'] ?>" id="comment-btn">
                                    <span class="icon"><i class="fa-solid fa-comments"></i></span>
                                    <span><?php echo $interactiveController->numberOfComments("ad",$result[0]['Adid'])[0]['count(*)'] ?> Comment</span>
                                </a>
                            </span>
                            <span class="share">
                                <a href="?adid=<?php echo $_GET['adid'] ?>&sharead=<?php echo $result[0]['Adid'] ?>">
                                    <span class="icon"><i class="fa-regular fa-share-from-square"></i></span>
                                    <span>Share</span>
                                </a>
                            </span>
                            <?php
                            if(isset($_GET['sharead'])){?>
                                <div class="retweet_for" id="myForm_retweet">
                                    <form action="" method="POST" class="retweet_form">
                                        <p id="textToCopy3"><?php echo "http://localhost/twitter/Views/oneItem.php?adid=".$_GET['sharead']."" ?></p>
                                        <button class="copy_btn" onclick="copyText3()">Copy</button>
                                        <a href="http://localhost/twitter/Views/00.php" class="closeForm2" id="closeForm2">&times;</a>
                                    </form>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                        if (isset($_GET['addComment'])){?>
                            <div class="Ad_com_form" id="myForm_com">
                                <form action="http://localhost/twitter/Views/manage_comments.php?adid=<?php echo $_GET['addComment'];?>" method="POST" class="comment_form">
                                    <textarea class="post_area" name="content" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' placeholder="Post your reply"></textarea>
                                    <div class="easy"><input type="submit" name="reply" value="reply" class="reply_btn"></div>
                                    <a href="http://localhost/twitter/Views/00.php" class="closeForm2" id="closeForm2">&times;</a>
                                </form>
                            </div>
                            <?php
                        }
                        elseif (isset($_GET['report'])){?>
                            <div class="Ad_com_form" id="myForm_com">
                                <form action="http://localhost/twitter/Views/manage_users.php?reportPid=<?php echo $_GET['report']; ?>" method="POST" class="comment_form">
                                    <textarea class="post_area" name="reportContent" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' placeholder="Write you Report..."></textarea>
                                    <div class="easy"><input type="submit" name="report" value="Report" class="reply_btn"></div>
                                    <a href="http://localhost/twitter/Views/00.php" class="closeForm2" id="closeForm2">&times;</a>
                                </form>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <?php
                    if(isset($_GET['comments'])){
                        $result2 = $commentControl->getAdComments($_GET['adid']);
                        if(current($result2) == 0){
                            echo "<div class='empty'>No Comments Here</div>";
                        }
                        else{
                            ?>
                            <div class="comments">
                                <?php
                                for($i =0;$i<count($result2);$i++){?>
                                    <div class="comment">
                                        <img class="pimage-post" src="../Uploads/<?php echo $personControl->getPersonData($result2[$i]['pid'])->pimage ;?>" alt="">
                                        <a href="profile.php?pid=<?php echo $result2[$i]['pid']; ?>" class="title"><?php echo $personControl->getPersonData($result2[$i]['pid'])->Fname.' '.$personControl->getPersonData($result2[$i]['pid'])->Lname ;?></a>
                                        <p class="com_content"><?php echo $result2[$i]['comment'] ;?></p>
                                        <?php
                                        if($result2[$i]['pid'] == $id){?>
                                            <span><a href="manage_comments.php?deleteAdComment=<?php echo $result2[$i]['cid']; ?>" class="delete"><i class="fa-solid fa-trash"></i> Delete</a></span>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                    }
                    elseif(isset($_GET['likes'])){
                        $result2 = $interactiveController->getLikes("ad",$_GET['adid']);
                        if(count($result2) == 0){
                            echo "<div class='empty'>No Likes</div>";
                        }
                        else{
                            ?>
                            <div class="comments">
                                <?php
                                for($i =0;$i<count($result2);$i++){?>
                                    <div class="comment">
                                        <img class="pimage-post" src="../Uploads/<?php echo $personControl->getPersonData($result2[$i]['pid'])->pimage ;?>" alt="">
                                        <a href="profile.php?pid=<?php echo $result2[$i]['pid']; ?>" class="title"><?php echo $personControl->getPersonData($result2[$i]['pid'])->Fname.' '.$personControl->getPersonData($result2[$i]['pid'])->Lname ;?></a>
                                        <?php
                                        if($personControl->checkFollow('follow',$id,$result2[$i]['pid'])){ ?>
                                            <span><a class="follow" href="http://localhost/twitter/Views/manage_users.php?unfollow=<?php echo $result2[$i]['pid']; ?>">- Unfollow</a></span>
                                        <?php
                                            } else{ ?>
                                                <span><a class="follow" href="http://localhost/twitter/Views/manage_users.php?follow=<?php echo $result2[$i]['pid']; ?>">+ Follow</a></span>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                        <?php
                    }?>
                <?php
                }
                ?>
            </div>
            <!-- Start Right bar-->
            <?php include 'rightbar.php'; ?>
            <!-- End Right bar-->
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>