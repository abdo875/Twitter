    <?php
    require_once '../Controllers/personController.php';
    $personController = new PersonController;
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
    <div class="col-3 right" id="right">
        <div class="trending">
            <p>What's happening</p>
            <ul>
                <li>
                    easy
                </li>
                <li>
                    easy
                </li>
                <li>
                    easy
                </li>
            </ul>
        </div>
        <div class="who">
            <p>Who to follow</p>
            <ul>
                <?php
                $result = $personController->getLatestUsers($id);
                for($i =0 ; $i < count($result); $i++){?>
                    <li class="ll">
                        <?php echo $result[$i]['Fname']." ".$result[$i]['Lname']; ?>
                        <button onclick="follow(<?php echo $result[$i]['id']; ?>)" class="follow-btn">
                            + Follow
                        </button>
                    </li>
                    <?php

                }
                ?>
                
            </ul>
        </div>
    </div>
    <script>
        function follow(id){
            //location.replace("http://localhost/twitter/Views/Auth/auth.php"); //This method also redirects the user to a different page, but it doesn’t save the current page in the browser’s history.
            location.href = "http://localhost/twitter/Views/manage_users.php?follow="+id; //This method redirects the user to a different page.
        }
    </script>