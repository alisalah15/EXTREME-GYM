<?php
include ('../db.php');
if(!isset($_SESSION['admin'])){
    header("location: index.php");
}

if(isset($_GET['id'])){

    $id= $_GET['id'];
    $sql="DELETE from `coins` where `id`='$id'";

    if(mysqli_query($conn,$sql)){
        $_SESSION['Done']= "Package Deleted";

    }
    else{
        $_SESSION['errors'] = "Package Cannot Deleted";
    
    }
}

        header("location: view_pack.php");


?>