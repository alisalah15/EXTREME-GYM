<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("location: index.php");
}
include('../db.php');

if (isset($_POST['sub'])) {
    $trainerId= $_POST['trainerId'] ;
    $gcoins= $_POST['price'] ;
    // Update the status to 1 in the database
    $query = "UPDATE trainer SET `status` = 1 WHERE id = $trainerId";
    mysqli_query($conn, $query);

    // Update the g-coins in the database
    $query1 = "UPDATE trainer SET `gcoins` = '$gcoins' WHERE id = $trainerId";
     mysqli_query($conn, $query1);

    $_SESSION['Done']= "Trainer Accetped " ;
    header("Location: p_trainer.php");
    exit();
}
?>
