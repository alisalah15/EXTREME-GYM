<?php
session_start();
if(isset($_SESSION['admin'])){
    header("location: g-coins.php");
}
include ('../db.php');


if(isset($_POST['sub'])) {
    $username_email = $_POST['username_email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admin WHERE (username = '$username_email' OR email = '$username_email') AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1) { // If username/email and password exist in database
        $row = mysqli_fetch_assoc($result);

        $_SESSION['admin'] = true ;
        $_SESSION['admin_id'] = $row['id'];
        $_SESSION['admin_name'] = $row['name'];
        header("Location:g-coins.php"); // 
    } else { // If username/email and password do not exist in database
        $_SESSION['errors'] = ["Invalid username/email or password"];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>


			<link href="../img/favicon.ico" rel="icon">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

			<!-- Google Web Fonts -->
			<link rel="preconnect" href="https://fonts.gstatic.com">
			<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Rubik&display=swap" rel="stylesheet"> 
			
			<!-- Icon Font Stylesheet -->
			<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
			<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
			<link href="../lib/flaticon/font/flaticon.css" rel="stylesheet">
			
			<!-- Libraries Stylesheet -->
			<link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
			
			<!-- Customized Bootstrap Stylesheet -->
			<link href="../css/bootstrap.min.css" rel="stylesheet">
			
			<!-- Template Stylesheet -->
			<link href="../css/style.css" rel="stylesheet">
</head>
<body>
<div class="container pt-5">
    <div class="row">
        <div class="col-8 mx-auto">
            
            <form class="row g-3 border p-4" method="post" action="" >
                <h1>Login </h1>
                <?php include ('../functions/message.php');  ?>


                <div class="col-md-12">
                    <label for="inputEmail4" class="form-label">Email or Username</label>
                    <input type="email" name="username_email" class="form-control" id="inputEmail4">
                </div>
                <div class="col-md-12">
                    <label for="inputPassword4" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="inputPassword4">
                </div>
                <div class="col-12">
                    <button type="submit" name="sub" class="btn btn-primary">Log in</button>
                </div>
            </form>
        </div>
    </div>
</div>

