<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("location: index.php");
}
include ('../db.php');
if(isset($_GET['id'])){

    $id= $_GET['id'];
    $classname= $_GET['classname'];
    $user_id= $_GET['user_id'];

    $sql="DELETE from `class_details` where `user_id`='$user_id' AND class_id= $id ";

    if(mysqli_query($conn,$sql)){
        $_SESSION['Done']= "Attende Deleted";

    }
    else{
        $_SESSION['errors'] = "Attende Cannot Deleted";
    
    }
}

        header("location: view_class.php?id=$id&classname=$classname");


?>