<?php
    require_once "../Models/person.php";
    require_once "DBController.php";
class PersonController {
    protected $db;
    public function __construct() {
        $this->db = DBController::getConnect();
    }
    public function getAllUsers($id){
        if($this->db->openConnection()){
            if($id != 0){
                $plusquery = "where id != $id && id not in (SELECT pid from blockuser where blockuser.uid = $id)";
            }
            else{
                $plusquery = "";
            }
            $query ="select * from person $plusquery";
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
    public function getSomeUsers($id, $search){
        $array = explode(" ", $search, PHP_INT_MAX);
        if($this->db->openConnection()){
            if($id != 0){$plusquery = "&& id != $id && id not in (SELECT pid from blockuser where blockuser.uid = $id)";}
            else{$plusquery = "";}
            if(count($array) > 2 || count($array) == 0){
                return false;
            }
            elseif(count($array) == 1){
                $first = $array[0];
                $query ="select * from person where ( Fname like '%$first%' || Lname like '%$first%' || uname like '%$first%' ) $plusquery";
            }
            elseif(count($array) == 2){
                $first = $array[0];
                $second = $array[1];
                $query ="select * from person where (Fname like '%$first%' || Lname like '%$first%' || uname like '%$first%' || Fname like '%$second%' || Lname like '%$second%' || uname like '%$second%')  $plusquery";
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
    public function getLatestUsers($id){
        if($this->db->openConnection()){
            if($id != 0){
                $query ="select * from person where id != $id && id not in (select uid from followuser where pid = $id) limit 5";
            }
            else{
                $query ="select * from person limit 5";
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
    public function getPersonData($id) {
        if($this->db->openConnection()){
            $query ="select * from person where id=$id";
            $result = $this->db->select($query);
            if($result === false){
                echo "Error in Query.";
                return false;
            }
            else{
                $person = new Person;
                $person->id = $id;
                $person->uname = $result[0]['uname'];
                $person->pass = $result[0]['pass'];
                $person->email = $result[0]['email'];
                $person->Fname = $result[0]['Fname'];
                $person->Lname = $result[0]['Lname'];
                $person->role = $result[0]['role'];
                $person->FPQ = $result[0]['FPQ'];
                $person->phone = $result[0]['phone'];
                $person->pimage = $result[0]['pimage'];
                $person->cimage = $result[0]['cimage'];
                $person->date = $result[0]['date'];
                return $person;
            }
        }
    }
    public function numberFollowing($id){
        if($this->db->openConnection()){
            $query ="select count(*) from followuser where pid= $id ";
            $result = $this->db->numbers($query);
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
    public function numberFollower($id){
        if($this->db->openConnection()){
            $query ="select count(*) from followuser where uid= $id ";
            $result = $this->db->numbers($query);
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
    public function numberOfReports($id){
        if($this->db->openConnection()){
            $query ="select count(*) from report where uid = $id";
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
    public function checkFollow($type,$id,$uid){
        if ($id == 0){
            return false;
        }
        if($this->db->openConnection()){
            if($type == 'follow'){
                $query ="select * from followuser where pid=$id && uid=$uid";
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
            elseif($type == 'mute'){
                $query ="select * from muteuser where pid=$id && uid=$uid";
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
            elseif($type == 'block'){
                $query ="select * from blockuser where pid=$id && uid=$uid";
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
            elseif($type == 'ban'){
                $query ="select * from person where id=$uid && banned=1";
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
        }
        else{
            echo 'error in database Connection';
            return false;
        }
    }
    public function updateInfo(Person $person){
        if($this->db->openConnection()){
            $query1 = "update person  
            set email = '$person->email',
            pass = '$person->pass',
            Fname = '$person->Fname',
            Lname = '$person->Lname',
            FPQ = '$person->FPQ',
            phone = '$person->phone',
            pimage = '$person->pimage',
            cimage = '$person->cimage'
            where id = $person->id
            ";
            echo $query1;
            $result1 = $this->db->update($query1);
            if($result1 === false){
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

//userSubscriber

    /*
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
    */
    









//admin
/*
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
    }*/
}