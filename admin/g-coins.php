<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("location: index.php");
}

include('nav.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include ('../db.php');
    $errors = array();
    $amount = $_POST['amount'];
    $price = $_POST['price'];

    if ($amount <= 0) {
        $errors[] = "Amount must be greater than 0";
    }

    if ($price <= 0) {
        $errors[] = "Price must be greater than 0";
    }

    if (empty($errors)) {

        $sql = "INSERT INTO coins (coin, price) 
        VALUES ('$amount', '$price')";
        if (mysqli_query($conn, $sql)) {
        $_SESSION['Done'] = "Coin Added";
        header("Location: g-coins.php");
        exit();
        }

    }else{
        $_SESSION['errors'] = $errors;
    }


}
?>
<div class="container pt-5">
    <div class="row">
        <div class="col-8 mx-auto">

            <form class="row g-3 border p-4" method="post">
                <h1>Add New G-Coin </h1>

                <?php include ('../functions/message.php');  ?>

                <div class="col-md-12">
                    <label for="inputEmail4" class="form-label">Coin Amount</label>
                    <input type="number" class="form-control" name="amount" id="inputEmail4">
                </div>
                <div class="col-md-12">
                    <label for="inputPassword4" class="form-label">Price</label>
                    <input type="number" class="form-control"  name="price" id="inputPassword4">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
            
        </div>
        <a type="submit" href="view_pack.php" class="btn btn-primary">View all Packages</a>
    </div>
</div>