<?php
require_once '../Models/notifications.php';
require_once '../Controllers/DBController.php';
class NotificationController{
    protected $db;
    public function __construct() {
        $this->db = DBController::getConnect();
    }
    public function addNotification(Notifications $note){
        if($this->db->openConnection()){
            $query ="insert into notification values ('$note->aid','$note->uid','','$note->content',now())";
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
    public function deleteNotification($noteid){
        if($this->db->openConnection()){
            $query = "delete from notification where noteid = $noteid";
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
    public function getMyNotifications($id){
        if($this->db->openConnection()){
            $query = "SELECT * FROM notification inner JOIN person on person.id = notification.pid where pid = $id ORDER BY notification.date DESC";
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
?>