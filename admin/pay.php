<?php
    include('../db.php');
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $trainer_id = $_POST['trainerId'];
        $nameTrainer = $_POST['name'];
        $balance = $_POST['balance'];


         $query = "INSERT INTO `pay_details`(`trainer_id`, `amount`) VALUES 
         ('$trainer_id','$balance')";
         mysqli_query($conn, $query);


        $query1 = "UPDATE trainer SET balance =0 WHERE id = '$trainer_id'";
        mysqli_query($conn, $query1);

        if(mysqli_query($conn, $query1)){
            $_SESSION['Done']= " $nameTrainer Paid successfully ";
        }else{
            $_SESSION['errors']= ['errors'];
        }

        header("Location: a_trainer.php");

    }






?>