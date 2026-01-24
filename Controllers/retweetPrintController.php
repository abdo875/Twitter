<?php
    require_once '../Models/post.php';
    require_once '../Models/sharedPost.php';
    require_once "DBController.php";
    class RetweetPrintController{
        protected $db;
        public function __construct() {
            $this->db = DBController::getConnect();
        }
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
    }