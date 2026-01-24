<?php

require_once 'DBController.php';
require_once '../Models/hashtag.php';
class HashtagController{
    protected $db;
    public function __construct() {
        $this->db = DBController::getConnect();
    }
    public function getHashtags(){
        if($this->db->openConnection()){
            $query ="select * from hashtag";
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
    public function addHashtag(Hashtag $hashtag){
        if($this->db->openConnection()){
            $query ="insert into hashtag values ('$hashtag->pid','','$hashtag->content','1')";
            $result = $this->db->insert($query);
            if($result === false){
                echo "Error in Query.";
                return false;
            }
            else{
                return $result;
                //return true;
            }
        }
        else{
            echo 'error in database Connection';
            return false;
        }
    }
    public function getOneHashtag($id){
        if($this->db->openConnection()){
            $query ="select * from hashtag where hid = '$id'";
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
    public function updateHashtag($id){
        if($this->db->openConnection()){
            $query ="UPDATE hashtag SET no_uses = no_uses + 1  WHERE hid =$id";
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
}
?>