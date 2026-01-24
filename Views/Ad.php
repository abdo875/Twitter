<?php include 'includes/header.php'; 
require_once '../Models/advertisement.php';
require_once '../Controllers/AdController.php';
require_once '../Controllers/personController.php';
require_once '../Controllers/PostController.php';
require_once '../Controllers/interactiveController.php';
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
            <?php include 'sidebar.php';?>
            <!-- End sidebar -->
            <div class="col-2"></div>
            <div class="col-6 post-container" id="post-container">
                <div class="Ad_title">
                    <p>Advertisement</p>
                </div>
                <?php
                if(isset($_SESSION['uname'])){
                    $adControl = new AdController;
                    $personControl = new PersonController;
                    $postControl = new PostController;
                    $result = $adControl->getAdsWithoutMine($id);
                    if(count($result) == 0){
                        echo "<div class='empty'>No Advertisement</div>";
                    }
                    else{
                        for($i = 0 ; $i < count($result) ; $i++){?>
                            <div class="Ad">
                                <img class="pimage-post" src="../Uploads/<?php echo $result[$i]['pimage']; ?>" alt="">
                                <p class="title"><?php echo $result[$i]['Fname']; ?> <?php echo $result[$i]['Lname']; ?></p>
                                <div class="dropdown drop-down">
                                    <button class="btn btn-secondary drop-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu menu">
                                        <?php
                                            if($personControl->checkFollow('follow',$id,$result[$i]['ccid'])){ ?>
                                                <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?unfollow=<?php echo $result[$i]['ccid']; ?>"><i class='bx bx-user-minus' ></i> Unfollow</a></li>
                                        <?php
                                            } else{ ?>
                                                <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?follow=<?php echo $result[$i]['ccid']; ?>"><i class='bx bx-user-plus' ></i> Follow</a></li>
                                        <?php
                                            }
                                        ?>
                                        <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?mute=<?php echo $result[$i]['ccid']; ?>"><i class='bx bx-volume-mute' ></i> Mute</a></li>
                                        <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?block=<?php echo $result[$i]['ccid']; ?>"><i class="fa-solid fa-ban"></i> Block</a></li>
                                        <li><a class="dropdown-item" href="?report=<?php echo $result[$i]['ccid'] ?>"><i class='bx bx-file-blank' ></i> Report User</a></li>
                                    </ul>
                                </div>
                                <?php
                                if($result[$i]['image'] != ''){?>
                                    <span>
                                        <img src="../Uploads/<?php echo $result[$i]['image']; ?>" alt="" width="600" height="200">
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
                                        <a class="comment_btn" href="?addComment=<?php echo $result[$i]['Adid'] ?>" id="comment-btn">
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
                    }
                    ?>
                    
                    <?php
                }
                else{
                    $adControl = new AdController;
                    $personControl = new PersonController;
                    $postControl = new PostController;
                    $result = $adControl->getAllAds();
                    if(count($result) == 0){
                        echo "<div class='empty'>No Advertisement</div>";
                    }
                    else{
                        for($i = 0 ; $i < count($result) ; $i++){?>
                            <div class="Ad">
                                <img class="pimage-post" src="../Uploads/<?php echo $result[$i]['pimage']; ?>" alt="">
                                <p class="title"><?php echo $result[$i]['Fname']; ?> <?php echo $result[$i]['Lname']; ?></p>
                                <div class="dropdown drop-down">
                                    <button class="btn btn-secondary drop-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu menu">
                                        <?php
                                            if($personControl->checkFollow('follow',$id,$result[$i]['ccid'])){ ?>
                                                <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?unfollow=<?php echo $result[$i]['ccid']; ?>"><i class='bx bx-user-minus' ></i> Unfollow</a></li>
                                        <?php
                                            } else{ ?>
                                                <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?follow=<?php echo $result[$i]['ccid']; ?>"><i class='bx bx-user-plus' ></i> Follow</a></li>
                                        <?php
                                            }
                                        ?>
                                        <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?mute=<?php echo $result[$i]['ccid']; ?>"><i class='bx bx-volume-mute' ></i> Mute</a></li>
                                        <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php?block=<?php echo $result[$i]['ccid']; ?>"><i class="fa-solid fa-ban"></i> Block</a></li>
                                        <li><a class="dropdown-item" href="http://localhost/twitter/Views/manage_users.php"><i class='bx bx-file-blank' ></i> Report User</a></li>
                                    </ul>
                                </div>
                                <?php
                                if($result[$i]['image'] != ''){?>
                                    <span>
                                        <img src="../Uploads/<?php echo $result[$i]['image']; ?>" alt="" width="600" height="200">
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
                                    <span class="co">
                                        <a class="a" href="manage_users.php">
                                            <span class="icon_active"><i class="fa-solid fa-thumbs-up"></i></span>
                                            <span><?php echo $interactiveController->numberOfLikes("ad",$result[$i]['Adid'])[0]['count(*)'] ?> Like</span>
                                        </a>
                                    </span>
                                    <span class="co">
                                        <a class="comment_btn" href="http://localhost/twitter/Views/manage_users.php" id="comment-btn">
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
                    }
                }
                ?>
                
            </div>
            <!-- Start Right bar-->
            <?php include 'rightbar.php'; ?>
            <!-- End Right bar-->
        </div>
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

<?php include 'includes/footer.php'; ?>