<?php
    require_once '../Models/post.php';
    require_once '../Models/sharedPost.php';
    require_once "DBController.php";
    class TweetPrintController{
        protected $db;
        public function __construct() {
            $this->db = DBController::getConnect();
        }
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
    }