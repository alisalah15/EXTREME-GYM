<?php
    include('../db.php');
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $classId = $_POST['classId'];
        $className = $_POST['className'];
        $balance = $_POST['balance'];
        $user_id = $_SESSION['user_id'];

        $query1 = "UPDATE users SET balance = $balance WHERE id = '$user_id'";
        mysqli_query($conn, $query1);

        $query = "INSERT INTO class_details (class_id, user_id) VALUES ('$classId', $user_id)";
        if(mysqli_query($conn, $query)){
            $_SESSION['Done']= "Reservation successfully completed in class $className  ";
        }else{
            $_SESSION['errors']= ['erros'];
        }

        header("Location: ../my_class.php");

    }






?>