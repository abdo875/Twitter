<?php include 'includes/header.php'; ?>
    <div class="container">
        <div class="row">
            <!-- Start Sidebar-->
            <?php include 'sidebar.php'; ?>
            <!-- End sidebar -->
            <div class="col-2"></div>
            <div class="col-6 post-container" id="post-container">
                <?php
                require_once '../Controllers/personController.php';
                require_once '../Controllers/adminFunctions.php';
                $adminControl = new AdminFunctions;
                $personControl = new PersonController;
                $result = $adminControl->getReportedUsers();
                
                ?>
                <div class="report_Title"><p>Reported Users</p></div>
                
                    <?php
                    if(isset($_GET['uid'])){
                        $result2 = $adminControl->getReports($_GET['uid']);
                        ?>
                        <div class="reported_users">
                            <div class="reported_user">
                                <a href="?uid=<?php echo $_GET['uid'] ?>">
                                    <span><img class="sm-img" src="../Uploads/<?php echo ($personControl->getPersonData($_GET['uid']))->pimage ?>" width="60" height="60"></span>
                                    <span class="uname"><?php echo ($personControl->getPersonData($_GET['uid']))->Fname ?> <?php echo ($personControl->getPersonData($_GET['uid']))->Lname ?></span>
                                    <span class="noReports"><?php echo count($result2); ?></span>
                                </a>
                                <?php
                                if(!isset($_SESSION['uname'])){session_start();}
                                if(!$personControl->checkFollow('ban',$_SESSION['Aid'],$_GET['uid'])){?>
                                    <span class="ban"><a href="http://localhost/twitter/Views/manage_users.php?banUser=<?php echo $_GET['uid'] ?>"><i class="fa-solid fa-user-slash"></i> Ban</a></span>
                                <?php
                                } else{?>
                                    <span class="approve"><a href="http://localhost/twitter/Views/manage_users.php?approveUser=<?php echo $_GET['uid'] ?>"><i class="fa-solid fa-user-check"></i> Approve</a></span>
                                <?php
                                }
                                ?>
                                <span class="delete"><a href="http://localhost/twitter/Views/manage_users.php?deleteUser=<?php echo $_GET['uid'] ?>"><i class="fa-solid fa-user-minus"></i> Delete</a></span>
                            </div>
                        </div>
                        <div class="reports">
                            <?php
                            for($i = 0; $i < count($result2); $i++){?>
                                    <div class="report">
                                        <p><?php echo $result2[$i]['content'] ?></p>
                                        <span><a href="manage_users.php?deleteReport=<?php echo $result2[$i]['rid'] ?>" class="delete"><i class="fa-solid fa-trash"></i> Delete</a></span>
                                    </div>
                                
                            <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    
                    else{
                        ?>
                        <div class="reported_users">
                            <?php
                            for($i =0; $i <count($result) ; $i++){?>
                                <div class="reported_user">
                                    <a href="?uid=<?php echo $result[$i]['uid'] ?>">
                                        <span><img class="sm-img" src="../Uploads/<?php echo ($personControl->getPersonData($result[$i]['uid']))->pimage ?>" width="60" height="60"></span>
                                        <span class="uname"><?php echo ($personControl->getPersonData($result[$i]['uid']))->Fname ?> <?php echo ($personControl->getPersonData($result[$i]['uid']))->Lname ?></span>
                                        <span class="noReports"><?php echo $result[$i]['count(*)'] ?></span>
                                    </a>
                                    <?php
                                    if(!isset($_SESSION['uname'])){session_start();}
                                    if(!$personControl->checkFollow('ban',$_SESSION['Aid'],$result[$i]['uid'])){?>
                                        <span class="ban"><a href="http://localhost/twitter/Views/manage_users.php?banUser=<?php echo $result[$i]['uid'] ?>"><i class="fa-solid fa-user-slash"></i> Ban</a></span>
                                    <?php
                                    } else{?>
                                        <span class="approve"><a href="http://localhost/twitter/Views/manage_users.php?approveUser=<?php echo $result[$i]['uid'] ?>"><i class="fa-solid fa-user-check"></i> Approve</a></span>
                                    <?php
                                    }
                                    ?>
                                    <span class="delete"><a href="http://localhost/twitter/Views/manage_users.php?deleteUser=<?php echo $result[$i]['uid'] ?>"><i class="fa-solid fa-user-minus"></i> Delete</a></span>
                                </div>
                                <?php
                            }
                            if(count($result) == 0){
                                echo "<div class='empty'>No Reported User</div>";
                            }
                            ?>
                        </div>
                        <?php
                    }
                    
                    ?>
                    
                
            </div>
            <!-- Start Right bar-->
            <?php include 'rightbar.php'; ?>
            <!-- End Right bar-->
        </div>
    </div>