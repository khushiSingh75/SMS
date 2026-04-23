<?php
class Database{
private $host = "localhost:3307";
private $user = "root";
private $password = "";
private $db_name = "student_db";

public $conn;

public function getConnection(){
  $this->conn = new mysqli($this->host, $this->user, $this->password, $this->db_name);
  if($this->conn->connect_error){
    die("Connection failed: ". $this->conn->connect_error);
  }
  return $this->conn;
}
}
?>