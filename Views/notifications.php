<?php include 'includes/header.php'; ?>
<?php
require_once '../Controllers/personController.php';
require_once '../Controllers/notificationController.php';
require_once '../Models/notifications.php';
$personControl = new PersonController;
$notControl = new NotificationController;
$note = new Notifications;
if(session_status() == 0){
    session_start();
}
elseif(session_status() == 1){
    session_start();
}
if(isset($_SESSION['Aid'])){$id = $_SESSION['Aid'];}
elseif(isset($_SESSION['CCid'])){$id = $_SESSION['CCid'];}
elseif(isset($_SESSION['Uid'])){$id = $_SESSION['Uid'];}
if(isset($_GET['uid']) && $_POST['Send']){
    if(trim($_POST['content']) != ""){
        $note->aid = $id;
        $note->uid = $_GET['uid'];
        $note->content = $_POST['content'];
        if($notControl->addNotification($note)){
            header("location: notifications.php");
        }
    }
    else{
        $_SESSION['errMsg'] = "The Content Cannot Be spaces.";
        header("location: err.php");
    }
}
if(isset($_GET['deleteNote'])){
    if($notControl->deleteNotification($_GET['deleteNote'])){
        header("location: profile.php");
    }
}


if (isset($_SESSION['uname'])){?>
    <div class="container">
        <div class="row">
            <!-- Start Sidebar-->
            <?php include 'sidebar.php'; ?>
            <!-- End sidebar -->
            <div class="col-2"></div>
            <div class="col-6 post-container" id="post-container">
                <!-- Start Search Tweet Form-->
                <?php
                if(isset($_SESSION['Aid'])){?>
                    <form action="explore.php?search" method="GET">
                        <div class="search-users">
                            <input type="text" class="" placeholder="Search for Tweet!" name="content">
                            <input class="search-button" type="submit" value="Search">
                        </div>
                    </form>
                    <!-- End Search Tweet Form-->
                    <div class="users">
                        <?php
                        $result = $personControl->getAllUsers($id);
                        if(isset($_GET['content'])){
                            $search = $_GET['content'];
                            if($personControl->getSomeUsers($id, $search)){
                                $searchResult = $personControl->getSomeUsers($id, $search);
                                for( $i = 0 ; $i < count($searchResult); $i++){
                                ?>
                                    <div class="user">
                                        <a href="profile.php?pid=<?php echo $searchResult[$i]['id'] ?>">
                                            <span><img class="sm-img" src="../Uploads/<?php echo $searchResult[$i]['pimage']; ?>" width="60" height="60"></span>
                                            <span><?php echo $searchResult[$i]['Fname']." ".$searchResult[$i]['Lname']; ?></span>
                                        </a>
                                        <a href="#" class="send_note">
                                            Send Notification
                                        </a>
                                    </div>
                                <?php
                                }
                            }
                            else{
                                ?>
                                <div class="empty">
                                    No Result Found!
                                </div>
                            <?php
                            }
                        }
                        else{
                            for( $i = 0 ; $i < count($result); $i++){
                            ?>
                                <div class="user">
                                    <a href="profile.php?pid=<?php echo $result[$i]['id'] ?>">
                                        <span><img class="sm-img" src="../Uploads/<?php echo $result[$i]['pimage']; ?>" width="60" height="60"></span>
                                        <span><?php echo $result[$i]['Fname']." ".$result[$i]['Lname']; ?></span>
                                    </a>
                                    <a href="?addNote=<?php echo $result[$i]['id'] ?>" class="send_note">
                                        Send Notification
                                    </a>
                                </div>
                            <?php
                            } 
                        }
                        ?>
                    </div>
                    <?php
                    if(isset($_GET['addNote'])){?>
                        <div class="com_form" id="myForm_com">
                            <form action="?uid=<?php echo $_GET['addNote'];?>" method="POST" class="comment_form">
                                <textarea class="post_area" name="content" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' placeholder="Post your reply"></textarea>
                                <div class="easy"><input type="submit" name="Send" value="Send" class="reply_btn"></div>
                                <a href="notifications.php" class="closeForm2" id="closeForm2">&times;</a>
                            </form>
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
<?php
}
else{
    header('location: Auth/auth.php');
}

?>
    
    <?php include 'includes/footer.php'; ?>