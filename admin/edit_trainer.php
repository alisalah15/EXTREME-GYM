<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("location: index.php");
}
include('../db.php');

if (isset($_POST['sub'])) {
    $trainerId= $_POST['trainerId'] ;
    $gcoins= $_POST['price'] ;


    // Update the g-coins in the database
    $query1 = "UPDATE trainer SET `gcoins` = '$gcoins' WHERE id = $trainerId";
     mysqli_query($conn, $query1);

    $_SESSION['Done']= "Trainer Edited " ;
    header("Location: a_trainer.php");
    exit();
}
?>
