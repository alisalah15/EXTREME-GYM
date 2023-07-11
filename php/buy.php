<?php
    include('../db.php');
    session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    // Get the form data
    $cardname = $_POST['cardname'];
    $cardnumber = $_POST['cardnumber'];
    $expyear = $_POST['expyear'];
    $cvv = $_POST['cvv'];
    $coin = $_POST['coin'];
    $price = $_POST['price'];
    $coinId = $_POST['coinId'];

    // Insert the order into the order table
    $query = "INSERT INTO orders (user_id ,coin_id,cardname, cardnumber, expyear, cvv, coin, price) 
              VALUES ('$user_id' , '$coinId','$cardname', '$cardnumber', '$expyear', '$cvv', '$coin', '$price')";
    mysqli_query($conn, $query);

    // Update the user's balance in the users table
    $update_query = "UPDATE users SET balance = balance + '$coin' WHERE id = '$user_id'";
    mysqli_query($conn, $update_query);
    $_SESSION['Done']= " The purchase has been completed successfully and the balance has been added ";
    header("Location: ../bcoin.php");
}

?>