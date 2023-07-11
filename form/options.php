<?php
session_start();
if(isset($_SESSION['user'])){
  header("location: ../index.php");
}
if(isset($_SESSION['trainer'])){
  header("location: ../index.php");
}
include('nav.php');
?>
	<div class="background-image"></div>

    <div class="container text-center">
  <div class="row align-items-start m-5">
    <div class="col">
    <a type="button" href="registration_trainer.php" class="btn btn-success">Join as TRAINER</a>
    </div>
    <div class="col">
    <a type="button" href="registration.php" class="btn btn-info">Join as Member</a>
    </div>

  </div>
</div>

</body>
</html>
