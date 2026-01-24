<?php include "includes/header.php";
?>
<?php 
if(session_status() == 0){
    session_start();
}
elseif(session_status() == 1){
    session_start();
}
require_once '../Controllers/personController.php';
require_once '../Models/person.php';
require_once '../Controllers/PostController.php';
require_once '../Controllers/AdController.php';
require_once '../Controllers/HashtagController.php';
require_once '../Controllers/notificationController.php';
require_once '../Controllers/interactiveController.php';
require_once '../Controllers/retweetPrintController.php';
require_once '../Controllers/tweetPrintController.php';
require_once '../Controllers/adminFunctions.php';
$retweetPrintController= new RetweetPrintController;
$tweetPrintController= new TweetPrintController;
$interactiveController = new InteractiveController;
$adminControl = new AdminFunctions;
if(isset($_SESSION['Aid'])){$id = $_SESSION['Aid'];}
elseif(isset($_SESSION['CCid'])){$id = $_SESSION['CCid'];}
elseif(isset($_SESSION['Uid'])){$id = $_SESSION['Uid'];}
else{
    $id = 0;
}
$adControl = new AdController;
$postController = new PostController;
$personControl =new PersonController;
$hashtag3 = new HashtagController;
$hashtag2 = new HashtagController;
$oldPersonControl = new PersonController;
$person = new Person;
$noteControl = new NotificationController;
/*if(isset($_GET['pid'])){?>
    <div class="container">
        <div class="row">
            <!-- Start Sidebar-->
            <?php include 'sidebar.php'; ?>
            <!-- End sidebar -->
            <div class="col-2"></div>
            <div class="col-6">
                <?php
                $person = $personControl->getPersonData($_GET['pid']);
                ?>
                <div class="profile_info">
                    <img id="coverImg" src="../Uploads/<?php echo $person->cimage; ?>" alt="Cover image">
                    <!-- The Modal -->
                    <div id="myModal1" class="modal1">
                        <!-- The Close Button -->
                        <span class="close">&times;</span>
                        <!-- Modal Content (The Image) -->
                        <img class="modal-content1" id="img01">
                        <!-- Modal Caption (Image Text) -->
                        <div id="caption1"></div>
                    </div>
                    <img id="profileImg2" src="../Uploads/<?php echo $person->pimage; ?>" alt="Profile image">
                    <div id="myModal2" class="modal2">
                        <span class="close">&times;</span>
                        <img class="modal-content2" id="img02">
                        <div id="caption2"></div>
                    </div>
                    <div class="dropdown drop-down">
                        <button class="btn btn-secondary drop-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                        <ul class="dropdown-menu menu">
                            <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?follow=<?php echo $_GET['pid']; ?>"><i class='bx bx-user-plus' ></i> Follow</a></li>
                            <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?mute=<?php echo $_GET['pid']; ?>"><i class='bx bx-volume-mute' ></i> Mute</a></li>
                            <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?block=<?php echo $_GET['pid']; ?>"><i class="fa-solid fa-ban"></i> Block</a></li>
                            <li><a class="dropdown-item" href="http://localhost/twitter/Views/00.php?report=<?php echo $_GET['pid']; ?>"><i class='bx bx-file-blank' ></i> Report User</a></li>
                        </ul>
                    </div>
                    <?php
                    ?>
                    <div class="data">
                        <span class="name"><?php echo $person->Fname; ?> <?php echo $person->Lname; ?></span>
                        <span class="uname">@<?php echo $person->uname; ?></span>
                        <span class="date"><i class="fa fa-calendar"></i> Joined <?php echo $person->date; ?></span>
                        <a href="#"><span class="number"><?php  $following = $personControl->numberFollowing($person->id); echo $following[0]['count(*)']; ?></span><span> Following</span></a>
                        <a href="#"><span class="number"><?php  $follower = $personControl->numberFollower($person->id); echo $follower[0]['count(*)']; ?></span><span></span><span> Followers</span></a>
                    </div>
                    <div class="menu">
                        <a href="http://localhost/twitter/Views/profile.php?pid=<?php echo $_GET['pid'] ?>&posts" class="ppp">Posts</a>
                        <a href="http://localhost/twitter/Views/profile.php?pid=<?php echo $_GET['pid'] ?>&retweets" class="ppp">Retweets</a>
                    </div>
                </div>
                <?php 
                if(isset($_GET['retweets'])){
                    require_once '../Controllers/PostController.php';
                    $result5 = $postController->getMyRetweet($_GET['pid']);
                    if($result5){
                        for($i=0; $i<count($result5) ; $i++){?>
                            <div class="sharePost">
                                <img class="userShareimage" src="../Uploads/<?php  echo $person->pimage ?>" alt="">
                                <p class="title"><?php echo $person->Fname." ".$person->Lname ?></p>
                                <p class="newContent">
                                    <?php echo $result5[$i]['newContent'];?>
                                </p>
                                <div class="dropdown drop-down">
                                    <button class="btn btn-secondary drop-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu menu">
                                        <li><a class="dropdown-item" href="oneItem.php?retweetid=<?php echo $result[$i]['shareid'] ;?>&comments"><i class="fa-solid fa-comment"></i> Comments</a></li>
                                        <li><a class="dropdown-item" href="oneItem.php?retweetid=<?php echo $result[$i]['shareid'] ;?>&likes"><i class="fa-solid fa-thumbs-up"></i> Likes</a></li>
                                        <li><a class="dropdown-item" href="oneItem.php?retweetid=<?php echo $result[$i]['shareid'] ;?>&retweets=<?php echo $result5[$i]['postid'] ;?>"><i class="fa-solid fa-retweet"></i> Retweets</a></li>
                                    </ul>
                                </div>
                                <div class="old_data">
                                    <img class="oldimage" src="../Uploads/<?php echo $oldPersonControl->getPersonData($result5[$i]['oldid'])->pimage ;?>" alt="">
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
                                        <a class="a" href="manage_post.php">
                                            <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                            <span><?php echo $postController->numberOfLikes("retweet",$result5[$i]['shareid'])[0]['count(*)'] ?> Like</span>
                                        </a>
                                    </span>
                                    <span class="co">
                                        <a class="comment_btn" href="?retweets&addRetweetComment=<?php echo $result5[$i]['shareid'];?>" id="comment-btn">
                                            <span class="icon"><i class="fa-solid fa-comments"></i></span>
                                            <span><?php echo $postController->numberOfComments("retweet",$result5[$i]['shareid'])[0]['count(*)'] ?> Comment</span>
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
                                        <a class="retweet_btn" href="?retweet=<?php echo $result5[$i]['postid'];?>&oldid=<?php echo $result5[$i]['oldid'];?>" id="comment-btn">
                                            <span class="icon"><i class="fa-solid fa-retweet"></i></span>
                                            <span><?php echo $postController->numberOfRetweets($result5[$i]['shareid'])[0]['count(*)'] ?> Retweet</span>
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
                                        <a href="#">
                                            <span class="icon"><i class="fa-regular fa-share-from-square"></i></span>
                                            <span>Share</span>
                                        </a>
                                    </span>
                                </div>
                            </div>
                    <?php
                        }
                        ?>
                        
                    <?php
                    }
                    else{?>
                        <div class="empty">
                            No Retweets Found!
                        </div>
                    <?php
                    }
                }
                elseif(isset($_GET['ads'])){
                    $result = $adControl->getMine($person->id);
                    if(count($result) == 0){
                        echo "<div class='empty'>No Advertisement</div>";
                    } 
                    else{
                        for( $i = 0 ; $i < count($result); $i++){?>
                            <div class="Ad">
                                <img class="pimage-post" src="../Uploads/<?php echo $result[$i]['pimage']; ?>" alt="">
                                <p class="title"><?php echo $result[0]['Fname']; ?> <?php echo $result[$i]['Lname']; ?></p>
                                <div class="dropdown drop-down">
                                    <button class="btn btn-secondary drop-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu menu">
                                    <li><a class="dropdown-item" href="oneItem.php?adid=<?php echo $result[$i]['Adid'] ;?>&comments"><i class="fa-solid fa-comment"></i> Comments</a></li>
                                    <li><a class="dropdown-item" href="oneItem.php?adid=<?php echo $result[$i]['Adid'] ;?>&likes"><i class="fa-solid fa-thumbs-up"></i> Likes</a></li>
                                    </ul>
                                </div>
                                <?php
                                if($result[$i]['image'] != ''){?>
                                    <span>
                                        <img src="../Uploads/<?php echo $result[$i]['image'] ?>" alt="" width="600" height="200">
                                    </span>
                                <?php
                                }
                                ?>
                                <?php
                                if($result[$i]['content'] != ''){?>
                                    <p class="content">
                                        <?php echo $result[$i]['content']; ?>
                                    </p>
                                <?php
                                }
                                ?>
                                
                                <div class="interactive">
                                    <?php
                                    if($adControl->check($result[$i]['Adid'],$id)){?>
                                        <span class="co_Like">
                                            <a class="a" href="manage_ads.php?removeAdLike=<?php echo $result[$i]['Adid']; ?>">
                                                <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                                <span><?php echo $postController->numberOfLikes("ad",$result[$i]['Adid'])[0]['count(*)'] ?> Like</span>
                                            </a>
                                        </span>
                                        <?php
                                    }
                                    else{?>
                                        <span class="co">
                                            <a class="a" href="manage_ads.php?addAdLike=<?php echo $result[$i]['Adid']; ?>">
                                                <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                                <span><?php echo $postController->numberOfLikes("ad",$result[$i]['Adid'])[0]['count(*)'] ?> Like</span>
                                            </a>
                                        </span>
                                        <?php
                                    }
                                    ?>
                                    <span class="co">
                                        <a class="comment_btn" href="?ads&addComment=<?php echo $result[$i]['Adid'] ?>" id="comment-btn">
                                            <span class="icon"><i class="fa-solid fa-comments"></i></span>
                                            <span><?php echo $postController->numberOfComments("ad",$result[$i]['Adid'])[0]['count(*)'] ?> Comment</span>
                                        </a>
                                    </span>
                                    <span class="share">
                                        <a href="#">
                                            <span class="icon"><i class="fa-regular fa-share-from-square"></i></span>
                                            <span>Share</span>
                                        </a>
                                    </span>
                                </div>
                            </div>
                            <?php
                        }
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
                    }
                }
                else{?>
                    <?php
                    $result = $postController->getMyPublic($person->id);
                    if(count($result) == 0){
                        echo "<div class='empty'>No Posted Tweets</div>";
                    }
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
                                    <li><a class="dropdown-item" href="oneItem.php?postid=<?php echo $result[$i]['postid'] ;?>&comments"><i class="fa-solid fa-comment"></i> Comments</a></li>
                                    <li><a class="dropdown-item" href="oneItem.php?postid=<?php echo $result[$i]['postid'] ;?>&likes"><i class="fa-solid fa-thumbs-up"></i> Likes</a></li>
                                    <li><a class="dropdown-item" href="oneItem.php?postid=<?php echo $result[$i]['postid'] ;?>&retweets"><i class="fa-solid fa-retweet"></i> Retweets</a></li>
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
                                    <a class="a" href="#">
                                        <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                        <span><?php echo $postController->numberOfLikes("tweet",$result[$i]['postid'])[0]['count(*)'] ?> Like</span>
                                    </a>
                                </span>
                                <span class="co">
                                    <a class="comment_btn" href="?addComment=<?php echo $result[$i]['postid'];?>" id="comment-btn">
                                        <span class="icon"><i class="fa-solid fa-comments"></i></span>
                                        <span><?php echo $postController->numberOfComments("tweet",$result[$i]['postid'])[0]['count(*)'] ?> Comment</span>
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
                                        <span><?php echo $postController->numberOfRetweets($result[$i]['postid'])[0]['count(*)'] ?> Retweet</span>
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
                                    <a href="#">
                                        <span class="icon"><i class="fa-regular fa-share-from-square"></i></span>
                                        <span>Share</span>
                                    </a>
                                </span>
                            </div>
                        </div>
                    <?php 
                    }
                }
                ?>
            </div>
            <!-- Start Right bar-->
            <?php include 'rightbar.php'; ?>
            <!-- End Right bar-->
        </div>
    </div>
    <?php include "includes/footer.php";
}*/
if(isset($_GET['pid'])){?>
    <div class="container">
        <div class="row">
            <!-- Start Sidebar-->
            <?php include 'sidebar.php'; ?>
            <!-- End sidebar -->
            <div class="col-2"></div>
            <div class="col-6">
                <?php
                $person = $personControl->getPersonData($_GET['pid']);
                ?>
                <div class="profile_info">
                    <img id="coverImg" src="../Uploads/<?php echo $person->cimage; ?>" alt="Cover image">
                    <!-- The Modal -->
                    <div id="myModal1" class="modal1">
                        <!-- The Close Button -->
                        <span class="close">&times;</span>
                        <!-- Modal Content (The Image) -->
                        <img class="modal-content1" id="img01">
                        <!-- Modal Caption (Image Text) -->
                        <div id="caption1"></div>
                    </div>
                    <img id="profileImg2" src="../Uploads/<?php echo $person->pimage; ?>" alt="Profile image">
                    <div id="myModal2" class="modal2">
                        <span class="close">&times;</span>
                        <img class="modal-content2" id="img02">
                        <div id="caption2"></div>
                    </div>
                    <div class="dropdown drop-down">
                        <button class="btn btn-secondary drop-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                        <ul class="dropdown-menu menu">
                            <?php
                            if($personControl->checkFollow('follow',$id,$_GET['pid'])){ ?>
                                <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?unfollow=<?php echo $_GET['pid']; ?>"><i class='bx bx-user-minus' ></i> Unfollow</a></li>
                            <?php
                            } else{ ?>
                                <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?follow=<?php echo $_GET['pid']; ?>"><i class='bx bx-user-plus' ></i> Follow</a></li>
                            <?php
                            }
                            ?>
                            <?php
                            if($personControl->checkFollow('mute',$id,$_GET['pid'])){ ?>
                                <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?unmute=<?php echo $_GET['pid']; ?>"><i class='bx bx-volume-mute' ></i> Unmute</a></li>
                                <?php
                            }
                            else{?>
                                <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?mute=<?php echo $_GET['pid']; ?>"><i class='bx bx-volume-mute' ></i> Mute</a></li>
                            <?php
                            }
                            ?>
                            <?php
                            if($personControl->checkFollow('block',$id,$_GET['pid'])){ ?>
                                <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?unblock=<?php echo $_GET['pid']; ?>"><i class="fa-solid fa-ban"></i> Unblock</a></li>
                            <?php
                            }
                            else{?>
                                <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?block=<?php echo $_GET['pid']; ?>"><i class="fa-solid fa-ban"></i> Block</a></li>
                            <?php
                            }
                            ?>
                            <li><a class="dropdown-item" href="http://localhost/twitter/Views/00.php?report=<?php echo $_GET['pid']; ?>"><i class='bx bx-file-blank' ></i> Report User</a></li>
                        </ul>
                    </div>
                    <?php
                    ?>
                    <div class="data">
                        <span class="name"><?php echo $person->Fname; ?> <?php echo $person->Lname; ?></span>
                        <span class="uname">@<?php echo $person->uname; ?></span>
                        <span class="date"><i class="fa fa-calendar"></i> Joined <?php echo $person->date; ?></span>
                        <a href="#"><span class="number"><?php  $following = $personControl->numberFollowing($person->id); echo $following[0]['count(*)']; ?></span><span> Following</span></a>
                        <a href="#"><span class="number"><?php  $follower = $personControl->numberFollower($person->id); echo $follower[0]['count(*)']; ?></span><span></span><span> Followers</span></a>
                    </div>
                    <div class="menu">
                        <a href="http://localhost/twitter/Views/profile.php?pid=<?php echo $_GET['pid']; ?>&posts" class="ppp">Posts</a>
                        <a href="http://localhost/twitter/Views/profile.php?pid=<?php echo $_GET['pid']; ?>&retweets" class="ppp">Retweets</a>
                    </div>
                </div>
                <?php 
                if(isset($_GET['retweets'])){
                    require_once '../Controllers/PostController.php';
                    $result5 = $retweetPrintController->getMyRetweet($_GET['pid']);
                    if($result5){
                        for($i=0; $i<count($result5) ; $i++){?>
                            <div class="sharePost">
                                <img class="userShareimage" src="../Uploads/<?php  echo $person->pimage ?>" alt="">
                                <p class="title"><?php echo $person->Fname." ".$person->Lname ?></p>
                                <p class="newContent">
                                    <?php echo $result5[$i]['newContent'];?>
                                </p>
                                <div class="dropdown drop-down">
                                    <button class="btn btn-secondary drop-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu menu">
                                        <li><a class="dropdown-item" href="oneItem.php?retweetid=<?php echo $result5[$i]['shareid'] ;?>&comments"><i class="fa-solid fa-comment"></i> Comments</a></li>
                                        <li><a class="dropdown-item" href="oneItem.php?retweetid=<?php echo $result5[$i]['shareid'] ;?>&likes"><i class="fa-solid fa-thumbs-up"></i> Likes</a></li>
                                        <li><a class="dropdown-item" href="oneItem.php?retweetid=<?php echo $result5[$i]['shareid'] ;?>&retweets=<?php echo $result5[$i]['postid'] ;?>"><i class="fa-solid fa-retweet"></i> Retweets</a></li>
                                    </ul>
                                </div>
                                <div class="old_data">
                                    <img class="oldimage" src="../Uploads/<?php echo $oldPersonControl->getPersonData($result5[$i]['oldid'])->pimage ;?>" alt="">
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
                                    if($postController->checkSaved("retweet_like",$result5[$i]['shareid'],$id)){?>
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
                                        <a class="retweet_btn" href="?retweets&retweet=<?php echo $result5[$i]['postid'];?>&oldid=<?php echo $result5[$i]['oldid'];?>" id="comment-btn">
                                            <span class="icon"><i class="fa-solid fa-retweet"></i></span>
                                            <span><?php echo $interactiveController->numberOfRetweets($result5[$i]['shareid'])[0]['count(*)'] ?> Retweet</span>
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
                                        <a href="#">
                                            <span class="icon"><i class="fa-regular fa-share-from-square"></i></span>
                                            <span>Share</span>
                                        </a>
                                    </span>
                                </div>
                            </div>
                    <?php
                        }
                        ?>
                        
                    <?php
                    }
                    else{?>
                        <div class="empty">
                            No Retweets Found!
                        </div>
                    <?php
                    }
                }
                elseif(isset($_GET['ads'])){
                    $result = $adControl->getMine($person->id);
                    if(count($result) == 0){
                        echo "<div class='empty'>No Advertisement</div>";
                    } 
                    else{
                        for( $i = 0 ; $i < count($result); $i++){?>
                            <div class="Ad">
                                <img class="pimage-post" src="../Uploads/<?php echo $result[$i]['pimage']; ?>" alt="">
                                <p class="title"><?php echo $result[0]['Fname']; ?> <?php echo $result[$i]['Lname']; ?></p>
                                <div class="dropdown drop-down">
                                    <button class="btn btn-secondary drop-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu menu">
                                    <li><a class="dropdown-item" href="oneItem.php?adid=<?php echo $result[$i]['Adid'] ;?>&comments"><i class="fa-solid fa-comment"></i> Comments</a></li>
                                    <li><a class="dropdown-item" href="oneItem.php?adid=<?php echo $result[$i]['Adid'] ;?>&likes"><i class="fa-solid fa-thumbs-up"></i> Likes</a></li>
                                    </ul>
                                </div>
                                <?php
                                if($result[$i]['image'] != ''){?>
                                    <span>
                                        <img src="../Uploads/<?php echo $result[$i]['image'] ?>" alt="" width="600" height="200">
                                    </span>
                                <?php
                                }
                                ?>
                                <?php
                                if($result[$i]['content'] != ''){?>
                                    <p class="content">
                                        <?php echo $result[$i]['content']; ?>
                                    </p>
                                <?php
                                }
                                ?>
                                
                                <div class="interactive">
                                    <?php
                                    if($adControl->check($result[$i]['Adid'],$id)){?>
                                        <span class="co_Like">
                                            <a class="a" href="manage_ads.php?removeAdLike=<?php echo $result[$i]['Adid']; ?>">
                                                <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                                <span><?php echo $interactiveController->numberOfLikes("ad",$result[$i]['Adid'])[0]['count(*)'] ?> Like</span>
                                            </a>
                                        </span>
                                        <?php
                                    }
                                    else{?>
                                        <span class="co">
                                            <a class="a" href="manage_ads.php?addAdLike=<?php echo $result[$i]['Adid']; ?>">
                                                <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                                <span><?php echo $interactiveController->numberOfLikes("ad",$result[$i]['Adid'])[0]['count(*)'] ?> Like</span>
                                            </a>
                                        </span>
                                        <?php
                                    }
                                    ?>
                                    <span class="co">
                                        <a class="comment_btn" href="?ads&addComment=<?php echo $result[$i]['Adid'] ?>" id="comment-btn">
                                            <span class="icon"><i class="fa-solid fa-comments"></i></span>
                                            <span><?php echo $interactiveController->numberOfComments("ad",$result[$i]['Adid'])[0]['count(*)'] ?> Comment</span>
                                        </a>
                                    </span>
                                    <span class="share">
                                        <a href="#">
                                            <span class="icon"><i class="fa-regular fa-share-from-square"></i></span>
                                            <span>Share</span>
                                        </a>
                                    </span>
                                </div>
                            </div>
                            <?php
                        }
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
                    }
                }
                else{?>
                    <?php
                    $result = $tweetPrintController->getMyPublic($person->id);
                    if(count($result) == 0){
                        echo "<div class='empty'>No Posted Tweets</div>";
                    }
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
                                    <li><a class="dropdown-item" href="oneItem.php?postid=<?php echo $result[$i]['postid'] ;?>&comments"><i class="fa-solid fa-comment"></i> Comments</a></li>
                                    <li><a class="dropdown-item" href="oneItem.php?postid=<?php echo $result[$i]['postid'] ;?>&likes"><i class="fa-solid fa-thumbs-up"></i> Likes</a></li>
                                    <li><a class="dropdown-item" href="oneItem.php?postid=<?php echo $result[$i]['postid'] ;?>&retweets"><i class="fa-solid fa-retweet"></i> Retweets</a></li>
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
                                <?php
                                if($postController->checkSaved("tweet_like",$result[$i]['postid'],$id)){?>
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
                                    <a href="#">
                                        <span class="icon"><i class="fa-regular fa-share-from-square"></i></span>
                                        <span>Share</span>
                                    </a>
                                </span>
                            </div>
                        </div>
                    <?php 
                    }
                }
            ?>
                </div>
            <!-- Start Right bar-->
            <?php include 'rightbar.php'; ?>
            <!-- End Right bar-->
        </div>
    </div>
    <?php include "includes/footer.php";?>
    <?php
}
elseif(isset($_SESSION['uname'])){
    /*if(isset($_GET['pid'])){?>
        <div class="container">
            <div class="row">
                <!-- Start Sidebar-->
                <?php include 'sidebar.php'; ?>
                <!-- End sidebar -->
                <div class="col-2"></div>
                <div class="col-6">
                    <?php
                    $person = $personControl->getPersonData($_GET['pid']);
                    ?>
                    <div class="profile_info">
                        <img id="coverImg" src="../Uploads/<?php echo $person->cimage; ?>" alt="Cover image">
                        <!-- The Modal -->
                        <div id="myModal1" class="modal1">
                            <!-- The Close Button -->
                            <span class="close">&times;</span>
                            <!-- Modal Content (The Image) -->
                            <img class="modal-content1" id="img01">
                            <!-- Modal Caption (Image Text) -->
                            <div id="caption1"></div>
                        </div>
                        <img id="profileImg2" src="../Uploads/<?php echo $person->pimage; ?>" alt="Profile image">
                        <div id="myModal2" class="modal2">
                            <span class="close">&times;</span>
                            <img class="modal-content2" id="img02">
                            <div id="caption2"></div>
                        </div>
                        <div class="dropdown drop-down">
                            <button class="btn btn-secondary drop-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <ul class="dropdown-menu menu">
                                <?php
                                if($personControl->checkFollow('follow',$id,$_GET['pid'])){ ?>
                                    <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?unfollow=<?php echo $_GET['pid']; ?>"><i class='bx bx-user-minus' ></i> Unfollow</a></li>
                                <?php
                                } else{ ?>
                                    <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?follow=<?php echo $_GET['pid']; ?>"><i class='bx bx-user-plus' ></i> Follow</a></li>
                                <?php
                                }
                                ?>
                                <?php
                                if($personControl->checkFollow('mute',$id,$_GET['pid'])){ ?>
                                    <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?unmute=<?php echo $_GET['pid']; ?>"><i class='bx bx-volume-mute' ></i> Unmute</a></li>
                                    <?php
                                }
                                else{?>
                                    <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?mute=<?php echo $_GET['pid']; ?>"><i class='bx bx-volume-mute' ></i> Mute</a></li>
                                <?php
                                }
                                ?>
                                <?php
                                if($personControl->checkFollow('block',$id,$_GET['pid'])){ ?>
                                    <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?unblock=<?php echo $_GET['pid']; ?>"><i class="fa-solid fa-ban"></i> Unblock</a></li>
                                <?php
                                }
                                else{?>
                                    <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?block=<?php echo $_GET['pid']; ?>"><i class="fa-solid fa-ban"></i> Block</a></li>
                                <?php
                                }
                                ?>
                                <li><a class="dropdown-item" href="http://localhost/twitter/Views/00.php?report=<?php echo $_GET['pid']; ?>"><i class='bx bx-file-blank' ></i> Report User</a></li>
                            </ul>
                        </div>
                        <?php
                        ?>
                        <div class="data">
                            <span class="name"><?php echo $person->Fname; ?> <?php echo $person->Lname; ?></span>
                            <span class="uname">@<?php echo $person->uname; ?></span>
                            <span class="date"><i class="fa fa-calendar"></i> Joined <?php echo $person->date; ?></span>
                            <a href="#"><span class="number"><?php  $following = $personControl->numberFollowing($person->id); echo $following[0]['count(*)']; ?></span><span> Following</span></a>
                            <a href="#"><span class="number"><?php  $follower = $personControl->numberFollower($person->id); echo $follower[0]['count(*)']; ?></span><span></span><span> Followers</span></a>
                        </div>
                        <div class="menu">
                            <a href="http://localhost/twitter/Views/profile.php?pid=<?php echo $_GET['pid']; ?>&posts" class="ppp">Posts</a>
                            <a href="http://localhost/twitter/Views/profile.php?pid=<?php echo $_GET['pid']; ?>&retweets" class="ppp">Retweets</a>
                        </div>
                    </div>
                    <?php 
                    if(isset($_GET['retweets'])){
                        require_once '../Controllers/PostController.php';
                        $result5 = $postController->getMyRetweet($_GET['pid']);
                        if($result5){
                            for($i=0; $i<count($result5) ; $i++){?>
                                <div class="sharePost">
                                    <img class="userShareimage" src="../Uploads/<?php  echo $person->pimage ?>" alt="">
                                    <p class="title"><?php echo $person->Fname." ".$person->Lname ?></p>
                                    <p class="newContent">
                                        <?php echo $result5[$i]['newContent'];?>
                                    </p>
                                    <div class="dropdown drop-down">
                                        <button class="btn btn-secondary drop-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu menu">
                                            <li><a class="dropdown-item" href="oneItem.php?retweetid=<?php echo $result5[$i]['shareid'] ;?>&comments"><i class="fa-solid fa-comment"></i> Comments</a></li>
                                            <li><a class="dropdown-item" href="oneItem.php?retweetid=<?php echo $result5[$i]['shareid'] ;?>&likes"><i class="fa-solid fa-thumbs-up"></i> Likes</a></li>
                                            <li><a class="dropdown-item" href="oneItem.php?retweetid=<?php echo $result5[$i]['shareid'] ;?>&retweets=<?php echo $result5[$i]['postid'] ;?>"><i class="fa-solid fa-retweet"></i> Retweets</a></li>
                                        </ul>
                                    </div>
                                    <div class="old_data">
                                        <img class="oldimage" src="../Uploads/<?php echo $oldPersonControl->getPersonData($result5[$i]['oldid'])->pimage ;?>" alt="">
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
                                        if($postController->checkSaved("retweet_like",$result5[$i]['shareid'],$id)){?>
                                            <span class="co_Like">
                                                <a class="a" href="manage_post.php?removeRetweetLike=<?php echo $result5[$i]['shareid']; ?>">
                                                    <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                                    <span><?php echo $postController->numberOfLikes("retweet",$result5[$i]['shareid'])[0]['count(*)'] ?> Like</span>
                                                </a>
                                            </span>
                                            <?php
                                        }
                                        else{?>
                                            <span class="co">
                                                <a class="a" href="manage_post.php?addRetweetLike=<?php echo $result5[$i]['shareid']; ?>">
                                                    <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                                    <span><?php echo $postController->numberOfLikes("retweet",$result5[$i]['shareid'])[0]['count(*)'] ?> Like</span>
                                                </a>
                                            </span>
                                            <?php
                                        }
                                        ?>
                                        <span class="co">
                                            <a class="comment_btn" href="?retweets&addRetweetComment=<?php echo $result5[$i]['shareid'];?>" id="comment-btn">
                                                <span class="icon"><i class="fa-solid fa-comments"></i></span>
                                                <span><?php echo $postController->numberOfComments("retweet",$result5[$i]['shareid'])[0]['count(*)'] ?> Comment</span>
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
                                            <a class="retweet_btn" href="?retweets&retweet=<?php echo $result5[$i]['postid'];?>&oldid=<?php echo $result5[$i]['oldid'];?>" id="comment-btn">
                                                <span class="icon"><i class="fa-solid fa-retweet"></i></span>
                                                <span><?php echo $postController->numberOfRetweets($result5[$i]['shareid'])[0]['count(*)'] ?> Retweet</span>
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
                                            <a href="#">
                                                <span class="icon"><i class="fa-regular fa-share-from-square"></i></span>
                                                <span>Share</span>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                        <?php
                            }
                            ?>
                            
                        <?php
                        }
                        else{?>
                            <div class="empty">
                                No Retweets Found!
                            </div>
                        <?php
                        }
                    }
                    elseif(isset($_GET['ads'])){
                        $result = $adControl->getMine($person->id);
                        if(count($result) == 0){
                            echo "<div class='empty'>No Advertisement</div>";
                        } 
                        else{
                            for( $i = 0 ; $i < count($result); $i++){?>
                                <div class="Ad">
                                    <img class="pimage-post" src="../Uploads/<?php echo $result[$i]['pimage']; ?>" alt="">
                                    <p class="title"><?php echo $result[0]['Fname']; ?> <?php echo $result[$i]['Lname']; ?></p>
                                    <div class="dropdown drop-down">
                                        <button class="btn btn-secondary drop-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu menu">
                                        <li><a class="dropdown-item" href="oneItem.php?adid=<?php echo $result[$i]['Adid'] ;?>&comments"><i class="fa-solid fa-comment"></i> Comments</a></li>
                                        <li><a class="dropdown-item" href="oneItem.php?adid=<?php echo $result[$i]['Adid'] ;?>&likes"><i class="fa-solid fa-thumbs-up"></i> Likes</a></li>
                                        </ul>
                                    </div>
                                    <?php
                                    if($result[$i]['image'] != ''){?>
                                        <span>
                                            <img src="../Uploads/<?php echo $result[$i]['image'] ?>" alt="" width="600" height="200">
                                        </span>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    if($result[$i]['content'] != ''){?>
                                        <p class="content">
                                            <?php echo $result[$i]['content']; ?>
                                        </p>
                                    <?php
                                    }
                                    ?>
                                    
                                    <div class="interactive">
                                        <?php
                                        if($adControl->check($result[$i]['Adid'],$id)){?>
                                            <span class="co_Like">
                                                <a class="a" href="manage_ads.php?removeAdLike=<?php echo $result[$i]['Adid']; ?>">
                                                    <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                                    <span><?php echo $postController->numberOfLikes("ad",$result[$i]['Adid'])[0]['count(*)'] ?> Like</span>
                                                </a>
                                            </span>
                                            <?php
                                        }
                                        else{?>
                                            <span class="co">
                                                <a class="a" href="manage_ads.php?addAdLike=<?php echo $result[$i]['Adid']; ?>">
                                                    <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                                    <span><?php echo $postController->numberOfLikes("ad",$result[$i]['Adid'])[0]['count(*)'] ?> Like</span>
                                                </a>
                                            </span>
                                            <?php
                                        }
                                        ?>
                                        <span class="co">
                                            <a class="comment_btn" href="?ads&addComment=<?php echo $result[$i]['Adid'] ?>" id="comment-btn">
                                                <span class="icon"><i class="fa-solid fa-comments"></i></span>
                                                <span><?php echo $postController->numberOfComments("ad",$result[$i]['Adid'])[0]['count(*)'] ?> Comment</span>
                                            </a>
                                        </span>
                                        <span class="share">
                                            <a href="#">
                                                <span class="icon"><i class="fa-regular fa-share-from-square"></i></span>
                                                <span>Share</span>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                                <?php
                            }
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
                        }
                    }
                    else{?>
                        <?php
                        $result = $postController->getMyPublic($person->id);
                        if(count($result) == 0){
                            echo "<div class='empty'>No Posted Tweets</div>";
                        }
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
                                        <li><a class="dropdown-item" href="oneItem.php?postid=<?php echo $result[$i]['postid'] ;?>&comments"><i class="fa-solid fa-comment"></i> Comments</a></li>
                                        <li><a class="dropdown-item" href="oneItem.php?postid=<?php echo $result[$i]['postid'] ;?>&likes"><i class="fa-solid fa-thumbs-up"></i> Likes</a></li>
                                        <li><a class="dropdown-item" href="oneItem.php?postid=<?php echo $result[$i]['postid'] ;?>&retweets"><i class="fa-solid fa-retweet"></i> Retweets</a></li>
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
                                    <?php
                                    if($postController->checkSaved("tweet_like",$result[$i]['postid'],$id)){?>
                                        <span class="co_Like">
                                            <a class="a" href="manage_post.php?removeTweetLike=<?php echo $result[$i]['postid']; ?>">
                                                <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                                <span><?php echo $postController->numberOfLikes("tweet",$result[$i]['postid'])[0]['count(*)'] ?> Like</span>
                                            </a>
                                        </span>
                                        <?php
                                    }
                                    else{?>
                                        <span class="co">
                                            <a class="a" href="manage_post.php?addTweetLike=<?php echo $result[$i]['postid']; ?>">
                                                <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                                <span><?php echo $postController->numberOfLikes("tweet",$result[$i]['postid'])[0]['count(*)'] ?> Like</span>
                                            </a>
                                        </span>
                                        <?php
                                    }
                                    ?>
                                    <span class="co">
                                        <a class="comment_btn" href="?addComment=<?php echo $result[$i]['postid'];?>" id="comment-btn">
                                            <span class="icon"><i class="fa-solid fa-comments"></i></span>
                                            <span><?php echo $postController->numberOfComments("tweet",$result[$i]['postid'])[0]['count(*)'] ?> Comment</span>
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
                                            <span><?php echo $postController->numberOfRetweets($result[$i]['postid'])[0]['count(*)'] ?> Retweet</span>
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
                                        <a href="#">
                                            <span class="icon"><i class="fa-regular fa-share-from-square"></i></span>
                                            <span>Share</span>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        <?php 
                        }
                    }
                ?>
                    </div>
                <!-- Start Right bar-->
                <?php include 'rightbar.php'; ?>
                <!-- End Right bar-->
            </div>
        </div>
        <?php include "includes/footer.php";?>
        <?php
    }*/
    //else{?>
        <div class="container">
            <div class="row">
                <!-- Start Sidebar-->
                <?php include 'sidebar.php'; ?>
                <!-- End sidebar -->
                <div class="col-2"></div>
                <div class="col-6">
                    <?php
                    $person = $personControl->getPersonData($id);
                    ?>
                    <div class="profile_info">
                        <img id="coverImg" src="../Uploads/<?php echo $person->cimage; ?>" alt="Cover image">
                        <!-- The Modal -->
                        <div id="myModal1" class="modal1">
                            <!-- The Close Button -->
                            <span class="close">&times;</span>
                            <!-- Modal Content (The Image) -->
                            <img class="modal-content1" id="img01">
                            <!-- Modal Caption (Image Text) -->
                            <div id="caption1"></div>
                        </div>
                        <img id="profileImg" src="../Uploads/<?php echo $person->pimage; ?>" alt="Profile image">
                        <div id="myModal2" class="modal2">
                            <span class="close">&times;</span>
                            <img class="modal-content2" id="img02">
                            <div id="caption2"></div>
                        </div>
                        <div class="edit_profile_btn"><a class="profile" href="?editProfile=<?php echo $id;?>">Edit Profile</a></div>
                        <?php
                        if (isset($_GET['editProfile'])){?>
                            <div class="edit_profile">
                                <form action="http://localhost/twitter/Views/manage_users.php?editProfile=" method="POST" class="edit_form" enctype="multipart/form-data">
                                    <input name='id' value="<?php echo $person->id ?>" type="hidden">
                                    <input name='uname' value="<?php echo $person->uname ?>" type="hidden">
                                    <input name="email" value="<?php echo $person->email ?>" type="email" placeholder="Email">
                                    <input name="old_pass" value="<?php echo $person->pass ?>" type="hidden" placeholder="Enter New Password if you want">
                                    <input name="new_pass" value="" type="password" placeholder="Enter New Password if you want">
                                    <input name="Fname" value="<?php echo $person->Fname ?>" type="text" placeholder="First Name">
                                    <input name="Lname" value="<?php echo $person->Lname ?>" type="text" placeholder="Last Name">
                                    <input name="role" value="<?php echo $person->role ?>" type="hidden">
                                    <input name="old_pimage" value="<?php echo $person->pimage ?>" type="hidden">
                                    <input name="old_cimage" value="<?php echo $person->cimage ?>" type="hidden">
                                    <p class="Question">What is Your Best friend Name?</p>
                                    <input name="FPQ" value="<?php echo $person->FPQ ?>" type="text" placeholder="Enter the answer of question above to recover your email">
                                    <input name="phone" value="<?php echo $person->phone ?>" type="text" placeholder="Enter Your Phone">
                                    <label for="pimage" class="browse">Edit Profile Image...</label>
                                    <label for="cimage" class="browse">Edit Cover Image...</label>
                                    <input name="pimage" type="file" id="pimage">
                                    <input name="cimage" type="file" id="cimage">
                                    <div class="easy"><input type="submit" name="edit" value="Update" class="edit_btn"></div>
                                    <a href="http://localhost/twitter/Views/profile.php" class="closeForm2" id="closeForm2">&times;</a>
                                </form>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="data">
                            <span class="name"><?php echo $person->Fname; ?> <?php echo $person->Lname; ?></span>
                            <span class="uname">@<?php echo $person->uname; ?></span>
                            <span class="date"><i class="fa fa-calendar"></i> Joined <?php echo $person->date; ?></span>
                            <a href="#"><span class="number"><?php  $following = $personControl->numberFollowing($person->id); echo $following[0]['count(*)']; ?></span><span> Following</span></a>
                            <a href="#"><span class="number"><?php  $follower = $personControl->numberFollower($person->id); echo $follower[0]['count(*)']; ?></span><span></span><span> Followers</span></a>
                        </div>
                        <?php 
                        if (isset($_SESSION['Aid'])){?>
                            <div class="menu">
                                <a href="profile.php?posts" class="p">Posts</a>
                                <a href="profile.php?retweets" class="p">Retweets</a>
                                <a href="profile.php?banned" class="p">Banned Users</a>
                                <a href="bookmarks.php" class="p">Bookmarks</a>
                            </div>
                        <?php
                        } 
                        elseif(isset($_SESSION['CCid'])){?>
                            <div class="menu">
                                <a href="profile.php?posts" class="CCp">Posts</a>
                                <a href="profile.php?retweets" class="CCp">Retweets</a>
                                <a href="profile.php?ads" class="CCp">My Advertisement</a>
                                <a href="profile.php?notifications" class="CCp">Notifications</a>
                            </div>
                        <?php
                        }
                        elseif(isset($_SESSION['Uid'])){?>
                            <div class="menu">
                                <a href="profile.php?posts" class="Up">Posts</a>
                                <a href="profile.php?retweets" class="Up">Retweets</a>
                                <a href="profile.php?notifications" class="Up">Notifications</a>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <?php 
                    if(isset($_GET['retweets'])){
                        $result5 = $retweetPrintController->getMyRetweet($id);
                        if($result5){
                            for($i=0; $i<count($result5) ; $i++){?>
                                <div class="sharePost">
                                    <img class="userShareimage" src="../Uploads/<?php  echo $person->pimage ?>" alt="">
                                    <p class="title"><?php echo $person->Fname." ".$person->Lname ?></p>
                                    <p class="newContent">
                                        <?php echo $result5[$i]['newContent'];?>
                                    </p>
                                    <div class="dropdown drop-down">
                                        <button class="btn btn-secondary drop-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu menu">
                                            <li><a class="dropdown-item" href="oneItem.php?retweetid=<?php echo $result5[$i]['shareid'] ;?>&comments"><i class="fa-solid fa-comment"></i> Comments</a></li>
                                            <li><a class="dropdown-item" href="oneItem.php?retweetid=<?php echo $result5[$i]['shareid'] ;?>&likes"><i class="fa-solid fa-thumbs-up"></i> Likes</a></li>
                                            <li><a class="dropdown-item" href="oneItem.php?retweetid=<?php echo $result5[$i]['shareid'] ;?>&retweets=<?php echo $result5[$i]['postid'] ;?>"><i class="fa-solid fa-retweet"></i> Retweets</a></li>
                                            <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_post.php?deleteRetweet=<?php echo $result5[$i]['shareid'];?>"><i class="fa-solid fa-trash-can"></i> Delete</a></li>
                                        </ul>
                                    </div>
                                    <div class="old_data">
                                        <img class="oldimage" src="../Uploads/<?php echo $oldPersonControl->getPersonData($result5[$i]['oldid'])->pimage ;?>" alt="">
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
                                        if($postController->checkSaved("retweet_like",$result5[$i]['shareid'],$id)){?>
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
                                            <a class="retweet_btn" href="?retweet=<?php echo $result5[$i]['postid'];?>&oldid=<?php echo $result5[$i]['oldid'];?>" id="comment-btn">
                                                <span class="icon"><i class="fa-solid fa-retweet"></i></span>
                                                <span><?php echo $interactiveController->numberOfRetweets($result5[$i]['shareid'])[0]['count(*)'] ?> Retweet</span>
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
                                            <a href="#">
                                                <span class="icon"><i class="fa-regular fa-share-from-square"></i></span>
                                                <span>Share</span>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                        <?php
                            }
                            ?>
                            
                        <?php
                        }
                        else{?>
                            <div class="empty">
                                No Retweets Found!
                            </div>
                        <?php
                        }
                    }
                    elseif(isset($_GET['banned'])){
                        require_once '../Controllers/personController.php';
                        $result = $adminControl->getBannedUsers();
                        if(count($result) == 0){
                            echo "<div class='empty'>No Banned Users</div>";
                        } 
                        else{
                            for( $i = 0 ; $i < count($result); $i++){?>
                                <div class="banned_users">
                                    <div class="banned_user">
                                        <a href="#">
                                            <span><img class="sm-img" src="../Uploads/<?php echo ($personControl->getPersonData($result[$i]['id']))->pimage ?>" width="60" height="60"></span>
                                            <span class="uname"><?php echo ($personControl->getPersonData($result[$i]['id']))->Fname ?> <?php echo ($personControl->getPersonData($result[$i]['id']))->Lname ?></span>
                                        </a>
                                        <span class="approve"><a href="http://localhost/twitter/Views/manage_users.php?approveUser=<?php echo $result[$i]['id'] ?>"><i class="fa-solid fa-user-check"></i> Approve</a></span>
                                        <span class="delete"><a href="http://localhost/twitter/Views/manage_users.php?deleteUser=<?php echo $result[$i]['id'] ?>"><i class="fa-solid fa-user-minus"></i> Delete</a></span>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    }
                    elseif(isset($_GET['ads'])){
                        $result = $adControl->getMine($person->id);
                        if(count($result) == 0){
                            echo "<div class='empty'>No Advertisement</div>";
                        } 
                        else{
                            for( $i = 0 ; $i < count($result); $i++){?>
                                <div class="Ad">
                                    <img class="pimage-post" src="../Uploads/<?php echo $result[$i]['pimage']; ?>" alt="">
                                    <p class="title"><?php echo $result[0]['Fname']; ?> <?php echo $result[$i]['Lname']; ?></p>
                                    <div class="dropdown drop-down">
                                        <button class="btn btn-secondary drop-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu menu">
                                        <li><a class="dropdown-item" href="oneItem.php?adid=<?php echo $result[$i]['Adid'] ;?>&comments"><i class="fa-solid fa-comment"></i> Comments</a></li>
                                        <li><a class="dropdown-item" href="oneItem.php?adid=<?php echo $result[$i]['Adid'] ;?>&likes"><i class="fa-solid fa-thumbs-up"></i> Likes</a></li>
                                        <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_ads.php?deleteAd=<?php echo $result[$i]['Adid'];?>"><i class="fa-solid fa-trash-can"></i> Delete</a></li>
                                        </ul>
                                    </div>
                                    <?php
                                    if($result[$i]['image'] != ''){?>
                                        <span>
                                            <img src="../Uploads/<?php echo $result[$i]['image'] ?>" alt="" width="600" height="200">
                                        </span>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    if($result[$i]['content'] != ''){?>
                                        <p class="content">
                                            <?php echo $result[$i]['content']; ?>
                                        </p>
                                    <?php
                                    }
                                    ?>
                                    <div class="interactive">
                                        <?php
                                        if($adControl->check($result[$i]['Adid'],$id)){?>
                                            <span class="co_Like">
                                                <a class="a" href="manage_ads.php?removeAdLike=<?php echo $result[$i]['Adid']; ?>">
                                                    <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                                    <span><?php echo $interactiveController->numberOfLikes("ad",$result[$i]['Adid'])[0]['count(*)'] ?> Like</span>
                                                </a>
                                            </span>
                                            <?php
                                        }
                                        else{?>
                                            <span class="co">
                                                <a class="a" href="manage_ads.php?addAdLike=<?php echo $result[$i]['Adid']; ?>">
                                                    <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                                    <span><?php echo $interactiveController->numberOfLikes("ad",$result[$i]['Adid'])[0]['count(*)'] ?> Like</span>
                                                </a>
                                            </span>
                                            <?php
                                        }
                                        ?>
                                        <span class="co">
                                            <a class="comment_btn" href="?ads&addComment=<?php echo $result[$i]['Adid'] ?>" id="comment-btn">
                                                <span class="icon"><i class="fa-solid fa-comments"></i></span>
                                                <span><?php echo $interactiveController->numberOfComments("ad",$result[$i]['Adid'])[0]['count(*)'] ?> Comment</span>
                                            </a>
                                        </span>
                                        <span class="share">
                                            <a href="?sharead=<?php echo $result[$i]['Adid'] ?>">
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
                                </div>
                                <?php
                            }
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
                        }
                    }
                    elseif(isset($_GET['notifications'])){
                        require_once '../Controllers/personController.php';
                        $result = $noteControl->getMyNotifications($id);
                        if(count($result) == 0){
                            echo "<div class='empty'>No Notifications</div>";
                        } 
                        else{
                            ?>
                            <div class="notifications">
                                <?php
                                for( $i = 0 ; $i < count($result); $i++){
                                    ?>
                                    <div class="note">
                                        <p><?php echo $result[$i]['content'] ?></p>
                                        <span class="date"><?php echo $result[$i]['date'] ?></span>
                                        <span><a href="notifications.php?deleteNote=<?php echo $result[$i]['noteid'] ?>" class="delete"><i class="fa-solid fa-trash"></i> Delete</a></span>
                                    </div>
                                
                                <?php
                                }
                                ?>
                            </div>
                                <?php
                        }
                    }
                    else{?>
                        <?php
                        $result = $tweetPrintController->getMine($person->id);
                        if(count($result) == 0){
                            echo "<div class='empty'>No Posted Tweets</div>";
                        }
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
                                        <li><a class="dropdown-item" href="oneItem.php?postid=<?php echo $result[$i]['postid'] ;?>&comments"><i class="fa-solid fa-comment"></i> Comments</a></li>
                                        <li><a class="dropdown-item" href="oneItem.php?postid=<?php echo $result[$i]['postid'] ;?>&likes"><i class="fa-solid fa-thumbs-up"></i> Likes</a></li>
                                        <li><a class="dropdown-item" href="oneItem.php?postid=<?php echo $result[$i]['postid'] ;?>&retweets"><i class="fa-solid fa-retweet"></i> Retweets</a></li>
                                        <li><a class="dropdown-item" href="manage_post.php?deletePost=<?php echo $result[$i]['postid'];?>"><i class="fa-solid fa-trash-can"></i> Delete</a></li>
                                        <?php
                                        if($postController->checkSaved("visibility",$result[$i]['postid'],$id)){?>
                                            <li><a class="dropdown-item" href="manage_post.php?makePublic=<?php echo $result[$i]['postid'];?>"><i class="fa-solid fa-eye"></i> Make Public</a></li>
                                            <?php
                                        }
                                        else{
                                            ?>
                                            <li><a class="dropdown-item" href="manage_post.php?makePrivate=<?php echo $result[$i]['postid'];?>"><i class="fa-solid fa-eye-slash"></i> Make Private</a></li>
                                            <?php
                                        }
                                        ?>
                                        
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
                                    <?php
                                    if($postController->checkSaved("tweet_like",$result[$i]['postid'],$id)){?>
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
                    }
                    ?>
                </div>
                <!-- Start Right bar-->
                <?php include 'rightbar.php'; ?>
                <!-- End Right bar-->
            </div>
        </div>
        <?php include "includes/footer.php"; ?>
    <?php
    //}
    ?>

    
<?php
}/*
elseif(isset($_GET['pid'])){?>
    <div class="container">
        <div class="row">
            <!-- Start Sidebar-->
            <?php include 'sidebar.php'; ?>
            <!-- End sidebar -->
            <div class="col-2"></div>
            <div class="col-6">
                <?php
                $person = $personControl->getPersonData($_GET['pid']);
                ?>
                <div class="profile_info">
                    <img id="coverImg" src="../Uploads/<?php echo $person->cimage; ?>" alt="Cover image">
                    <!-- The Modal -->
                    <div id="myModal1" class="modal1">
                        <!-- The Close Button -->
                        <span class="close">&times;</span>
                        <!-- Modal Content (The Image) -->
                        <img class="modal-content1" id="img01">
                        <!-- Modal Caption (Image Text) -->
                        <div id="caption1"></div>
                    </div>
                    <img id="profileImg2" src="../Uploads/<?php echo $person->pimage; ?>" alt="Profile image">
                    <div id="myModal2" class="modal2">
                        <span class="close">&times;</span>
                        <img class="modal-content2" id="img02">
                        <div id="caption2"></div>
                    </div>
                    <div class="dropdown drop-down">
                        <button class="btn btn-secondary drop-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                        <ul class="dropdown-menu menu">
                            <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?follow=<?php echo $_GET['pid']; ?>"><i class='bx bx-user-plus' ></i> Follow</a></li>
                            <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?mute=<?php echo $_GET['pid']; ?>"><i class='bx bx-volume-mute' ></i> Mute</a></li>
                            <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?block=<?php echo $_GET['pid']; ?>"><i class="fa-solid fa-ban"></i> Block</a></li>
                            <li><a class="dropdown-item" href="http://localhost/twitter/Views/00.php?report=<?php echo $_GET['pid']; ?>"><i class='bx bx-file-blank' ></i> Report User</a></li>
                        </ul>
                    </div>
                    <?php
                    ?>
                    <div class="data">
                        <span class="name"><?php echo $person->Fname; ?> <?php echo $person->Lname; ?></span>
                        <span class="uname">@<?php echo $person->uname; ?></span>
                        <span class="date"><i class="fa fa-calendar"></i> Joined <?php echo $person->date; ?></span>
                        <a href="#"><span class="number"><?php  $following = $personControl->numberFollowing($person->id); echo $following[0]['count(*)']; ?></span><span> Following</span></a>
                        <a href="#"><span class="number"><?php  $follower = $personControl->numberFollower($person->id); echo $follower[0]['count(*)']; ?></span><span></span><span> Followers</span></a>
                    </div>
                    <div class="menu">
                        <a href="http://localhost/twitter/Views/profile.php?pid=<?php echo $_GET['pid'] ?>&posts" class="ppp">Posts</a>
                        <a href="http://localhost/twitter/Views/profile.php?pid=<?php echo $_GET['pid'] ?>&retweets" class="ppp">Retweets</a>
                    </div>
                </div>
                <?php 
                if(isset($_GET['retweets'])){
                    require_once '../Controllers/PostController.php';
                    $result5 = $postController->getMyRetweet($_GET['pid']);
                    if($result5){
                        for($i=0; $i<count($result5) ; $i++){?>
                            <div class="sharePost">
                                <img class="userShareimage" src="../Uploads/<?php  echo $person->pimage ?>" alt="">
                                <p class="title"><?php echo $person->Fname." ".$person->Lname ?></p>
                                <p class="newContent">
                                    <?php echo $result5[$i]['newContent'];?>
                                </p>
                                <div class="dropdown drop-down">
                                    <button class="btn btn-secondary drop-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu menu">
                                        <li><a class="dropdown-item" href="oneItem.php?retweetid=<?php echo $result[$i]['shareid'] ;?>&comments"><i class="fa-solid fa-comment"></i> Comments</a></li>
                                        <li><a class="dropdown-item" href="oneItem.php?retweetid=<?php echo $result[$i]['shareid'] ;?>&likes"><i class="fa-solid fa-thumbs-up"></i> Likes</a></li>
                                        <li><a class="dropdown-item" href="oneItem.php?retweetid=<?php echo $result[$i]['shareid'] ;?>&retweets=<?php echo $result5[$i]['postid'] ;?>"><i class="fa-solid fa-retweet"></i> Retweets</a></li>
                                    </ul>
                                </div>
                                <div class="old_data">
                                    <img class="oldimage" src="../Uploads/<?php echo $oldPersonControl->getPersonData($result5[$i]['oldid'])->pimage ;?>" alt="">
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
                                        <a class="a" href="manage_post.php">
                                            <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                            <span><?php echo $postController->numberOfLikes("retweet",$result5[$i]['shareid'])[0]['count(*)'] ?> Like</span>
                                        </a>
                                    </span>
                                    <span class="co">
                                        <a class="comment_btn" href="?retweets&addRetweetComment=<?php echo $result5[$i]['shareid'];?>" id="comment-btn">
                                            <span class="icon"><i class="fa-solid fa-comments"></i></span>
                                            <span><?php echo $postController->numberOfComments("retweet",$result5[$i]['shareid'])[0]['count(*)'] ?> Comment</span>
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
                                        <a class="retweet_btn" href="?retweet=<?php echo $result5[$i]['postid'];?>&oldid=<?php echo $result5[$i]['oldid'];?>" id="comment-btn">
                                            <span class="icon"><i class="fa-solid fa-retweet"></i></span>
                                            <span><?php echo $postController->numberOfRetweets($result5[$i]['shareid'])[0]['count(*)'] ?> Retweet</span>
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
                                        <a href="#">
                                            <span class="icon"><i class="fa-regular fa-share-from-square"></i></span>
                                            <span>Share</span>
                                        </a>
                                    </span>
                                </div>
                            </div>
                    <?php
                        }
                        ?>
                        
                    <?php
                    }
                    else{?>
                        <div class="empty">
                            No Retweets Found!
                        </div>
                    <?php
                    }
                }
                elseif(isset($_GET['ads'])){
                    $result = $adControl->getMine($person->id);
                    if(count($result) == 0){
                        echo "<div class='empty'>No Advertisement</div>";
                    } 
                    else{
                        for( $i = 0 ; $i < count($result); $i++){?>
                            <div class="Ad">
                                <img class="pimage-post" src="../Uploads/<?php echo $result[$i]['pimage']; ?>" alt="">
                                <p class="title"><?php echo $result[0]['Fname']; ?> <?php echo $result[$i]['Lname']; ?></p>
                                <div class="dropdown drop-down">
                                    <button class="btn btn-secondary drop-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu menu">
                                    <li><a class="dropdown-item" href="oneItem.php?adid=<?php echo $result[$i]['Adid'] ;?>&comments"><i class="fa-solid fa-comment"></i> Comments</a></li>
                                    <li><a class="dropdown-item" href="oneItem.php?adid=<?php echo $result[$i]['Adid'] ;?>&likes"><i class="fa-solid fa-thumbs-up"></i> Likes</a></li>
                                    </ul>
                                </div>
                                <?php
                                if($result[$i]['image'] != ''){?>
                                    <span>
                                        <img src="../Uploads/<?php echo $result[$i]['image'] ?>" alt="" width="600" height="200">
                                    </span>
                                <?php
                                }
                                ?>
                                <?php
                                if($result[$i]['content'] != ''){?>
                                    <p class="content">
                                        <?php echo $result[$i]['content']; ?>
                                    </p>
                                <?php
                                }
                                ?>
                                
                                <div class="interactive">
                                    <?php
                                    if($adControl->check($result[$i]['Adid'],$id)){?>
                                        <span class="co_Like">
                                            <a class="a" href="manage_ads.php?removeAdLike=<?php echo $result[$i]['Adid']; ?>">
                                                <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                                <span><?php echo $postController->numberOfLikes("ad",$result[$i]['Adid'])[0]['count(*)'] ?> Like</span>
                                            </a>
                                        </span>
                                        <?php
                                    }
                                    else{?>
                                        <span class="co">
                                            <a class="a" href="manage_ads.php?addAdLike=<?php echo $result[$i]['Adid']; ?>">
                                                <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                                <span><?php echo $postController->numberOfLikes("ad",$result[$i]['Adid'])[0]['count(*)'] ?> Like</span>
                                            </a>
                                        </span>
                                        <?php
                                    }
                                    ?>
                                    <span class="co">
                                        <a class="comment_btn" href="?ads&addComment=<?php echo $result[$i]['Adid'] ?>" id="comment-btn">
                                            <span class="icon"><i class="fa-solid fa-comments"></i></span>
                                            <span><?php echo $postController->numberOfComments("ad",$result[$i]['Adid'])[0]['count(*)'] ?> Comment</span>
                                        </a>
                                    </span>
                                    <span class="share">
                                        <a href="#">
                                            <span class="icon"><i class="fa-regular fa-share-from-square"></i></span>
                                            <span>Share</span>
                                        </a>
                                    </span>
                                </div>
                            </div>
                            <?php
                        }
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
                    }
                }
                else{?>
                    <?php
                    $result = $postController->getMyPublic($person->id);
                    if(count($result) == 0){
                        echo "<div class='empty'>No Posted Tweets</div>";
                    }
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
                                    <li><a class="dropdown-item" href="oneItem.php?postid=<?php echo $result[$i]['postid'] ;?>&comments"><i class="fa-solid fa-comment"></i> Comments</a></li>
                                    <li><a class="dropdown-item" href="oneItem.php?postid=<?php echo $result[$i]['postid'] ;?>&likes"><i class="fa-solid fa-thumbs-up"></i> Likes</a></li>
                                    <li><a class="dropdown-item" href="oneItem.php?postid=<?php echo $result[$i]['postid'] ;?>&retweets"><i class="fa-solid fa-retweet"></i> Retweets</a></li>
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
                                    <a class="a" href="#">
                                        <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                        <span><?php echo $postController->numberOfLikes("tweet",$result[$i]['postid'])[0]['count(*)'] ?> Like</span>
                                    </a>
                                </span>
                                <span class="co">
                                    <a class="comment_btn" href="?addComment=<?php echo $result[$i]['postid'];?>" id="comment-btn">
                                        <span class="icon"><i class="fa-solid fa-comments"></i></span>
                                        <span><?php echo $postController->numberOfComments("tweet",$result[$i]['postid'])[0]['count(*)'] ?> Comment</span>
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
                                        <span><?php echo $postController->numberOfRetweets($result[$i]['postid'])[0]['count(*)'] ?> Retweet</span>
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
                                    <a href="#">
                                        <span class="icon"><i class="fa-regular fa-share-from-square"></i></span>
                                        <span>Share</span>
                                    </a>
                                </span>
                            </div>
                        </div>
                    <?php 
                    }
                }
                ?>
            </div>
            <!-- Start Right bar-->
            <?php include 'rightbar.php'; ?>
            <!-- End Right bar-->
        </div>
    </div>
    <?php include "includes/footer.php";
}*/
else{
    header("location: http://localhost/twitter/Views/Auth/auth.php");
}

?>
<script>
    let menu = document.getElementsByClassName('p');
    for (let i=0; i<menu.length; i++){
        menu[i].onclick = function(){
            let j = 0;
            while(j < menu.length){
                menu[j++].className = 'p';
            }
            menu[i].className = 'p active'
        }
    }
</script>
<script>
    // Get the modal
    var modal1 = document.getElementById("myModal1");
    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img1 = document.getElementById("coverImg");
    var modalImg1 = document.getElementById("img01");
    var captionText1 = document.getElementById("caption1");

    var modal2 = document.getElementById("myModal2");
    var img2 = document.getElementById("profileImg");
    var modalImg2 = document.getElementById("img02");
    var captionText2 = document.getElementById("caption2");
    img1.onclick = function(){
        modal1.style.display = "block";
        modalImg1.src = this.src;
        captionText1.innerHTML = this.alt;
    }
    img2.onclick = function(){
        modal2.style.display = "block";
        modalImg2.src = this.src;
        captionText2.innerHTML = this.alt;
    }

    // Get the <span> element that closes the modal
    var span1 = document.getElementsByClassName("close")[0];
    var span2 = document.getElementsByClassName("close")[1];
    // When the user clicks on <span> (x), close the modal
    span1.onclick = function() {
        modal1.style.display = "none";
    }
    span2.onclick = function() {
        modal2.style.display = "none";
    }
</script>