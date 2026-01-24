<?php
    require_once "../Models/person.php";
    require_once "DBController.php";
class UserSubscriber {
    protected $db;
    public function __construct() {
        $this->db = DBController::getConnect();
    }

    public function follow($id,$uid){
        if($this->db->openConnection()){
            $query ="insert into followuser values($id,$uid)";
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
    public function unFollow($id,$uid){
        if($this->db->openConnection()){
            $query ="delete from followuser where pid =$id && uid= $uid";
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
    public function muteUser($id,$uid){
        if($this->db->openConnection()){
            $query ="insert into muteuser values('$id','$uid')";
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
    public function unMuteUser($id,$uid){
        if($this->db->openConnection()){
            $query ="delete from muteuser where pid=$id && uid=$uid ";
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
    public function blockUser($id,$uid){
        if($this->db->openConnection()){
            $query ="insert into blockuser values ('$id','$uid')";
            $result = $this->db->insert($query);
            if($result === false){
                echo "Error in Query.";
                return false;
            }
            else{
                $query2 ="delete from followuser where pid=$id && uid =$uid";
                $result2 = $this->db->delete($query2);
                if($result2 === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    return true;
                }
                return true;
            }
        }
        else{
            echo 'error in database Connection';
            return false;
        }
    }
    public function unBlockUser($id,$uid){
        if($this->db->openConnection()){
            $query ="delete from blockuser where pid=$id && uid=$uid ";
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
    public function reportUser($id,$uid,$content){
        if($this->db->openConnection()){
            $query ="insert into report values('$id','$uid','','$content',now())";
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