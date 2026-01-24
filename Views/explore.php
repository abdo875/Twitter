<?php include 'includes/header.php'; ?>
    <div class="container">
        <div class="row">
            <!-- Start Sidebar-->
            <?php include 'sidebar.php'; ?>
            <!-- End sidebar -->
            <div class="col-2"></div>
            <div class="col-6 post-container" id="post-container">
                <!-- Start Search Tweet Form-->
                <form action="explore.php?search" method="GET">
                    <div class="search-users">
                        <input type="text" class="" placeholder="Search for Tweet!" name="content">
                        <input class="search-button" type="submit" value="Search">
                    </div>
                </form>
                <!-- End Search Tweet Form-->
                <div class="users">
                    <?php
                    if(isset($_SESSION['uname'])){
                        if(isset($_SESSION['Aid'])){$id = $_SESSION['Aid'];}
                        elseif(isset($_SESSION['CCid'])){$id = $_SESSION['CCid'];}
                        elseif(isset($_SESSION['Uid'])){$id = $_SESSION['Uid'];}
                    }
                    else{
                        $id = 0;
                    }
                    require_once '../Controllers/personController.php';
                    $personControl = new PersonController;
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
                                    <?php
                                    if(!$personControl->checkFollow("follow",$id,$searchResult[$i]['id'])){?>
                                        <button onclick="follow(<?php echo $searchResult[$i]['id']; ?>)" class="follow-btn">
                                                + Follow
                                        </button>
    
                                    <?php
                                    } 
                                    else{?>
                                        <button onclick="unfollow(<?php echo $searchResult[$i]['id']; ?>)" class="follow-btn">
                                                - Unfollow
                                        </button>
                                    <?php
                                    }
                                    ?>
                                    
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
                                <?php
                                if(!$personControl->checkFollow("follow",$id,$result[$i]['id'])){?>
                                    <button onclick="follow(<?php echo $result[$i]['id']; ?>)" class="follow-btn">
                                            + Follow
                                    </button>

                                <?php
                                } 
                                else{ ?>
                                    <button onclick="unfollow(<?php echo $result[$i]['id']; ?>)" class="follow-btn">
                                            - Unfollow
                                    </button>
                                <?php
                                }
                                ?>
                            </div>
                        <?php
                        } 
                    }
                    ?>
                    <script>
                        function follow(id){
                            //location.replace("http://localhost/twitter/Views/Auth/auth.php"); //This method also redirects the user to a different page, but it doesn’t save the current page in the browser’s history.
                            location.href = "http://localhost/twitter/Views/manage_users.php?follow="+id; //This method redirects the user to a different page.
                        }
                        function unfollow(id){
                            //location.replace("http://localhost/twitter/Views/Auth/auth.php"); //This method also redirects the user to a different page, but it doesn’t save the current page in the browser’s history.
                            location.href = "http://localhost/twitter/Views/manage_users.php?unfollow="+id; //This method redirects the user to a different page.
                        }
                    </script>
                </div>
            </div>
                            <!-- Start Right bar-->
            <?php include 'rightbar.php'; ?>
            <!-- End Right bar-->
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>