<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("location: index.php");
}
include ('../db.php');
if(isset($_GET['id'])){

    $id= $_GET['id'];
    $sql="DELETE from `class` where `id`='$id'";

    if(mysqli_query($conn,$sql)){
        $_SESSION['Done']= "Class Deleted";

    }
    else{
        $_SESSION['errors'] = "Class Cannot Deleted";
    
    }
}

        header("location: all_class.php");


?>