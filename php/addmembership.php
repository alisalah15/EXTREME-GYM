<?php
    include('../db.php');
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $membershipId = $_POST['mem_id'];
        $nameMembership = $_POST['nameMembership'];
        $balance = $_POST['balance'];
        $user_id = $_SESSION['user_id'];

        $query1 = "UPDATE users SET balance = $balance WHERE id = '$user_id'";
        mysqli_query($conn, $query1);

        $query = "INSERT INTO membership_details (membership_id, user_id) VALUES ('$membershipId', $user_id)";
        if(mysqli_query($conn, $query)){
            $_SESSION['Done']= "Reservation successfully completed in $nameMembership  ";
        }else{
            $_SESSION['errors']= ['errors'];
        }

        header("Location: ../my_membership.php");

    }






?>