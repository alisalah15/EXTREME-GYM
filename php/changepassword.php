<?php
session_start();

include('../db.php'); 

// Include the necessary database connection or authentication code

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];


    // Check if the new password and confirm password match
    if ($newPassword !== $confirmPassword) {
        $_SESSION['errors'] = ["New password and confirm password do not match"];
        header("Location: ../profile.php");
        exit();
    }

    if (strlen($newPassword) < 6) {
        $_SESSION['errors'] = ["New password should be at least 6 characters long"];
        header("Location: ../profile.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $query = "SELECT password FROM users WHERE id = $user_id";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if (password_verify($currentPassword, $user['password'])) {
        // Current password is correct, proceed with password change
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateQuery = "UPDATE users SET password = '$hashedPassword' WHERE id = $user_id";
        if (mysqli_query($conn, $updateQuery)) {
            $_SESSION['Done'] = "Password changed successfully";
            header("Location: ../profile.php");
            exit();
        } else {
            $_SESSION['errors'] = ["Error updating password"];
            header("Location: ../profile.php");
            exit();
        }
    } else {
        $_SESSION['errors'] = ["Invalid current password"];
        header("Location: ../profile.php");
        exit();
    }

}

header("Location: ../profile.php");
exit();
