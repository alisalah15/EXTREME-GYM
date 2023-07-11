<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("location: index.php");
}
include ('../db.php');
if(isset($_GET['id'])){

    $id= $_GET['id'];
    $sql="DELETE from `messages` where `id`='$id'";

    if(mysqli_query($conn,$sql)){
        $_SESSION['Done']= "message Deleted";

    }
    else{
        $_SESSION['errors'] = "message Cannot Deleted";
    
    }
}

        header("location: messages.php");


?>