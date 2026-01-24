<?php
require_once 'DBController.php';
require_once '../Models/PostComment.php';
require_once '../Models/AdComment.php';
class PostCommentController{
    protected $db;
    public function __construct() {
        $this->db = DBController::getConnect();
    }
    public function getPostComments($postid){
        if($this->db->openConnection()){
            $query ="select * from comment where postid = $postid";
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
    public function getRetweetComments($postid){
        if($this->db->openConnection()){
            $query ="select * from retweetcomment where shareid = $postid";
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
    public function getAdComments($postid){
        if($this->db->openConnection()){
            $query ="select * from adcomment where Adid = $postid";
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
    public function addComment(PostComment $comment){
        if($this->db->openConnection()){
            $query ="insert into comment values ('$comment->pid','','$comment->comment','$comment->postid')";
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
    public function addRetweetComment(PostComment $comment){
        if($this->db->openConnection()){
            $query ="insert into retweetcomment values ('$comment->pid','','$comment->postid','$comment->comment')";
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
    public function addAdComment(AdComment $comment){
        if($this->db->openConnection()){
            $query ="insert into adcomment values ('$comment->pid','$comment->comment','','$comment->Adid')";
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
    public function deleteComment($type, $cid){
        if($this->db->openConnection()){
            if($type == "tweet"){
                $table = "comment";
            }
            elseif($type == "retweet"){
                $table = "retweetcomment";
            }
            elseif($type == "ad"){
                $table = "adcomment";
            }
            $query ="delete from $table where cid = $cid";
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
}
?>