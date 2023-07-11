<?php
session_start();
include('../db.php'); 

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = array();
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $dateOfBirth = $_POST['dob'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];

    $inputDate = new DateTime($dateOfBirth);
    $currentDate = new DateTime();
    $minBirthDate = $currentDate->modify('-16 years');

    if ($inputDate > $minBirthDate) {
        $errors[] = "Invalid date of birth. You must be at least 16 years old.";
    }

    if (!is_numeric($height) || !is_numeric($weight)) {
        $errors[] = "Height and weight must be numeric values";
    }
    if (!preg_match('/^(?:\+?20|0)?1[0-9]\d{8}$/', $phone)) {
        $errors[] = "Please enter a valid Egyptian phone number";
    }

    $emailQuery = "SELECT * FROM users WHERE email = '$email' AND id != $user_id LIMIT 1";
    $emailResult = mysqli_query($conn, $emailQuery);
    if (mysqli_num_rows($emailResult) > 0) {
        $errors[] = "Email already exists";
    }

    // Check if phone number already exists
    $phoneQuery = "SELECT * FROM users WHERE phone = '$phone' AND id != $user_id LIMIT 1";
    $phoneResult = mysqli_query($conn, $phoneQuery);
    if (mysqli_num_rows($phoneResult) > 0) {
        $errors[] = "Phone number already exists";
    }
    $emailQuery1 = "SELECT * FROM trainer WHERE email = '$email' AND email != '$email' LIMIT 1";
    $emailResult1 = mysqli_query($conn, $emailQuery1);
    if (mysqli_num_rows($emailResult1) > 0) {
        $errors[] = "Email already exists";
    }

    // Check if phone number already exists
    $phoneQuery1 = "SELECT * FROM trainer WHERE phone = '$phone' AND phone != $phone LIMIT 1";
    $phoneResult1 = mysqli_query($conn, $phoneQuery1);
    if (mysqli_num_rows($phoneResult1) > 0) {
        $errors[] = "Phone number already exists";
    }


    if (empty($errors)) {
        // Form data is valid
        $updateQuery = "UPDATE users SET `name` = '$name', email = '$email', phone = '$phone', gender = '$gender', date_of_birth = '$dateOfBirth', weight = '$weight', height = '$height' WHERE id = $user_id";
        if (mysqli_query($conn, $updateQuery)) {
            $_SESSION['Done'] = "Profile updated successfully.";
        }

    } else {
        $_SESSION['errors'] = $errors;
    }

    header("location:../profile.php");
}
?>