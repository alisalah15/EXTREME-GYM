<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("location: index.php");
}
include('nav.php');

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
        include ('../functions/upload.php');
        $target_dir = "../uploads/"; // directory where the uploaded image will be saved
        uploadImage($_FILES['IMG'], $target_dir,$errors=[]);
        $imgName=$_SESSION['IMG'];

        $sql = "INSERT INTO `membership`(`title`, `amount`, `IMG`, `features1`, `features2`, `features3`, `features4`, `features5`) VALUES
        ('$name','$amount','$imgName','$features1','$features2','$features3','$features4','$features5')";
        if (mysqli_query($conn, $sql)) {
        $_SESSION['Done'] = "membership Added";
        header("Location: member.php");
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
                    <input type="text" class="form-control" name="name" id="inputEmail4">
                </div>
                <div class="col-md-12">
                    <label for="inputPassword4" class="form-label">G-Coins</label>
                    <input type="number" class="form-control" name="amount"  id="inputPassword4">
                </div>
                <div class="col-md-12">
                    <label for="inputPassword4" class="form-label">Image</label>
                    <input type="file" class="form-control" name="IMG"  id="inputPassword4">
                </div>

                <div class="col-md-12">
                    <label for="inputEmail4" class="form-label">Additional Features 1 (optional)</label>
                    <input type="text" class="form-control" name="features1"  id="inputEmail4">
                </div>
                <div class="col-md-12">
                    <label for="inputEmail4" class="form-label">Additional Features 2 (optional)</label>
                    <input type="text" class="form-control" name="features2" id="inputEmail4">
                </div>
                <div class="col-md-12">
                    <label for="inputEmail4" class="form-label">Additional Features 3 (optional)</label>
                    <input type="text" class="form-control"  name="features3" id="inputEmail4">
                </div>
                <div class="col-md-12">
                    <label for="inputEmail4" class="form-label">Additional Features 4 (optional) </label>
                    <input type="text" class="form-control"  name="features4" id="inputEmail4">
                </div>
                <div class="col-md-12">
                    <label for="inputEmail4" class="form-label">Additional Features 5 (optional)</label>
                    <input type="text" class="form-control"  name="features5" id="inputEmail4">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary"> Add</button>
                </div>
            </form>
        </div>
        <a type="submit" href="all_membership.php" class="btn btn-primary">View all MEMBERSHIPS</a>

    </div>
</div>



<!-- Footer Start -->
<div class="container-fluid bg-dark text-secondary px-5 mt-5">
    <div class="row gx-5">
        <div class="col-lg-8 col-md-6">
            <div class="row gx-5">
                <div class="col-lg-4 col-md-12 pt-5 mb-5">
                    <h4 class="text-uppercase text-light mb-4">Get In Touch</h4>
                    <div class="d-flex mb-2">
                        <i class="bi bi-geo-alt text-primary me-2"></i>
                        <p class="mb-0">123 Street, New York, USA</p>
                    </div>
                    <div class="d-flex mb-2">
                        <i class="bi bi-envelope-open text-primary me-2"></i>
                        <p class="mb-0">info@example.com</p>
                    </div>
                    <div class="d-flex mb-2">
                        <i class="bi bi-telephone text-primary me-2"></i>
                        <p class="mb-0">+012 345 67890</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 pt-0 pt-lg-5 mb-5">
                    <h4 class="text-uppercase text-light mb-4">Quick Links</h4>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-secondary mb-2" href="#"><i
                                class="bi bi-arrow-right text-primary me-2"></i>Home</a>
                        <a class="text-secondary mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>About
                            Us</a>
                        <a class="text-secondary mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Class
                            Schedule</a>
                        <a class="text-secondary mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Our
                            Trainers</a>
                        <a class="text-secondary mb-2" href="#"><i
                                class="bi bi-arrow-right text-primary me-2"></i>Latest Blog</a>
                        <a class="text-secondary" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Contact
                            Us</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 pt-0 pt-lg-5 mb-5">
                    <h4 class="text-uppercase text-light mb-4">Popular Links</h4>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-secondary mb-2" href="#"><i
                                class="bi bi-arrow-right text-primary me-2"></i>Home</a>
                        <a class="text-secondary mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>About
                            Us</a>
                        <a class="text-secondary mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Class
                            Schedule</a>
                        <a class="text-secondary mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Our
                            Trainers</a>
                        <a class="text-secondary mb-2" href="#"><i
                                class="bi bi-arrow-right text-primary me-2"></i>Latest Blog</a>
                        <a class="text-secondary" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Contact
                            Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid py-4 py-lg-0 px-5" style="background: #111111;">
    <div class="row gx-5">
        <div class="col-lg-8">
            <div class="py-lg-4 text-center">
                <p class="text-secondary mb-0">&copy; <a class="text-light fw-bold" href="#">EXTREME</a>. All Rights
                    Reserved.</p>
            </div>
        </div>
    </div>
</div>
<!-- Foo