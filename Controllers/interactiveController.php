<?php
    require_once '../Models/post.php';
    require_once '../Models/sharedPost.php';
    require_once "DBController.php";
    class InteractiveController{
        protected $db;
        public function __construct() {
            $this->db = DBController::getConnect();
        }

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
    }