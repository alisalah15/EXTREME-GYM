<?php
include('../db.php');
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $name = $_GET['name'];
    $user_id = $_GET['user_id'];

    $sql = "SELECT * FROM `trainer` WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $new_balance = $row['gcoins'];

    // Calculate 20% of $new_balance
    $deduction = $new_balance * 0.2 * 100;

    $sql = "UPDATE `users` SET balance = balance + $new_balance WHERE id = $user_id";
    mysqli_query($conn, $sql);

    $sql = "UPDATE `trainer` SET balance = balance - $deduction WHERE id = $id";
    mysqli_query($conn, $sql);

    $sql = "DELETE FROM `trainer_details` WHERE `user_id` = '$user_id' AND trainer_id = $id";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['Done'] = "User Refund";
    } else {
        $_SESSION['errors'] = "User Cannot Refund";
    }

    header("location: trainer_booked.php?id=$id&name=$name");
}
