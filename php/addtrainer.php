<?php
    include('../db.php');
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $trainer_id = $_POST['trainer_id'];
        $nameTrainer = $_POST['nameTrainer'];
        $balance = $_POST['balance'];
        $amount = $_POST['amount'];
        $user_id = $_SESSION['user_id'];

         // Calculate the Commission  amount
         $trainerBalance = $amount * 0.2 * 100;
         $query = "UPDATE trainer SET balance =  balance + $trainerBalance WHERE id = '$trainer_id'";
         mysqli_query($conn, $query);


        $query1 = "UPDATE users SET balance = $balance WHERE id = '$user_id'";
        mysqli_query($conn, $query1);

        $query = "INSERT INTO trainer_details (trainer_id, user_id) VALUES ('$trainer_id', $user_id)";
        if(mysqli_query($conn, $query)){
            $_SESSION['Done']= "Reservation successfully completed with $nameTrainer  ";
        }else{
            $_SESSION['errors']= ['errors'];
        }

        header("Location: ../my_trainer.php");

    }






?>