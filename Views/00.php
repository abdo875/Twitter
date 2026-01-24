
<?php include 'includes/header.php' ;
    require_once '../Controllers/PostController.php';
    require_once '../Controllers/personController.php';
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
?>
    <div class="container">
        <div class="row">
            <!-- Start Sidebar-->
            <?php include 'sidebar.php'; ?>
            <!-- End sidebar -->
            <div class="col-2"></div>
            <div class="col-6 post-container" id="post-container">
                <!-- Start Search Tweet Form-->
                <form action="?search" method="POST">
                    <div class="search-tweet">
                        <input name="search" type="text" class="" placeholder="Search for Tweet!">
                        <input type="submit" value="Search" class="search-button" type="button"></input>
                    </div>
                </form>
                <?php
                if(isset($_GET['search'])){
                    $postControl = new PostController;
                    $personControl = new PersonController;
                    $hashtag2 = new HashtagController;
                    $result = $tweetPrintController->getSomeTweet($_POST['search']);
                    for( $i = 0 ; $i < count($result); $i++){
                        ?>
                        <div class="post">
                            <img class="pimage-post" src="../Uploads/<?php echo $result[$i]['pimage'];?>" alt="">
                            <p class="title"><?php echo $result[$i]['Fname'].' '.$result[$i]['Lname'] ;?></p>
                            
                            <div class="dropdown drop-down">
                                <button class="btn btn-secondary drop-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <ul class="dropdown-menu menu">
                                    <?php
                                        if($personControl->checkFollow('follow',$id,$result[$i]['pid'])){ ?>
                                            <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?unfollow=<?php echo $result[$i]['pid']; ?>"><i class='bx bx-user-minus' ></i> Unfollow</a></li>
                                    <?php
                                        } else{ ?>
                                            <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?follow=<?php echo $result[$i]['pid']; ?>"><i class='bx bx-user-plus' ></i> Follow</a></li>
                                    <?php
                                        }
                                    ?>
                                    <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?mute=<?php echo $result[$i]['pid']; ?>"><i class='bx bx-volume-mute' ></i> Mute</a></li>
                                    <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?block=<?php echo $result[$i]['pid']; ?>"><i class="fa-solid fa-ban"></i> Block</a></li>
                                    <?php
                                    if($postControl->checkSaved('tweet',$result[$i]['postid'],$id)){
                                        ?>
                                        <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_post.php?unSaveTweet=<?php echo $result[$i]['postid'] ?>&pid=<?php echo $id ?>"><i class="fa-regular fa-bookmark"></i></i><i class="fa-solid fa-slash slash"></i> Unsave post</a></li>
                                    <?php
                                    }
                                    else{
                                        ?>
                                        <li><a class="dropdown-item" href="?saveTweet=<?php echo $result[$i]['postid'] ?>"><i class="fa-regular fa-bookmark"></i> Save post</a></li>
                                        <?php
                                    }
                                    ?>
                                    <li><a class="dropdown-item" href="http://localhost/twitter/Views/00.php?report=<?php echo $result[$i]['pid']; ?>"><i class='bx bx-file-blank' ></i> Report User</a></li>
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
                            if ($result[$i]['image'] != null){?>
                                <span>
                                    <img src="../Uploads/<?php echo $result[$i]['image'];?>" alt="" width="600" height="200">
                                </span>
                            <?php
                            }
                            ?>
                            <p class="content">
                                <?php echo $result[$i]['content'];?>
                            </p>
                            <?php
                            if($result[$i]['hid'] !=null){
                                $hash = $hashtag2->getOneHashtag($result[$i]['hid']);
                                ?>
                                <span class="postHash">##  <?php echo $hash [0]['content'];?></span>
                            <?php 
                            }?>
                            <div class="interactive">
                                <?php
                                if($postControl->checkSaved("tweet_like",$result[$i]['postid'],$id)){?>
                                    <span class="co_Like">
                                        <a class="a" href="manage_post.php?removeTweetLike=<?php echo $result[$i]['postid']; ?>">
                                            <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                            <span><?php echo $interactiveController->numberOfLikes("tweet",$result[$i]['postid'])[0]['count(*)'] ?> Like</span>
                                        </a>
                                    </span>
                                    <?php
                                }
                                else{?>
                                    <span class="co">
                                        <a class="a" href="manage_post.php?addTweetLike=<?php echo $result[$i]['postid']; ?>">
                                            <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                            <span><?php echo $interactiveController->numberOfLikes("tweet",$result[$i]['postid'])[0]['count(*)'] ?> Like</span>
                                        </a>
                                    </span>
                                    <?php
                                }
                                ?>
                                <span class="co">
                                    <a class="comment_btn" href="?addComment=<?php echo $result[$i]['postid'];?>" id="comment-btn">
                                        <span class="icon"><i class="fa-solid fa-comments"></i></span>
                                        <span><?php echo $interactiveController->numberOfComments("tweet",$result[$i]['postid'])[0]['count(*)'] ?> Comment</span>
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
                                    <a class="retweet_btn" href="?retweet=<?php echo $result[$i]['postid'];?>&oldid=<?php echo $result[$i]['pid'];?>" id="comment-btn">
                                        <span class="icon"><i class="fa-solid fa-retweet"></i></span>
                                        <span><?php echo $interactiveController->numberOfRetweets($result[$i]['postid'])[0]['count(*)'] ?> Retweet</span>
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
                                    <a href="?share=<?php echo $result[$i]['postid'] ?>">
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
                    $postController = new PostController;
                    $hashtag3 = new HashtagController;
                    $oldPersonControl = new PersonController;
                    $result5 = $retweetPrintController->getSomeRetweet($_POST['search']);
                    for($i=0; $i<count($result5) ; $i++){?>
                        <div class="sharePost">
                            <img class="userShareimage" src="../Uploads/<?php  echo $oldPersonControl->getPersonData($result5[$i]['retweetpid'])->pimage ?>" alt="">
                            <p class="title"><?php echo $oldPersonControl->getPersonData($result5[$i]['retweetpid'])->Fname." ".$oldPersonControl->getPersonData($result5[$i]['retweetpid'])->Lname ?></p>
                            <p class="newContent">
                                <?php echo $result5[$i]['newContent'];?>
                            </p>
                            <div class="dropdown drop-down">
                                <button class="btn btn-secondary drop-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <ul class="dropdown-menu menu">
                                    <?php
                                        if($personControl->checkFollow('follow',$id,$result5[$i]['pid'])){ ?>
                                            <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?unfollow=<?php echo $result5[$i]['retweetpid']; ?>"><i class='bx bx-user-minus' ></i> Unfollow</a></li>
                                    <?php
                                        } else{ ?>
                                            <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?follow=<?php echo $result5[$i]['retweetpid']; ?>"><i class='bx bx-user-plus' ></i> Follow</a></li>
                                    <?php
                                        }
                                    ?>
                                    <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?mute=<?php echo $result5[$i]['retweetpid']; ?>"><i class='bx bx-volume-mute' ></i> Mute</a></li>
                                    <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?block=<?php echo $result5[$i]['retweetpid']; ?>"><i class="fa-solid fa-ban"></i> Block</a></li>
                                    <?php
                                    if($postControl->checkSaved('retweet',$result5[$i]['shareid'],$id)){
                                        ?>
                                        <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_post.php?unSaveRetweet=<?php echo $result5[$i]['shareid'] ?>&pid=<?php echo $id ?>"><i class="fa-regular fa-bookmark"></i></i><i class="fa-solid fa-slash slash"></i> Unsave post</a></li>
                                    <?php
                                    }
                                    else{
                                        ?>
                                        <li><a class="dropdown-item" href="?saveRetweet=<?php echo $result5[$i]['shareid'] ?>"><i class="fa-regular fa-bookmark"></i> Save post</a></li>
                                        <?php
                                    }
                                    ?>
                                    <li><a class="dropdown-item" href="http://localhost/twitter/Views/00.php?report=<?php echo $result5[$i]['retweetpid']; ?>"><i class='bx bx-file-blank' ></i> Report User</a></li>
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
                                <img class="oldimage" src="../Uploads/<?php  echo $oldPersonControl->getPersonData($result5[$i]['oldid'])->pimage ?>" alt="">
                                <?php
                                ?>
                                <p class="oldtitle"><?php echo $oldPersonControl->getPersonData($result5[$i]['oldid'])->Fname." ".$oldPersonControl->getPersonData($result5[$i]['oldid'])->Lname ?></p>
                                <?php
                                if ($result5[$i]['image'] != null){?>
                                    <span>
                                        <img src="../Uploads/<?php echo $result5[$i]['image'];?>" alt="" width="600" height="200" class="postimage">
                                    </span>
                                <?php
                                }
                                ?>
                                <p class="content">
                                    <?php echo $result5[$i]['content'];?>
                                </p>
                                <?php
                                if($result5[$i]['hid'] !=null){
                                    $hash1 = $hashtag3->getOneHashtag($result5[$i]['hid']);
                                    ?>
                                    <span class="postHash">##  <?php echo $hash1 [0]['content'];?></span>
                                <?php 
                                }?>
                                
                            </div>
                            <div class="interactive">
                                <?php
                                if($postControl->checkSaved("retweet_like",$result5[$i]['shareid'],$id)){?>
                                    <span class="co_Like">
                                        <a class="a" href="manage_post.php?removeRetweetLike=<?php echo $result5[$i]['shareid']; ?>">
                                            <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                            <span><?php echo $interactiveController->numberOfLikes("retweet",$result5[$i]['shareid'])[0]['count(*)'] ?> Like</span>
                                        </a>
                                    </span>
                                    <?php
                                }
                                else{?>
                                    <span class="co">
                                        <a class="a" href="manage_post.php?addRetweetLike=<?php echo $result5[$i]['shareid']; ?>">
                                            <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                            <span><?php echo $interactiveController->numberOfLikes("retweet",$result5[$i]['shareid'])[0]['count(*)'] ?> Like</span>
                                        </a>
                                    </span>
                                    <?php
                                }
                                ?>
                                <span class="co">
                                    <a class="comment_btn" href="?retweets&addRetweetComment=<?php echo $result5[$i]['shareid'];?>" id="comment-btn">
                                        <span class="icon"><i class="fa-solid fa-comments"></i></span>
                                        <span><?php echo $interactiveController->numberOfComments("retweet",$result5[$i]['shareid'])[0]['count(*)'] ?> Comment</span>
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
                                    <a class="retweet_btn" href="?retweetRetweet=<?php echo $result5[$i]['postid'];?>&oldid=<?php echo $result5[$i]['oldid'];?>" id="comment-btn">
                                        <span class="icon"><i class="fa-solid fa-retweet"></i></span>
                                        <span><?php echo $interactiveController->numberOfRetweets($result5[$i]['postid'])[0]['count(*)'] ?> Retweet</span>
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
                                    <a href="?shareretweet=<?php echo $result5[$i]['shareid'] ?>">
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
                                <?php
                                if(isset($_GET['share'])){?>
                                    <div class="retweet_for" id="myForm_retweet">
                                        <form action="" method="POST" class="retweet_form">
                                            <p id="textToCopy"><?php echo "http://localhost/twitter/Views/oneItem.php?postid=".$result[$i]['postid']."" ?></p>
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
                }
                else{
                    ?>
                    <!-- Start Post-->
                    <div class="type">
                        <a href="#" class="for_you active">For you</a>
                        <span class="vl"></span>
                        <a href="#" class="following">Following</a>
                    </div>
                    <?php 
                    if (isset($_SESSION['uname'])){
                        $postControl = new PostController;
                        $personControl = new PersonController;
                        $result = $tweetPrintController->getPublicPostWithoutMine($id);
                        $hashtag2 = new HashtagController;
                        for( $i = 0 ; $i < count($result); $i++){
                            ?>
                            <div class="post">
                                <img class="pimage-post" src="../Uploads/<?php echo $result[$i]['pimage'];?>" alt="">
                                <p class="title"><?php echo $result[$i]['Fname'].' '.$result[$i]['Lname'] ;?></p>
                                
                                <div class="dropdown drop-down">
                                    <button class="btn btn-secondary drop-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu menu">
                                        <?php
                                            if($personControl->checkFollow('follow',$id,$result[$i]['pid'])){ ?>
                                                <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?unfollow=<?php echo $result[$i]['pid']; ?>"><i class='bx bx-user-minus' ></i> Unfollow</a></li>
                                        <?php
                                            } else{ ?>
                                                <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?follow=<?php echo $result[$i]['pid']; ?>"><i class='bx bx-user-plus' ></i> Follow</a></li>
                                        <?php
                                            }
                                        ?>
                                        <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?mute=<?php echo $result[$i]['pid']; ?>"><i class='bx bx-volume-mute' ></i> Mute</a></li>
                                        <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?block=<?php echo $result[$i]['pid']; ?>"><i class="fa-solid fa-ban"></i> Block</a></li>
                                        <?php
                                        if($postControl->checkSaved('tweet',$result[$i]['postid'],$id)){
                                            ?>
                                            <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_post.php?unSaveTweet=<?php echo $result[$i]['postid'] ?>&pid=<?php echo $id ?>"><i class="fa-regular fa-bookmark"></i></i><i class="fa-solid fa-slash slash"></i> Unsave post</a></li>
                                        <?php
                                        }
                                        else{
                                            ?>
                                            <li><a class="dropdown-item" href="?saveTweet=<?php echo $result[$i]['postid'] ?>"><i class="fa-regular fa-bookmark"></i> Save post</a></li>
                                            <?php
                                        }
                                        ?>
                                        <li><a class="dropdown-item" href="http://localhost/twitter/Views/00.php?report=<?php echo $result[$i]['pid']; ?>"><i class='bx bx-file-blank' ></i> Report User</a></li>
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
                                if ($result[$i]['image'] != null){?>
                                    <span>
                                        <img src="../Uploads/<?php echo $result[$i]['image'];?>" alt="" width="600" height="200">
                                    </span>
                                    <?php
                                }
                                ?>
                                <p class="content">
                                    <?php echo $result[$i]['content'];?>
                                </p>
                                    <?php
                                if($result[$i]['hid'] !=null){
                                    $hash = $hashtag2->getOneHashtag($result[$i]['hid']);
                                    ?>
                                    <span class="postHash">##  <?php echo $hash [0]['content'];?></span>
                                <?php 
                                }?>
                                <div class="interactive">
                                    <?php
                                    if($postControl->checkSaved("tweet_like",$result[$i]['postid'],$id)){?>
                                        <span class="co_Like">
                                            <a class="a" href="manage_post.php?removeTweetLike=<?php echo $result[$i]['postid']; ?>">
                                                <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                                <span><?php echo $interactiveController->numberOfLikes("tweet",$result[$i]['postid'])[0]['count(*)'] ?> Like</span>
                                            </a>
                                        </span>
                                        <?php
                                    }
                                    else{?>
                                        <span class="co">
                                            <a class="a" href="manage_post.php?addTweetLike=<?php echo $result[$i]['postid']; ?>">
                                                <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                                <span><?php echo $interactiveController->numberOfLikes("tweet",$result[$i]['postid'])[0]['count(*)'] ?> Like</span>
                                            </a>
                                        </span>
                                        <?php
                                    }
                                    ?>
                                    <span class="co">
                                        <a class="comment_btn" href="?addComment=<?php echo $result[$i]['postid'];?>" id="comment-btn">
                                            <span class="icon"><i class="fa-solid fa-comments"></i></span>
                                            <span><?php echo $interactiveController->numberOfComments("tweet",$result[$i]['postid'])[0]['count(*)'] ?> Comment</span>
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
                                        <a class="retweet_btn" href="?retweet=<?php echo $result[$i]['postid'];?>&oldid=<?php echo $result[$i]['pid'];?>" id="comment-btn">
                                            <span class="icon"><i class="fa-solid fa-retweet"></i></span>
                                            <span><?php echo $interactiveController->numberOfRetweets($result[$i]['postid'])[0]['count(*)'] ?> Retweet</span>
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
                                        <a href="?share=<?php echo $result[$i]['postid'] ?>">
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
                        $postController = new PostController;
                        $hashtag3 = new HashtagController;
                        $oldPersonControl = new PersonController;
                        $result5 = $retweetPrintController->getAllRetweetWithoutMine($id);
                        if($result5){
                            for($i=0; $i<count($result5) ; $i++){?>
                                <div class="sharePost">
                                    <img class="userShareimage" src="../Uploads/<?php  echo $oldPersonControl->getPersonData($result5[$i]['retweetpid'])->pimage ?>" alt="">
                                    <p class="title"><?php echo $oldPersonControl->getPersonData($result5[$i]['retweetpid'])->Fname." ".$oldPersonControl->getPersonData($result5[$i]['retweetpid'])->Lname ?></p>
                                    <p class="newContent">
                                        <?php echo $result5[$i]['newContent'];?>
                                    </p>
                                    <div class="dropdown drop-down">
                                        <button class="btn btn-secondary drop-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu menu">
                                            <?php
                                                if($personControl->checkFollow('follow',$id,$result5[$i]['pid'])){ ?>
                                                    <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?unfollow=<?php echo $result5[$i]['retweetpid']; ?>"><i class='bx bx-user-minus' ></i> Unfollow</a></li>
                                            <?php
                                                } else{ ?>
                                                    <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?follow=<?php echo $result5[$i]['retweetpid']; ?>"><i class='bx bx-user-plus' ></i> Follow</a></li>
                                            <?php
                                                }
                                            ?>
                                            <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?mute=<?php echo $result5[$i]['retweetpid']; ?>"><i class='bx bx-volume-mute' ></i> Mute</a></li>
                                            <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?block=<?php echo $result5[$i]['retweetpid']; ?>"><i class="fa-solid fa-ban"></i> Block</a></li>
                                            <?php
                                            if($postControl->checkSaved('retweet',$result5[$i]['shareid'],$id)){
                                                ?>
                                                <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_post.php?unSaveRetweet=<?php echo $result5[$i]['shareid'] ?>&pid=<?php echo $id ?>"><i class="fa-regular fa-bookmark"></i></i><i class="fa-solid fa-slash slash"></i> Unsave post</a></li>
                                            <?php
                                            }
                                            else{
                                                ?>
                                                <li><a class="dropdown-item" href="?saveRetweet=<?php echo $result5[$i]['shareid'] ?>"><i class="fa-regular fa-bookmark"></i> Save post</a></li>
                                                <?php
                                            }
                                            ?>
                                            <li><a class="dropdown-item" href="http://localhost/twitter/Views/00.php?report=<?php echo $result5[$i]['retweetpid']; ?>"><i class='bx bx-file-blank' ></i> Report User</a></li>
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
                                        <img class="oldimage" src="../Uploads/<?php  echo $oldPersonControl->getPersonData($result5[$i]['oldid'])->pimage ?>" alt="">
                                        <?php
                                        ?>
                                        <p class="oldtitle"><?php echo $oldPersonControl->getPersonData($result5[$i]['oldid'])->Fname." ".$oldPersonControl->getPersonData($result5[$i]['oldid'])->Lname ?></p>
                                        <?php
                                        if ($result5[$i]['image'] != null){?>
                                            <span>
                                                <img src="../Uploads/<?php echo $result5[$i]['image'];?>" alt="" width="600" height="200" class="postimage">
                                            </span>
                                        <?php
                                        }
                                        ?>
                                        <p class="content">
                                            <?php echo $result5[$i]['content'];?>
                                        </p>
                                        <?php
                                        if($result5[$i]['hid'] !=null){
                                            $hash1 = $hashtag3->getOneHashtag($result5[$i]['hid']);
                                            ?>
                                            <span class="postHash">##  <?php echo $hash1 [0]['content'];?></span>
                                        <?php 
                                        }?>
                                        
                                    </div>
                                    <div class="interactive">
                                        <?php
                                        if($postControl->checkSaved("retweet_like",$result5[$i]['shareid'],$id)){?>
                                            <span class="co_Like">
                                                <a class="a" href="manage_post.php?removeRetweetLike=<?php echo $result5[$i]['shareid']; ?>">
                                                    <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                                    <span><?php echo $interactiveController->numberOfLikes("retweet",$result5[$i]['shareid'])[0]['count(*)'] ?> Like</span>
                                                </a>
                                            </span>
                                            <?php
                                        }
                                        else{?>
                                            <span class="co">
                                                <a class="a" href="manage_post.php?addRetweetLike=<?php echo $result5[$i]['shareid']; ?>">
                                                    <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                                    <span><?php echo $interactiveController->numberOfLikes("retweet",$result5[$i]['shareid'])[0]['count(*)'] ?> Like</span>
                                                </a>
                                            </span>
                                            <?php
                                        }
                                        ?>
                                        <span class="co">
                                            <a class="comment_btn" href="?retweets&addRetweetComment=<?php echo $result5[$i]['shareid'];?>" id="comment-btn">
                                                <span class="icon"><i class="fa-solid fa-comments"></i></span>
                                                <span><?php echo $interactiveController->numberOfComments("retweet",$result5[$i]['shareid'])[0]['count(*)'] ?> Comment</span>
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
                                            <a class="retweet_btn" href="?retweetRetweet=<?php echo $result5[$i]['postid'];?>&oldid=<?php echo $result5[$i]['oldid'];?>" id="comment-btn">
                                                <span class="icon"><i class="fa-solid fa-retweet"></i></span>
                                                <span><?php echo $interactiveController->numberOfRetweets($result5[$i]['postid'])[0]['count(*)'] ?> Retweet</span>
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
                                            <a href="?shareretweet=<?php echo $result5[$i]['shareid'] ?>">
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
                    }
                    else {
                        $postControl = new PostController;
                        $personControl = new PersonController;
                        $result = $tweetPrintController->getPublicPost();
                        $hashtag2 = new HashtagController;
                        for( $i = 0 ; $i < count($result); $i++){
                            ?>
                            <div class="post">
                                <img class="pimage-post" src="../Uploads/<?php echo $result[$i]['pimage'];?>" alt="">
                                <p class="title"><?php echo $result[$i]['Fname'].' '.$result[$i]['Lname'] ;?></p>
                                
                                <div class="dropdown drop-down">
                                    <button class="btn btn-secondary drop-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu menu">
                                        <?php
                                            if($personControl->checkFollow('follow',$id,$result[$i]['pid'])){ ?>
                                                <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?unfollow=<?php echo $result[$i]['pid']; ?>"><i class='bx bx-user-minus' ></i> Unfollow</a></li>
                                        <?php
                                            } else{ ?>
                                                <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?follow=<?php echo $result[$i]['pid']; ?>"><i class='bx bx-user-plus' ></i> Follow</a></li>
                                        <?php
                                            }
                                        ?>
                                        <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?mute=<?php echo $result[$i]['pid']; ?>"><i class='bx bx-volume-mute' ></i> Mute</a></li>
                                        <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?block=<?php echo $result[$i]['pid']; ?>"><i class="fa-solid fa-ban"></i> Block</a></li>
                                        <?php
                                        if($postControl->checkSaved('tweet',$result[$i]['postid'],$id)){
                                            ?>
                                            <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_post.php?unSaveTweet=<?php echo $result[$i]['postid'] ?>&pid=<?php echo $id ?>"><i class="fa-regular fa-bookmark"></i></i><i class="fa-solid fa-slash slash"></i> Unsave post</a></li>
                                        <?php
                                        }
                                        else{
                                            ?>
                                            <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php"><i class="fa-regular fa-bookmark"></i> Save post</a></li>
                                            <?php
                                        }
                                        ?>
                                        <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php"><i class='bx bx-file-blank' ></i> Report User</a></li>
                                    </ul>
                                </div>
                                <?php
                                if ($result[$i]['image'] != null){?>
                                    <span>
                                        <img src="../Uploads/<?php echo $result[$i]['image'];?>" alt="" width="600" height="200">
                                    </span>
                                <?php
                                }
                                ?>
                                <p class="content">
                                    <?php echo $result[$i]['content'];?>
                                </p>
                                <?php
                                if($result[$i]['hid'] !=null){
                                    $hash = $hashtag2->getOneHashtag($result[$i]['hid']);
                                    ?>
                                    <span class="postHash">##  <?php echo $hash [0]['content'];?></span>
                                <?php 
                                }?>
                                <div class="interactive">
                                    <span class="co">
                                        <a class="a" href="manage_users.php">
                                            <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                            <span><?php echo $interactiveController->numberOfLikes("tweet",$result[$i]['postid'])[0]['count(*)'] ?> Like</span>
                                        </a>
                                    </span>
                                    <span class="co">
                                        <a class="comment_btn" href="http://localhost/twitter/Views/manage_users.php" id="comment-btn">
                                            <span class="icon"><i class="fa-solid fa-comments"></i></span>
                                            <span><?php echo $interactiveController->numberOfComments("tweet",$result[$i]['postid'])[0]['count(*)'] ?> Comment</span>
                                        </a>
                                    </span>
                                    <span class="co">
                                        <a class="retweet_btn" href="http://localhost/twitter/Views/manage_users.php" id="comment-btn">
                                            <span class="icon"><i class="fa-solid fa-retweet"></i></span>
                                            <span><?php echo $interactiveController->numberOfRetweets($result[$i]['postid'])[0]['count(*)'] ?> Retweet</span>
                                        </a>
                                    </span>
                                    <span class="share">
                                        <a href="?share=<?php echo $result[$i]['postid'] ?>">
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
                        $postController = new PostController;
                        $hashtag3 = new HashtagController;
                        $oldPersonControl = new PersonController;
                        $result5 = $retweetPrintController->getAllRetweet();
                        if($result5){
                            for($i=0; $i<count($result5) ; $i++){?>
                                <div class="sharePost">
                                    <img class="userShareimage" src="../Uploads/<?php  echo $oldPersonControl->getPersonData($result5[$i]['retweetpid'])->pimage ?>" alt="">
                                    <p class="title"><?php echo $oldPersonControl->getPersonData($result5[$i]['retweetpid'])->Fname." ".$oldPersonControl->getPersonData($result5[$i]['retweetpid'])->Lname ?></p>
                                    <p class="newContent">
                                        <?php echo $result5[$i]['newContent'];?>
                                    </p>
                                    <div class="dropdown drop-down">
                                        <button class="btn btn-secondary drop-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu menu">
                                            <?php
                                                if($personControl->checkFollow('follow',$id,$result5[$i]['pid'])){ ?>
                                                    <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?unfollow=<?php echo $result5[$i]['retweetpid']; ?>"><i class='bx bx-user-minus' ></i> Unfollow</a></li>
                                            <?php
                                                } else{ ?>
                                                    <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?follow=<?php echo $result5[$i]['retweetpid']; ?>"><i class='bx bx-user-plus' ></i> Follow</a></li>
                                            <?php
                                                }
                                            ?>
                                            <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?mute=<?php echo $result5[$i]['retweetpid']; ?>"><i class='bx bx-volume-mute' ></i> Mute</a></li>
                                            <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?block=<?php echo $result5[$i]['retweetpid']; ?>"><i class="fa-solid fa-ban"></i> Block</a></li>
                                            <?php
                                            if($postControl->checkSaved('retweet',$result5[$i]['shareid'],$id)){
                                                ?>
                                                <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_post.php?unSaveRetweet=<?php echo $result5[$i]['shareid'] ?>&pid=<?php echo $id ?>"><i class="fa-regular fa-bookmark"></i></i><i class="fa-solid fa-slash slash"></i> Unsave post</a></li>
                                            <?php
                                            }
                                            else{
                                                ?>
                                                <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php"><i class="fa-regular fa-bookmark"></i> Save post</a></li>
                                                <?php
                                            }
                                            ?>
                                            <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php"><i class='bx bx-file-blank' ></i> Report User</a></li>
                                        </ul>
                                    </div>
                                    <div class="old_data">
                                        <img class="oldimage" src="../Uploads/<?php  echo $oldPersonControl->getPersonData($result5[$i]['oldid'])->pimage ?>" alt="">
                                        <?php
                                        ?>
                                        <p class="oldtitle"><?php echo $oldPersonControl->getPersonData($result5[$i]['oldid'])->Fname." ".$oldPersonControl->getPersonData($result5[$i]['oldid'])->Lname ?></p>
                                        <?php
                                        if ($result5[$i]['image'] != null){?>
                                            <span>
                                                <img src="../Uploads/<?php echo $result5[$i]['image'];?>" alt="" width="600" height="200" class="postimage">
                                            </span>
                                        <?php
                                        }
                                        ?>
                                        <p class="content">
                                            <?php echo $result5[$i]['content'];?>
                                        </p>
                                        <?php
                                        if($result5[$i]['hid'] !=null){
                                            $hash1 = $hashtag3->getOneHashtag($result5[$i]['hid']);
                                            ?>
                                            <span class="postHash">##  <?php echo $hash1 [0]['content'];?></span>
                                        <?php 
                                        }?>
                                        
                                    </div>
                                    <div class="interactive">
                                        <span class="co">
                                            <a class="a" href="manage_users.php">
                                                <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                                <span><?php echo $interactiveController->numberOfLikes("retweet",$result5[$i]['shareid'])[0]['count(*)'] ?> Like</span>
                                            </a>
                                        </span>
                                        <span class="co">
                                            <a class="comment_btn" href="http://localhost/twitter/Views/manage_users.php" id="comment-btn">
                                                <span class="icon"><i class="fa-solid fa-comments"></i></span>
                                                <span><?php echo $interactiveController->numberOfComments("retweet",$result5[$i]['shareid'])[0]['count(*)'] ?> Comment</span>
                                            </a>
                                        </span>
                                        <span class="co">
                                            <a class="retweet_btn" href="http://localhost/twitter/Views/manage_users.php" id="comment-btn">
                                                <span class="icon"><i class="fa-solid fa-retweet"></i></span>
                                                <span><?php echo $interactiveController->numberOfRetweets($result5[$i]['shareid'])[0]['count(*)'] ?> Retweet</span>
                                            </a>
                                        </span>
                                        <span class="share">
                                            <a href="?shareretweet=<?php echo $result5[$i]['shareid'] ?>">
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
                    }
                    ?>
                    <?php
                }
                ?>
                <!-- End Search Tweet Form-->
                
            </div>
            <!-- End Post-->
            <!-- Start Right bar-->
            <?php include 'rightbar.php'; ?>
            
            <!-- End Right bar-->
        </div>
    </div>
    <script>
        let following = document.querySelectorAll('.following');
        let fori = document.querySelectorAll('.for_you');        
        following[0].onclick = function (){
            fori[0].className = 'for_you'
            following[0].className = 'following active'
        }
        
        
        fori[0].onclick = function (){
            following[0].className = 'following'
            fori[0].className = 'for_you active'
        }
    </script>
    <script>
        let drop = document.getElementsByClassName('dropdown');
        let content = document.getElementsByClassName('dropdown_content');
        console.log(drop.length);
        console.log(content.length);
        for(i = 0 ; i <drop.length ; i++){
            drop[i].onclick = function(){
                let j = 0;
                while(j < list.length){
                    list[j++].className = 'dropdown_content';
                }
                list[i].className = 'drop-active'
            }
        }
    </script>
<?php 
include 'includes/footer.php' ;
