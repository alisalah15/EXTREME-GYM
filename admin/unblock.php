<?php
session_start();
include('../db.php');

if (isset($_GET['id'])) {
    $trainerId = $_GET['id'];

    // Update the status to 1 in the database
    $query = "UPDATE trainer SET `status` = 1 WHERE id = $trainerId";
    mysqli_query($conn, $query);

    $_SESSION['Done']= "Trainer unBlcoked " ;
    header("Location: a_trainer.php");
    exit();
}
?>
