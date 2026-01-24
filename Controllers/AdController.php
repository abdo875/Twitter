<?php
require_once '../Models/advertisement.php';
require_once '../Controllers/DBController.php';
class AdController{
    protected $db;
    public function __construct() {
        $this->db = DBController::getConnect();
    }
    public function addAd(Advertisement $Ad){
        if($this->db->openConnection()){
            $query ="insert into advertisement values ('$Ad->ccid','','$Ad->content','$Ad->image',now(),'0','0')";
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
    public function deleteAd($Adid){
        if($this->db->openConnection()){
            $query = "delete from advertisement where Adid = $Adid";
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
    public function getAllAds(){
        if($this->db->openConnection()){
            $query = "SELECT * FROM advertisement inner JOIN person on person.id = advertisement.ccid ORDER BY advertisement.date DESC";
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
    public function getAdsWithoutMine($id){
        if($this->db->openConnection()){
            $query = "SELECT * FROM advertisement 
            inner JOIN person on person.id = advertisement.ccid 
            WHERE advertisement.ccid not in (SELECT uid from blockuser where blockuser.pid = $id) && advertisement.ccid !=$id && advertisement.ccid not in (SELECT uid from muteuser where muteuser.pid = $id)
            ORDER BY advertisement.date DESC";
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
    public function getMine($id){
        if($this->db->openConnection()){
            $query = "SELECT * FROM advertisement 
            inner JOIN person on person.id = advertisement.ccid 
            WHERE advertisement.ccid = $id
            ORDER BY advertisement.date DESC";
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
    public function getOneAd($id){
        if($this->db->openConnection()){
            $query = "SELECT * FROM advertisement 
            inner JOIN person on person.id = advertisement.ccid 
            where Adid = $id";
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
    public function addAdLike($pid, $Adid){
        if($this->db->openConnection()){
            $query ="insert into adlike values('$pid','','$Adid')";
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
    public function removeAdLike($pid, $Adid){
        if($this->db->openConnection()){
            $query ="delete from adlike where pid = $pid && Adid =$Adid";
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
    public function check($postid,$id){
        if ($id == 0){
            return false;
        }
        if($this->db->openConnection()){
            $query ="select * from adlike where pid = $id && Adid =$postid";
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
        else{
            echo 'error in database Connection';
            return false;
        }
    }
}
?>