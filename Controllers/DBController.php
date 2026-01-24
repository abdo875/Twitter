<?php
class DBController{

    private  $dbHost = "localhost";
    private $dbUser = "root";
    private $dbPass = "";
    private $dbName = "twitter";
    private $connection;
    private static $obj;

    private final function __construct(){}
    public static function getConnect(){
        if(!isset(self::$obj)){
            self::$obj = new DBController;
        }
        return self::$obj;
    }
    public function openConnection () {
        $this->connection = new mysqli($this->dbHost, $this->dbUser, $this->dbPass, $this->dbName);
        if($this->connection->connect_error){
            echo 'Error in connection: '.$this->connection->connect_error;
            return false;
        }
        else {
            return true;
        }
    }
    public function closeConnection(){
        if($this->connection){
            $this->connection->close();
        }
        else {
            echo 'connection is not opened';
        }
    }
    public function select($qry){
        $result = $this->connection->query($qry);
        if(!$result){
            echo"ERROR: ".mysqli_error($this->connection) ;
            return false;
        }
        else{
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }
    public function numbers($qry){
        $result = $this->connection->query($qry);
        if($result === false){
            echo"ERROR: ".mysqli_error($this->connection) ;
            return false;
        }
        else{
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }
    public function insert($qry){
        $result = $this->connection->query($qry);
        if(!$result){
            echo"ERROR: ".mysqli_error($this->connection) ;
            return false;
        }
        else{
            return $this->connection->insert_id;
            //return true;
        }
    }
    public function delete($qry){
        $result = $this->connection->query($qry);
        if(!$result){
            echo"ERROR: ".mysqli_error($this->connection) ;
            return false;
        }
        else{
            return true;
        }
    }
    public function update($qry){
        $result = $this->connection->query($qry);
        if(!$result){
            echo"ERROR: ".mysqli_error($this->connection) ;
            return false;
        }
        else{
            return true;
        }
    }
}
?>