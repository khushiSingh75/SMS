<?php
include_once "config/database.php";
include_once "classes/student.php";

$database = new Database();
$db = $database->getConnection();
$student = new Student($db);
if(!isset($_GET['id'])){
  header("location:index.php");
  exit();
}
$id = $_GET['id'];
$data = $student->readOne($id);
if($_SERVER['REQUEST_METHOD']== "POST"){
  $student->name = $_POST['name'];
  $student->email = $_POST['email'];
  $student->course = $_POST['course'];
  
  if ($student->update($id)) {
        header("Location: index.php?msg=updated"); // Redirect back to list
        exit();
    } else {
        $message = "<div class='alert alert-danger'>Update failed.</div>";
    }
}

?>