<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("location: index.php");
}
include('../db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $checkQuery = "SELECT * FROM membership_details WHERE membership_id = $id";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        $_SESSION['errors'] = ["Cannot delete the membership because there are active subscriptions associated with it."];
    } else {
        $deleteQuery = "DELETE FROM membership WHERE id = $id";

        if (mysqli_query($conn, $deleteQuery)) {
            $_SESSION['Done'] = "Membership deleted successfully.";
        } else {
            $_SESSION['errors'] = ["Failed to delete the membership."];
        }
    }
}

header("location: all_membership.php");
?>
