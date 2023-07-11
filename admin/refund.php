<?php
include ('../db.php');
session_start();
if(isset($_GET['id'])){
    
    $id= $_GET['id'];
    $classname= $_GET['classname'];
    $user_id= $_GET['user_id'];

    $sql = "SELECT * FROM `class` where id = $id";
    $result=mysqli_query($conn, $sql);
    $row= mysqli_fetch_assoc($result);

    $new_balance= $row['amount'];
    $sql = "UPDATE `users` SET balance = balance + $new_balance WHERE id = $user_id";
    mysqli_query($conn, $sql);

    $sql="DELETE from `class_details` where `user_id`='$user_id' AND class_id= $id ";

    if(mysqli_query($conn,$sql)){
        $_SESSION['Done']= "User Refund";


    }
    else{
        $_SESSION['errors'] = "User Cannot Refund";
    
    }
    
    header("location: view_class.php?id=$id&classname=$classname");
}