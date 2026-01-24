<?php
    require_once '../Models/post.php';
    require_once '../Models/sharedPost.php';
    require_once "DBController.php";
    class PostController{
        protected $db;
        public function __construct() {
            $this->db = DBController::getConnect();
        }
        public function addPost(Post $post){
            if($this->db->openConnection()){
                $query ="insert into post values ($post->pid,'','$post->content','$post->image','0','0',$post->hid,now(),$post->visibility)";
                $result = $this->db->insert($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return true;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function deletePost($id){
            if($this->db->openConnection()){
                $query = "delete from post where postid = $id";
                $result = $this->db->delete($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return true;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function sharePost(SharedPost $sharedPost){
            if($this->db->openConnection()){
                $query ="insert into sharedpost values ('$sharedPost->pid','$sharedPost->oldpid','$sharedPost->postid','$sharedPost->newcontent',now(),'')";
                $result = $this->db->insert($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return true;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function deleteRetweet($id){
            if($this->db->openConnection()){
                $query = "delete from sharedpost where shareid = $id";
                $result = $this->db->delete($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return true;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function changeVisibility($type,$postid){
            if($this->db->openConnection()){
                if($type == "visible"){
                    $query ="update post set visibility = 0 where postid = $postid";
                }
                else{
                    $query ="update post set visibility = 1 where postid = $postid";
                }
                $result = $this->db->update($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return true;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function checkSaved($type,$postid,$id){
            if ($id == 0){
                return false;
            }
            if($this->db->openConnection()){
                if($type == 'tweet'){
                    $query ="select * from savedpost where savepid = $id && postid =$postid";
                    $result = $this->db->select($query);
                    if($result === false){
                        echo "Error in Query.";
                        return false;
                    }
                    elseif(count($result) == 0){
                        return false;
                    }
                    else{
                        return true;
                    }
                }
                elseif($type == 'retweet'){
                    $query ="select * from savedretweet where savepid = $id && shareid = $postid";
                    $result = $this->db->select($query);
                    if($result === false){
                        echo "Error in Query.";
                        return false;
                    }
                    elseif(count($result) == 0){
                        return false;
                    }
                    else{
                        return true;
                    }
                }
                elseif($type == 'tweet_like'){
                    $query ="select * from post_like where pid = $id && postid = $postid";
                    $result = $this->db->select($query);
                    if($result === false){
                        echo "Error in Query.";
                        return false;
                    }
                    elseif(count($result) == 0){
                        return false;
                    }
                    else{
                        return true;
                    }
                }
                elseif($type == 'retweet_like'){
                    $query ="select * from retweetLike where pid = $id && retweetid = $postid";
                    $result = $this->db->select($query);
                    if($result === false){
                        echo "Error in Query.";
                        return false;
                    }
                    elseif(count($result) == 0){
                        return false;
                    }
                    else{
                        return true;
                    }
                }
                elseif($type == 'visibility'){
                    $query ="select * from post where pid = $id && postid = $postid";
                    $result = $this->db->select($query);
                    if($result === false){
                        echo "Error in Query.";
                        return false;
                    }
                    elseif($result[0]['visibility'] == 0){
                        return false;
                    }
                    elseif($result[0]['visibility'] == 1){
                        return true;
                    }
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function addGroup($id,$name){
            if($this->db->openConnection()){
                $query1 = "select * from savegroups where pid = $id && groupName = '$name'";
                $result1 = $this->db->select($query1);
                if(count($result1) == 0){
                    $query ="insert into savegroups values ('','$name','$id')";
                    $result = $this->db->insert($query);
                    if($result === false){
                        echo "Error in Query.";
                        return false;
                    }
                    else{
                        return $result;
                    }
                }
                elseif($result1 == false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    $_SESSION['errMsg'] = 'Group Name Exist.';
                    return false;
                }
                
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function deleteGroup($pid,$groupid){
            if($this->db->openConnection()){
                $query = "delete from savegroups where pid = $pid && groupid = $groupid";
                $result = $this->db->delete($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return true;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }





//interactive
/*
        public function saveTweet($pid,$postid,$groupid){
            if($this->db->openConnection()){
                $query ="insert into savedpost values ('$pid','$postid','$groupid','')";
                echo $query;
                $result = $this->db->insert($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return true;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function unSaveTweet($id,$postid){
            if($this->db->openConnection()){
                $query ="delete from savedpost where savepid =$id && postid = $postid";
                $result = $this->db->delete($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return true;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function saveRetweet($pid,$shareid,$groupid){
            if($this->db->openConnection()){
                $query ="insert into savedretweet values ('$pid','$shareid','','$groupid')";
                echo $query;
                $result = $this->db->insert($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return true;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function unSaveRetweet($savepid,$shareid){
            if($this->db->openConnection()){
                $query ="delete from savedretweet where savepid =$savepid && shareid = $shareid";
                $result = $this->db->delete($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return true;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function addTweetLike($pid, $postid){
            if($this->db->openConnection()){
                $query ="insert into post_like values('$pid','','$postid')";
                $result = $this->db->insert($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return true;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function removeTweetLike($pid, $postid){
            if($this->db->openConnection()){
                $query ="delete from post_like where pid =$pid && postid = $postid";
                $result = $this->db->delete($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return true;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function addRetweetLike($pid, $retweetid){
            if($this->db->openConnection()){
                $query ="insert into retweetLike values('$retweetid','$pid','')";
                $result = $this->db->insert($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return true;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function removeRetweetLike($pid, $retweetid){
            if($this->db->openConnection()){
                $query ="delete from retweetLike where pid = $pid && retweetid =$retweetid";
                $result = $this->db->delete($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return true;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function numberOfLikes($type,$postid){
            if($this->db->openConnection()){
                if($type == "tweet"){
                    $query ="select count(*) from post_like where postid = $postid";
                }elseif($type == "retweet"){
                    $query ="select count(*) from retweetlike where retweetid = $postid";
                }elseif($type == "ad"){
                    $query ="select count(*) from adlike where Adid = $postid";
                }
                $result = $this->db->select($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return $result;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function numberOfRetweets($postid){
            if($this->db->openConnection()){
                $query ="select count(*) from sharedpost where postid = $postid";
                $result = $this->db->select($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return $result;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function numberOfComments($type,$postid){
            if($this->db->openConnection()){
                if($type == "tweet"){
                    $query ="select count(*) from comment where postid = $postid";
                }elseif($type == "retweet"){
                    $query ="select count(*) from retweetcomment where shareid = $postid";
                }elseif($type == "ad"){
                    $query ="select count(*) from adcomment where Adid = $postid";
                }
                $result = $this->db->select($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return $result;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function getLikes($type, $postid){
            if($this->db->openConnection()){
                if($type == "tweet"){
                    $query = "SELECT * FROM post_like 
                    inner JOIN person on person.id = post_like.pid 
                    WHERE post_like.postid = $postid
                    ";
                }elseif($type == "retweet"){
                    $query = "SELECT * FROM retweetlike 
                    inner JOIN person on person.id = retweetlike.pid 
                    WHERE retweetlike.retweetid = $postid
                    ";
                }elseif($type == "ad"){
                    $query = "SELECT * FROM adlike 
                    inner JOIN person on person.id = adlike.pid 
                    WHERE adlike.Adid = $postid
                    ";
                }
                $result = $this->db->select($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return $result;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
*/









//retweetPrintController
/*
        public function getMyRetweet($id){
            if($this->db->openConnection()){
                $query = "SELECT * FROM sharedpost 
                inner JOIN person on person.id = sharedpost.retweetpid 
                inner JOIN post on post.postid = sharedpost.postid 
                WHERE sharedpost.retweetpid = $id
                ORDER BY sharedpost.date DESC";
                $result = $this->db->select($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return $result;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function getRetweetsInfo($id,$pid){
            if($pid == 0){
                $plus = "";
            }
            else{
                $plus = "";
            }
            if($this->db->openConnection()){
                $query = "SELECT * FROM sharedpost 
                inner JOIN person on person.id = sharedpost.retweetpid 
                inner JOIN post on post.postid = sharedpost.postid 
                WHERE sharedpost.postid = $id $plus
                ORDER BY sharedpost.date DESC";
                $result = $this->db->select($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return $result;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function getAllRetweetWithoutMine($id){
            if($this->db->openConnection()){
                $query = "SELECT * FROM sharedpost 
                inner JOIN person on person.id = sharedpost.retweetpid 
                inner JOIN post on post.postid = sharedpost.postid 
                WHERE sharedpost.retweetpid != $id && sharedpost.retweetpid not in (SELECT uid from blockuser where blockuser.pid = $id) && sharedpost.retweetpid not in (SELECT pid from blockuser where blockuser.uid = $id)  &&  sharedpost.retweetpid not in (SELECT uid from muteuser where muteuser.pid = $id)
                ORDER BY sharedpost.date DESC";
                $result = $this->db->select($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return $result;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function getAllRetweet(){
            if($this->db->openConnection()){
                $query = "SELECT * FROM sharedpost 
                inner JOIN person on person.id = sharedpost.retweetpid 
                inner JOIN post on post.postid = sharedpost.postid 
                ORDER BY sharedpost.date DESC";
                $result = $this->db->select($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return $result;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function getOneRetweet($id){
            if($this->db->openConnection()){
                $query = "SELECT * FROM sharedpost 
                inner JOIN person on person.id = sharedpost.retweetpid 
                inner JOIN post on post.postid = sharedpost.postid 
                where shareid = $id";
                $result = $this->db->select($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return $result;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function getSomeRetweet($search){
            if($this->db->openConnection()){
                $query = "SELECT * FROM sharedpost 
                inner JOIN person on person.id = sharedpost.retweetpid 
                inner JOIN post on post.postid = sharedpost.postid 
                where newContent like '%$search%' || post.content like '%$search%'";
                $result = $this->db->select($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return $result;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function getGroups($id){
            if($this->db->openConnection()){
                $query = "select * FROM savegroups where pid = $id";
                $result = $this->db->select($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return $result;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function getSavedTweet($id, $groupid){
            if($this->db->openConnection()){
                $query = "SELECT * FROM savedpost 
                inner JOIN person on person.id = savedpost.savepid 
                inner JOIN post on post.postid = savedpost.postid 
                where groupid = $groupid && savepid = $id
                ";
                $result = $this->db->select($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return $result;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function getSavedRetweet($id, $groupid){
            if($this->db->openConnection()){
                $query = "SELECT * FROM savedretweet 
                inner JOIN person on person.id = savedretweet.savepid 
                inner JOIN sharedpost on sharedpost.shareid = savedretweet.shareid 
                inner JOIN post on post.postid = sharedpost.postid 
                where groupid = $groupid && savepid = $id
                ";
                $result = $this->db->select($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return $result;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        

*/


//tweetPrintController
/*
        public function getMine($id){
            if($this->db->openConnection()){
                $query = "SELECT * FROM post 
                inner JOIN person on person.id = post.pid 
                WHERE pid = $id
                ORDER BY post.date DESC";
                $result = $this->db->select($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return $result;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function getPublicPost(){
            if($this->db->openConnection()){
                $query = "SELECT * FROM post inner JOIN person on person.id = post.pid WHERE visibility = 0 ORDER BY post.date DESC";
                $result = $this->db->select($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return $result;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function getPublicPostWithoutMine($id){
            if($this->db->openConnection()){
                $query = "SELECT * FROM post 
                inner JOIN person on person.id = post.pid 
                WHERE visibility = 0 && post.pid not in (SELECT uid from blockuser where blockuser.pid = $id) && post.pid not in (SELECT pid from blockuser where blockuser.uid = $id) && post.pid !=$id && post.pid not in (SELECT uid from muteuser where muteuser.pid = $id)
                ORDER BY post.date DESC";
                $result = $this->db->select($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return $result;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function getMyPublic($id){
            if($this->db->openConnection()){
                $query = "SELECT * FROM post 
                inner JOIN person on person.id = post.pid 
                WHERE pid = $id && visibility = 0
                ORDER BY post.date DESC";
                $result = $this->db->select($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return $result;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function getOneTweet($id){
            if($this->db->openConnection()){
                $query = "SELECT * FROM post 
                inner JOIN person on person.id = post.pid 
                where postid = $id";
                $result = $this->db->select($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return $result;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
        public function getSomeTweet($search){
            if($this->db->openConnection()){
                $query = "SELECT * FROM post 
                inner JOIN person on person.id = post.pid 
                where content like '%$search%' && visibility = 0";
                $result = $this->db->select($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return $result;
                }
            }
            else{
                echo 'error in database Connection';
                return false;
            }
        }
*/





    }
?>