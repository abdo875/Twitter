    <?php
        require_once '../Controllers/HashtagController.php';
        require_once '../Models/advertisement.php';
        require_once '../Controllers/AdController.php';
    ?>

    <div class="sidebar" id="sidebar">
        <ul class="l">
            <li class="logo">
                <a href="http://localhost/twitter/Views/00.php">
                    <span class="logo-icon"><i class='bx bxl-xing'></i></span>
                    <span class="logo-title">Home</span>
                </a>
            </li>
        </ul>
        <ul>
            <li class="list">
                <a href="http://localhost/twitter/Views/00.php">
                    <span class="icon"><i class="fa fa-house"></i></span>
                    <span class="title">Home</span>
                    
                </a>
            </li>
            <li class="list">
                <a href="explore.php">
                    <span class="icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <span class="title">Explore</span>
                </a>
            </li>
            <?php 
                if(session_status() == 1){
                    session_start();
                }
                if(isset($_SESSION['Aid'])){?>
                    <li class="list">
                        <a href="notifications.php">
                            <span class="icon"><i class="fa-solid fa-bell"></i></span>
                            <span class="title">Send Notifications</span>
                        </a>
                    </li>
                    <li class="list">
                        <a href="http://localhost/twitter/Views/reportedUsers.php">
                            <span class="icon"><i class="fa-solid fa-user-minus"></i></span>
                            <span class="title">Reported Users</span>
                        </a>
                    </li>
            <?php
                }
            ?>
            <?php
            if(isset($_SESSION['CCid']) || isset($_SESSION['Uid'])){?>
                <li class="list">
                    <a href="profile.php?notifications">
                        <span class="icon"><i class="fa-solid fa-bell"></i></span>
                        <span class="title">Notifications</span>
                    </a>
                </li>
            <?php
            }
            ?>
            <li class="list">
                <a href="http://localhost/twitter/Views/Ad.php">
                    <span class="icon"><i class="fas fa-ad"></i></span>
                    <span class="title">Advertisement</span>
                </a>
            </li>
            <li class="list">
                <a href="http://localhost/twitter/Views/profile.php">
                    <span class="icon"><i class="fa-solid fa-circle-user"></i></span>
                    <span class="title">Profile</span>
                </a>
            </li>
            <li class="list">
                <a href="http://localhost/twitter/Views/bookmarks.php">
                    <span class="icon"><i class="fa-solid fa-bookmark"></i></span>
                    <span class="title">Bookmarks</span>
                </a>
            </li>
            <?php
                if(isset($_SESSION['uname'])){?>
                    <button class="post-button" onclick="<?php if(isset($_SESSION['uname'])){echo 'openForm()';} else { echo 'redirect()';} ?>">Post</button>
                    <div class="form-popup" id="myForm">
                        <form action="http://localhost/twitter/Views/manage_post.php" method="POST" class="post_form" enctype="multipart/form-data">
                            <span class="title">What is in your mind?</span>
                            <select name="visibility" class="visibility">
                                <option value='0'>Public</option>
                                <option value='1'>Private</option>
                            </select>
                            <textarea class="post_area" name="content" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'></textarea>
                            <select name="hashtag" class="hashtag-select">
                                <?php 
                                    $hashtag = new HashtagController;
                                    $result = $hashtag->getHashtags();
                                    echo "<option value='null'>Choose Hashtag</option>";
                                    for($i = 0; $i < sizeof($result); $i++){
                                        echo "<option value='".$result[$i]['hid']."'>".$result[$i]['content']."</option>";
                                    }
                                ?>
                            </select>
                            <input type="text" placeholder="Or Add a new Hashtag." name="newHashtag" class="newHashtag">
                            <label for="upload-photo" class="browse">Browse...</label>
                            <input type="file" name="image" placeholder="Choose image" class="img" id="upload-photo">
                            <div class="easy"><input type="submit" name="add" value="Post" class="submit-btn"></div>
                            <span class="closeForm" id="closeForm">&times;</span>
                        </form>
                    </div>
                <?php 
                }
            ?>
            <?php
                if(isset($_SESSION['CCid'])){?>
                    <button  class="Ad-button" onclick="<?php if(isset($_SESSION['uname'])){echo 'openAdForm()';} else { echo 'redirect()';} ?>"><i class="fas fa-ad"></i> Add Ad</button>
                        <div class="addAd_for" id="addAd_for">
                            <form action="http://localhost/twitter/Views/manage_ads.php" method="POST" class="Add_Ad_From" enctype="multipart/form-data">
                                <textarea class="post_area" name="content" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' placeholder="Enter The Content of Advertisement"></textarea>
                                <label for="upload-photo2" class="browse">Browse...</label>
                                <input type="file" name="image" placeholder="Choose image" class="img" id="upload-photo2">
                                <div class="easy"><input type="submit" name="Ad" value="Add" class="Ad_btn"></div>
                                <a href="http://localhost/twitter/Views/00.php" class="closeForm2" id="closeForm2">&times;</a>
                            </form>
                        </div>
                <?php
                }
            ?>
        </ul>
        <ul class="log-out">
            <?php
                if(isset($_SESSION['uname'])){
                    
                    echo '<li class="list">';
                        echo'<a href="http://localhost/twitter/Views/logout.php">';
                            echo'<span class="icon"><i class="fa fa-sign-out"></i></span>';
                            echo'<span class="title">Log out</span>';
                        echo'</a>';
                    echo'</li>';
                    
                }else{
                    echo'<li class="list">';
                        echo'<a href="http://localhost/twitter/Views/Auth/auth.php">';
                            echo'<span class="icon"><i class="fa-solid fa-right-to-bracket"></i></span>';
                            echo'<span class="title">Login</span>';
                        echo'</a>';
                    echo'</li>';
                }?>
        </ul>
        
    </div>
    <script>
        function redirect(){
            //location.replace("http://localhost/twitter/Views/Auth/auth.php"); //This method also redirects the user to a different page, but it doesn’t save the current page in the browser’s history.
            location.href = "http://localhost/twitter/Views/Auth/auth.php"; //This method redirects the user to a different page.
        }
        function openForm() {
            document.getElementById("myForm").style.display = "block";
            let post = document.getElementById('post-container');
            let post2 = document.getElementById('post-container2');
            if(post !== null){
                post.className = 'col-6 post-container formActive';
            }
            if(post2 !== null){
                post2.className = 'activate';
            }
            let left = document.getElementsByClassName('ll');
            if(left !== null){
                for (let i=0; i<left.length; i++){
                let j = 0;
                while(j < left.length){
                    left[j].className = 'formActive';
                }
                }
            }
            let profile = document.getElementsByClassName('profile_info')[0];
            if(profile !== null){
                profile.className = 'profile_info formActive';
            }
        }
        function openAdForm() {
            document.getElementById("addAd_for").style.display = "block";
            let post = document.getElementById('post-container');
            let post2 = document.getElementById('post-container2');
            if(post !== null){
                post.className = 'col-6 post-container formActive';
            }
            if(post2 !== null){
                post2.className = 'activate';
            }
            let left = document.getElementsByClassName('ll');
            if(left !== null){
                for (let i=0; i<left.length; i++){
                let j = 0;
                while(j < left.length){
                    left[j].className = 'formActive';
                }
                }
            }
            let profile = document.getElementsByClassName('profile_info')[0];
            if(profile !== null){
                profile.className = 'profile_info formActive';
            }
        }
        let close = document.getElementById('closeForm');
        close.onclick = function(){
            document.getElementById("myForm").style.display = "none";
            let post = document.getElementById('post-container');
            let post2 = document.getElementById('post-container2');
            if(post !== null){
                post.className = 'col-6 post-container';
            }
            if(post2 !== null){
                post2.className = 'post-container2';
            }
            let profile = document.getElementsByClassName('profile_info formActive')[0];
            if(profile !== null){
                profile.className = 'profile_info';
            }
            let left = document.getElementsByClassName('formActive');
            if(left !== null){
                for (let i=0; i<left.length; i++){
                    let j = 0;
                    while(j < left.length){
                        left[j].className = 'll';
                    }
                }
            }
            
        }
    </script>
    <script>
        // add active class in selected list item
        let list = document.querySelectorAll('.list');
        for (let i=0; i<list.length; i++){
            list[i].onclick = function(){
                let j = 0;
                while(j < list.length){
                    list[j++].className = 'list';
                }
                list[i].className = 'list active'
            }
        }
        let f = document.querySelectorAll('.list');
        let l = document.querySelectorAll('.logo');
        l[0].onclick = function () {
            let j =0;
            while (j<f.length){
                f[j++].className = 'list';
            }
                f[0].className = 'list active'
        }
    </script>
    <!-- End Sidebar-->