<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("location: index.php");
}
include('../db.php');

if (isset($_GET['id'])) {
    $trainerId = $_GET['id'];

    // Update the status to 1 in the database
    $query = "UPDATE trainer SET `status` = 3 WHERE id = $trainerId";
    mysqli_query($conn, $query);

    $_SESSION['Done']= "Trainer Blcoked " ;
    header("Location: a_trainer.php");
    exit();
}
?>
