<?php
class Student{
private $conn; 
private $table_name = "students";

public $name;
public $email;
public $course;

public function __construct($db){
  $this->conn = $db;
}
public function create(){
  $sql = "insert into $this->table_name (name,email,course) values(?,?,?)";
  $stmt= $this->conn->prepare($sql);
  $stmt->bind_param("sss", 
  $this->name,$this->email, $this->course
  );
  if($stmt->execute()){ return true; }
  else { return false; }
}
public function readAll(){
  $sql = "select * from $this->table_name order by id desc";
  $result = $this->conn->query($sql);
  return $result;
}
public function search($keyword){
  $sql = "select * from $this->table_name where name LIKE ?
  OR email LIKE ? OR course LIKE ? order by id desc";
  $stmt = $this->conn->prepare($sql);
  $keyword = "%$keyword%";
  $stmt->bind_param("sss", $keyword, $keyword, $keyword);
  $stmt->execute();
  return $stmt->get_result();
}
public function delete($id){
  $sql = "delete from $this->table_name where id=?";
  $stmt = $this->conn->prepare($sql);
  $stmt->bind_param("i", $id);
  if($stmt->execute()) return true;
  else return false;
}
public function readOne($id){
  $sql = "select * from $this->table_name where id=?";
  $stmt = $this->conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result(); 
  return $result->fetch_assoc(); 
}

public function update($id){
  $sql = "update $this->table_name set name=?, email=?, course=? where id=?";
  $stmt = $this->conn->prepare($sql);
  $stmt->bind_param("sssi", 
  $this->name, $this->email, $this->course, $id);
  if($stmt->execute()) return true;
  else return false;
}
}
?>