<?php
session_start();
if(isset($_SESSION['user'])){
  header("location: ../index.php");
}
if(isset($_SESSION['trainer'])){
  header("location: ../index.php");
}
include('nav.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	include ('../db.php');
	$em_ph = $_POST['em_ph'];
  $password = $_POST['password'];

  $query = "SELECT * FROM users WHERE email = '$em_ph' OR phone = '$em_ph' LIMIT 1";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);
    if (password_verify($password, $user['password'])) {
      // Password is correct, log in the user
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user'] = true;
      header("Location: ../index.php");
      exit();
    } else {
      // Password is incorrect
      $error = ["Invalid Email,Phone  or password"];
	  $_SESSION['errors'] = $error;

    }
  } else {
    // User does not exist
    $error = ["Invalid Email,Phone or password"];
	$_SESSION['errors'] = $error;
  }

  $query1 = "SELECT * FROM trainer WHERE email = '$em_ph' OR phone = '$em_ph' LIMIT 1";
  $result1 = mysqli_query($conn, $query1);

  if (mysqli_num_rows($result1) == 1) {
    $trainerResult = mysqli_fetch_assoc($result1);
    $trainerStatus = $trainerResult['status'];
    if (password_verify($password, $trainerResult['password'])) {
      if ($trainerStatus == 0) {
        $message = "Your trainer account is waiting for approval.";
        $_SESSION['errors'] = [$message];
    } elseif ($trainerStatus == 2) {
        $message = "Your trainer account has been rejected.";
        $_SESSION['errors'] = [$message];
    } elseif ($trainerStatus == 3) {
        $message = "Your trainer account has been blocked.";
        $_SESSION['errors'] = [$message];
    } elseif ($trainerStatus == 1) {
        // Login the trainer
        $_SESSION['trainer_id'] = $trainerResult['id'];
        $_SESSION['trainer'] = true;
        header("Location: ../index.php");
    }
    } else {
      // Password is incorrect
      $error = ["Invalid Email,Phone  or password"];
	  $_SESSION['errors'] = $error;
    }
  } else {
    // User does not exist
    $error = ["Invalid Email,Phone or password"];
	$_SESSION['errors'] = $error;
  }

}
?>
	<div class="background-image"></div>
	<div class="login-box">
		<h1>Login </h1>
		<form method="post">
		<?php include ('../functions/message.php');  ?>

			<label for="username">Email or Phone:</label>
			<input type="text" id="username" name="em_ph">
			<label for="password">Password:</label>
			<input type="password" id="password" name="password">
			<input type="submit" value="Login"> 
			<a href="registration.php">Sign Up</a>		
			</form>
	</div>
</body>
</html>