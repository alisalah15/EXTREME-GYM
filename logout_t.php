<?php

session_start();

if(isset($_SESSION['trainer'])){
    unset($_SESSION['trainer']);
    unset($_SESSION['trainer_id']);
    session_destroy();
    session_unset();
    header("location: index.php");
}


?>