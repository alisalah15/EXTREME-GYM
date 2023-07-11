<?php
include ('../db.php');
session_start();
if(isset($_GET['id'])){
    
    $id= $_GET['id'];
    $membership= $_GET['membership'];
    $user_id= $_GET['user_id'];

    $sql = "SELECT * FROM `membership` where id = $id";
    $result=mysqli_query($conn, $sql);
    $row= mysqli_fetch_assoc($result);

    $new_balance= $row['amount'];
    $sql = "UPDATE `users` SET balance = balance + $new_balance WHERE id = $user_id";
    mysqli_query($conn, $sql);

    $sql="DELETE from `membership_details` where `user_id`='$user_id' AND membership_id= $id ";

    if(mysqli_query($conn,$sql)){
        $_SESSION['Done']= "User Refund";

    }
    else{
        $_SESSION['errors'] = "User Cannot Refund";
    
    }
    
    header("location: view_membership.php?id=$id&membership=$membership");
}