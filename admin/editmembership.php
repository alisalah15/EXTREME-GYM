<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("location: index.php");
}
include('nav.php');
include('../db.php');


    $id= $_GET['id'];
    $query = "SELECT * FROM membership WHERE id=$id ";
    $result = mysqli_query($conn, $query);
    $membership = mysqli_fetch_assoc($result);



    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include ('../db.php');
        $errors = array();
        $name = $_POST['name'];
        $amount = $_POST['amount'];
        $features1 = $_POST['features1'];
        $features2 = $_POST['features2'];
        $features3 = $_POST['features3'];
        $features4 = $_POST['features4'];
        $features5 = $_POST['features5'];
        
        if ($amount <= 0) {
            $errors[] = "Amount must be greater than 0";
        }
    
    
        if (empty($errors)) {
    
            $sql = "UPDATE `membership` SET `title`='$name',`amount`='$amount',`features1`='$features1',
            `features2`='$features2',`features3`='$features3',`features4`='$features4',`features5`='$features5'
            WHERE id = $id";
            if (mysqli_query($conn, $sql)) {
            $_SESSION['Done'] = "membership Updated";
            header("Location: editmembership.php?id=$id");
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

            <form class="row g-3 border p-4" method="post" enctype="multipart/form-data">
                <h1>Add New MEMBERSHIP </h1>

                <?php include ('../functions/message.php');  ?>

                <div class="col-md-12">
                    <label for="inputEmail4" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" value=" <?php echo $membership['title'] ?>" id="inputEmail4">
                </div>
                <div class="col-md-12">
                    <label for="inputPassword4" class="form-label">G-Coins</label>
                    <input type="number" class="form-control" name="amount" value="<?php echo $membership['amount'] ?>" id="inputPassword4">
                </div>

                <div class="col-md-12">
                    <label for="inputEmail4" class="form-label">Additional Features 1 (optional)</label>
                    <input type="text" value="<?php echo $membership['features1'] ?>"  class="form-control" name="features1"  id="inputEmail4">
                </div>
                <div class="col-md-12">
                    <label for="inputEmail4" class="form-label">Additional Features 2 (optional)</label>
                    <input type="text" value="<?php echo $membership['features2'] ?>"  class="form-control" name="features2" id="inputEmail4">
                </div>
                <div class="col-md-12">
                    <label for="inputEmail4" class="form-label">Additional Features 3 (optional)</label>
                    <input type="text" value="<?php echo $membership['features3'] ?>"  class="form-control"  name="features3" id="inputEmail4">
                </div>
                <div class="col-md-12">
                    <label for="inputEmail4" class="form-label">Additional Features 4 (optional) </label>
                    <input type="text" value="<?php echo $membership['features4'] ?>"  class="form-control"  name="features4" id="inputEmail4">
                </div>
                <div class="col-md-12">
                    <label for="inputEmail4" class="form-label">Additional Features 5 (optional)</label>
                    <input type="text"  value="<?php echo $membership['features5'] ?>"  class="form-control"  name="features5" id="inputEmail4">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary"> Update</button>
                </div>
            </form>
        </div>
        <a type="submit" href="all_membership.php" class="btn btn-primary">View all MEMBERSHIPS</a>

    </div>
</div>

