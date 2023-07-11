<?php
include('nav.php');
if(!isset($_SESSION['user'])){
    header("location: index.php");
}
$user_email=$user['email'];

$sent = "SELECT * FROM transfer where from_email = '$user_email'";
$sentResult = mysqli_query($conn,$sent);

$received = "SELECT * FROM transfer where to_email = '$user_email'";
$receivedResult = mysqli_query($conn,$received);

?>
    <!-- Hero Start -->
    <div class="container-fluid bg-primary p-5 bg-hero mb-5">
        <div class="row py-5">
            <div class="col-12 text-center">
                <h1 class="display-2 text-uppercase text-white mb-md-4">Transfer G-COINS</h1>
                <a href="bcoin.php" class="btn btn-primary py-md-3 px-md-5 me-3">BUY G-COINS</a>
                <a href="" class="btn btn-light py-md-3 px-md-5">Transfer G-COINS</a>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Hero End -->
<center>
    <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary py-md-3 px-md-5 me-3"> Transfers sent</button>
    <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal1" class="btn btn-primary py-md-3 px-md-5 me-3"> Transfers received </button>

</center>
<!-- Modal for Transfers sent -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Previous Transfers</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <table class="table table-bordered border-primary">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"> Coins </th>
                        <th scope="col">Recipient</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                <?php $c=1; while ($transfer = mysqli_fetch_assoc($sentResult)) { ?>
                <tr>
            <td><?php echo $c++; ?></td>
                <td><?php echo $transfer['coin']; ?></td>
                <td><?php echo $transfer['to_email']; ?></td>
                <td><?php echo $transfer['created_at']; ?></td>
            </tr>
                 <?php }   ?>
                </tbody>
                </table>
            
            </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Transfers received  -->
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Previous Transfers</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <table class="table table-bordered border-primary">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"> Coins </th>
                        <th scope="col">From</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                <?php $c=1; while ($transfer1 = mysqli_fetch_assoc($receivedResult)) { ?>
                <tr>
            <td><?php echo $c++; ?></td>
                <td><?php echo $transfer1['coin']; ?></td>
                <td><?php echo $transfer1['from_email']; ?></td>
                <td><?php echo $transfer1['created_at']; ?></td>
            </tr>
                 <?php }   ?>
                </tbody>
                </table>
            
            </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>




    <!-- Team Start -->
    <div class="container-fluid p-5">
        <div class="mb-5 text-center">
            <h5 class="text-primary text-uppercase">G-COINS</h5>
            <h1 class="display-3 text-uppercase mb-0">Enter E-mail & G-Coin</h1>
        </div>
        <div class="container pt-5">
    <div class="row">
        <div class="col-8 mx-auto">
        <?php include ('functions/message.php');  ?>
            <form class="row g-3 border p-4" method="post" action="php/transfer.php">
            <input type="text" hidden class="form-control" name="balance" value="<?php echo $user['balance'] ?>" id="inputPassword4">
            <input type="text" hidden class="form-control" name="emailFrom" value="<?php echo $user['email'] ?>" id="inputPassword4">
                <div class="col-md-12">
                    <label for="inputPassword4" class="form-label">Email</label>
                    <input type="text" class="form-control" name="emailTo" id="inputPassword4">
                </div>
                <div class="col-md-12">
                    <label for="inputPassword4" class="form-label">Coin</label>
                    <input type="number" class="form-control"  name="coin" id="inputPassword4" min="0">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Transfer</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <!-- Team End -->
    

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
                            <a class="text-secondary mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Home</a>
                            <a class="text-secondary mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>About Us</a>
                            <a class="text-secondary mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Class Schedule</a>
                            <a class="text-secondary mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Our Trainers</a>
                            <a class="text-secondary mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Latest Blog</a>
                            <a class="text-secondary" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Contact Us</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 pt-0 pt-lg-5 mb-5">
                        <h4 class="text-uppercase text-light mb-4">Popular Links</h4>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-secondary mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Home</a>
                            <a class="text-secondary mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>About Us</a>
                            <a class="text-secondary mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Class Schedule</a>
                            <a class="text-secondary mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Our Trainers</a>
                            <a class="text-secondary mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Latest Blog</a>
                            <a class="text-secondary" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="container-fluid py-4 py-lg-0 px-5" style="background: #111111;">
        <div class="row gx-5">
            <div class="col-lg-8">
                <div class="py-lg-4 text-center">
                    <p class="text-secondary mb-0">&copy; <a class="text-light fw-bold" href="#">EXTREME</a>. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-dark py-3 fs-4 back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>