<?php
    require_once "../Models/person.php";
    require_once "DBController.php";
class AdminFunctions {
    protected $db;
    public function __construct() {
        $this->db = DBController::getConnect();
    }
    public function banUser($id){
        if($this->db->openConnection()){
            $query ="UPDATE person SET banned = 1  WHERE id =$id ";
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
    public function approve($id){
        if($this->db->openConnection()){
            $query ="UPDATE person SET banned = 0  WHERE id =$id ";
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
    public function deleteUser($uid){
        if($this->db->openConnection()){
            $query ="delete from person where id= $uid ";
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
    public function getReports($id){
        if($this->db->openConnection()){
            $query ="select * from report where uid =$id";
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
    public function getReportedUsers(){
        if($this->db->openConnection()){
            $query ="SELECT count(*), uid FROM `report` GROUP BY uid order by count(*) desc";
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
    public function getBannedUsers(){
        if($this->db->openConnection()){
            $query = 'select * from person where banned = 1 ';
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
    public function deleteReport($uid){
        if($this->db->openConnection()){
            $query ="delete from report where rid= $uid ";
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
}