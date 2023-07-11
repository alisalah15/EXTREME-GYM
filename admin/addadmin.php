<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("location: index.php");
}
include('nav.php');
include('../db.php');
$errors=[];

    if (isset($_POST['submit'])) {

        $name=mysqli_real_escape_string($conn,$_POST['name']);
        $username=mysqli_real_escape_string($conn,$_POST['username']);
        $email=mysqli_real_escape_string($conn,$_POST['email']);
        $password=mysqli_real_escape_string($conn,$_POST['password']);

        // check if admin with the same username or email already exists
        $query = "SELECT * FROM admin WHERE username = '$username' OR email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            // admin with the same username or email already exists
            $errors[] = "Admin with the same username or email already exists.";
            header("Location: addadmin.php");
        } else {
            // insert new admin into database
            $query = "INSERT INTO admin (name, username, email, password) VALUES ('$name', '$username', '$email', '$password')";
            mysqli_query($conn, $query);
            $_SESSION['Done']= "Admin added successfully!";
        }
    }
?>


<div class="content w-full">
            <div class="container pt-5">
                <div class="row">
                    <div class="col-10 mx-auto">


                    <?php include('../functions/message.php'); ?>

                <form class="row g-3 border p-4"  method="POST">
                    <div class="col-12">
                        <label for="inputEmail4" class="form-label">name</label>
                        <input type="text" name="name" class="form-control" id="inputEmail4">
                    </div>
                    <div class="col-12">
                        <label for="inputEmail4" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" id="inputEmail4">
                    </div>
                    <div class="col-12">
                        <label for="inputEmail4" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="inputEmail4">
                    </div>
                    <div class="col-12">
                        <label for="inputPassword4" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="inputPassword4">
                    </div>

                    <div class="col-12">
                        <button type="submit" name="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>


    </div>