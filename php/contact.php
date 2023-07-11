<?php
include('../db.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];

  // Insert the form data into the messages table
  $insertQuery = "INSERT INTO messages (name, email, subject, message) 
                  VALUES ('$name', '$email', '$subject', '$message')";
  mysqli_query($conn, $insertQuery);

  header("Location: ../contact.php"); 
  exit();
}
?>
