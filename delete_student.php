<?php
include_once 'config/database.php';
include_once "classes/student.php";

$database = new Database();
$db = $database->getConnection();
$student = new Student($db);
if(isset($_GET['id'])){
  $id = $_GET['id'];
  if($student->delete($id)){
    header("location:index.php");
    
  }else{
    echo "Something went wrong";
  }
}
?>