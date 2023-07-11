<?php
session_start();
if(!isset($_SESSION['admin'])){
  header("location: index.php");
}
include('nav.php');
?>

<div class="container text-center">
  <div class="row align-items-start m-5">
    <div class="col">
    <a type="button" href="p_trainer.php" class="btn btn-success">Pending TRAINERS</a>
    </div>
    <div class="col">
    <a type="button" href="a_trainer.php" class="btn btn-info">Accepted TRAINERS</a>
    </div>
    <div class="col">
    <a type="button" href="r_trainer.php" class="btn btn-danger">Rejected TRAINERS</a>
    </div>