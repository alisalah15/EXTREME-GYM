<?php
    include('../db.php');
    session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email_from = $_POST['emailFrom'];
    $email_to = $_POST['emailTo'];
    $coin = $_POST['coin'];
    $balance = $_POST['balance'];
    $errors = array();


    if($email_from==$email_to){
      $errors[] =  "Write a valid email that can be transferred to yourself";
      $_SESSION['errors'] = $errors;
      header("Location: ../tcoin.php");
      exit;
    }

    // Check if email exists in the users table
    $query = "SELECT * FROM users WHERE email = '$email_to'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $recipientBalance = $row['balance'];
    
      if ($coin > $balance) {
        // Coin is greater than the balance, show an error
        $errors[] =  "Insufficient balance to transfer the specified amount of coins.";
        $_SESSION['errors'] = $errors;
      } else {
        // Insert transfer data into the transfer table
        $query = "INSERT INTO transfer (from_email, to_email, coin) VALUES ('$email_from', '$email_to', $coin)";
        mysqli_query($conn, $query);
    
        // Update the balance in the users table for the sender
        $newBalance = $balance - $coin;
        $query = "UPDATE users SET balance = $newBalance WHERE email = '$email_from'";
        mysqli_query($conn, $query);
    
        // Update the balance in the users table for the recipient
        $newRecipientBalance = $recipientBalance + $coin;
        $query = "UPDATE users SET balance = $newRecipientBalance WHERE email = '$email_to'";
        mysqli_query($conn, $query);

        // Transfer successful
        $_SESSION['Done']= "Coins transferred successfully.";

      }
    } else {
      // Email does not exist in the users table
      $errors[] =  "Recipient email not found.";
      $_SESSION['errors'] = $errors;
    }
    
    header("Location: ../tcoin.php");


}

?>