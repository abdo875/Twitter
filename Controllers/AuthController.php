<?php
    require_once "../../Models/person.php";
    require_once "DBController.php";

class AuthController{
    protected $db;
    public function __construct() {
        $this->db = DBController::getConnect();
    }
    public function login (Person $person){
        if($this->db->openConnection()){
            $query ="select * from person where uname='$person->uname' and pass='$person->pass'";
            $result = $this->db->select($query);
            if($result === false){
                echo "Error in Query.";
                return false;
            }
            else{
                if(count($result) == 0){
                    session_start();
                    $_SESSION['errMsg'] =  "You have Enter Wrong email or password";
                    return false;
                }
                else{
                    session_start();
                    if ($result[0]['banned'] == 1){
                        $_SESSION['errMsg'] = "You are <strong>Banned</strong> For now wait one Day to return Active";
                        return false;
                    }
                    else{
                        if($result[0]['role'] == 1){
                            $_SESSION['Aid'] = $result[0]['id'];
                            $_SESSION['uname'] = $result[0]['uname'];
                        }
                        if($result[0]['role'] == 2){
                            $_SESSION['CCid'] = $result[0]['id'];
                            $_SESSION['uname'] = $result[0]['uname'];
                        }
                        if($result[0]['role'] == 3){
                            $_SESSION['Uid'] = $result[0]['id'];
                            $_SESSION['uname'] = $result[0]['uname'];
                        }
                        return true;
                    }
                    
                }

            }
        }
        else{
            echo 'error in database Connection';
            return false;
        }
    }
    public function register (Person $person){
        if($this->db->openConnection()){
            $query = "select uname from person where uname='$person->uname'";
            $result = $this->db->select($query);
            if($result === false){
                echo"Error in Query.";
                return false;
            }
            else if(count($result)>0) {
                session_start();
                $_SESSION['errMsg'] =  'Username Exist';
                return false;
            }
            else{
                session_start();
                $_SESSION['errMsg'] ='';
                $query1 = "insert into person values ('','$person->uname','$person->email','$person->pass','$person->Fname','$person->Lname','$person->role','$person->FPQ','$person->phone','$person->pimage','$person->cimage',now(),'0')";
                $result1 = $this->db->insert($query1);
                if($result1 === false){
                    echo "Error in Query.";
                    return false;
                }
                else{
                    $query2 = "select * from person where uname='$person->uname' and pass='$person->pass'";
                    $result2 = $this->db->select($query2);
                    if($result2 === false){
                        echo "Error in Query.";
                        return false;
                    }
                    else{
                        if($result2[0]['role'] == 2){
                            session_start();
                            $_SESSION['CCid'] = $result2[0]['id'];
                            $_SESSION['uname'] = $result2[0]['uname'];
                        }
                        else{
                            session_start();
                            $_SESSION['Uid'] = $result2[0]['id'];
                            $_SESSION['uname'] = $result2[0]['uname'];
                        }
                        return true;
                    }
                }
            }
            
        }
        else{
            echo 'error in database Connection';
            return false;
        }
    }
    public function forgetPass($type,$uname, $FPQ){
        if($this->db->openConnection()){
            if($type == "check"){
                $query = "select * from person where uname = '$uname' && FPQ = '$FPQ'";
                $result = $this->db->select($query);
                if($result === false){
                    echo "Error in Query.";
                    return false;
                }
                elseif(count($result) == 1){
                    return true;
                }
                else{
                    return false;
                }
            }
            elseif($type == "add"){
                $query = "update person set pass = $FPQ where uname = '$uname'";
                $result = $this->db->update($query);
                if($result === false){
                    echo "error in query";
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
}
?>