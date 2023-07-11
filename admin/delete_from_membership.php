<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("location: index.php");
}
include ('../db.php');
if(isset($_GET['id'])){

    $id= $_GET['id'];
    $membership= $_GET['membership'];
    $user_id= $_GET['user_id'];

    $sql="DELETE from `membership_details` where `user_id`='$user_id' AND membership_id= $id ";

    if(mysqli_query($conn,$sql)){
        $_SESSION['Done']= "User Deleted";

    }
    else{
        $_SESSION['errors'] = "User Cannot Deleted";
    
    }
}

        header("location: view_membership.php?id=$id&membership=$membership");


?>