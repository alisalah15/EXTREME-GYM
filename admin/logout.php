<?php

session_start();

if(isset($_SESSION['admin'])){
    unset($_SESSION['admin_id']);
    unset($_SESSION['admin_name']);
    unset($_SESSION['admin']);

    session_destroy();
    session_unset();
    header("location: index.php");
}

?>