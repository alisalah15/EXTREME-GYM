<?php
include('nav.php');

$query = "SELECT * FROM membership";
$result = mysqli_query($conn, $query);

?>



    <!-- Hero Start -->
    <div class="container-fluid bg-primary p-5 bg-hero mb-5">
        <div class="row py-5">
            <div class="col-12 text-center">
                <h1 class="display-2 text-uppercase text-white mb-md-4">Memberships</h1>
                <a href="index.php" class="btn btn-primary py-md-3 px-md-5 me-3">Home</a>
                <a href="" class="btn btn-light py-md-3 px-md-5">Memberships</a>
            </div>
        </div>
    </div>
    <!-- Hero End -->


    <!-- Team Start -->
    <div class="container-fluid p-5">
    <center>
       <?php if(isset($_SESSION['user'])){ ?>
        <a href="my_membership.php" class="btn btn-primary py-md-3 px-md-5 me-3">MY Memberships</a>
        <?php
       } 
       ?>
    </center>
        <div class="mb-5 text-center">
            <h5 class="text-primary text-uppercase">Join</h5>
            <h1 class="display-3 text-uppercase mb-0">Become a Beast</h1>
        </div>
        <div class="row g-5">
        <?php while ($membership = mysqli_fetch_assoc($result)) { ?>
            <div class="col-lg-4 col-md-6">
                <div class="team-item position-relative">
                    <div class="position-relative overflow-hidden rounded">
                        <img class="img-fluid w-100" src="uploads/<?php echo $membership['IMG'] ?>" alt="">
                        <div class="team-overlay">
                            <div class="d-flex align-items-center justify-content-start">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal<?php echo $membership['id'];?>">
                                GET </button>                            
                            </div>
                        </div>
                    </div>
                    <div class="position-absolute start-0 bottom-0 w-100 rounded-bottom text-center p-4" style="background: rgba(34, 36, 41, .9);">
                        <h5 class="text-uppercase text-light">g-coins: <?php echo $membership['amount']  ?></h5>
                        <p class="text-uppercase text-secondary m-0"><?php echo $membership['title']  ?></p>
                        <p class="text-uppercase text-secondary m-0"><?php echo $membership['features1']  ?></p>
                        <p class="text-uppercase text-secondary m-0"><?php echo $membership['features2']  ?></p>
                        <p class="text-uppercase text-secondary m-0"><?php echo $membership['features3']  ?></p>
                        <p class="text-uppercase text-secondary m-0"><?php echo $membership['features4']  ?></p>
                        <p class="text-uppercase text-secondary m-0"><?php echo $membership['features5']  ?></p>
                    </div>
                        <!-- Book Model -->
                        <div class="modal fade" id="exampleModal<?php echo $membership['id'];?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Book NOW</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <?php if(isset($_SESSION['user'])){ ?>
                                    <h3> Available balance: <?php echo $user['balance'] ?></h3>
                                    <h3>Mmembership G-Coins: <?php echo $membership['amount'] ?></h3>
                                    <?php  $balance=0; $balance =  $user['balance']-$membership['amount']  ?>
                                    <h3> Balance After Book: <?php echo  $balance ?></h3>
                                    <?php if ($balance < 0) : ?>
                                    <p class="text-danger">Insufficient balance. Please add funds to your account.</p>
                                    <?php endif; ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                        <?php if ($balance >= 0) : 
                                        $userid = $_SESSION['user_id'];  
                                        $membershipid = $membership['id'];      
                                        $query1 = "SELECT * FROM membership_details WHERE user_id = $userid AND membership_id = $membershipid";
                                        $result1 = mysqli_query($conn, $query1);
                                        ?>
                                        <form action="php/addmembership.php" method="post">
                                        <input type="hidden" name="nameMembership" value="<?php echo $membership['title'];?>">
                                        <input type="hidden" name="mem_id" value="<?php echo $membership['id'];?>">
                                        <input type="hidden" name="balance" value="<?php echo $balance?>">
                                        <?php if (mysqli_num_rows($result1) == 0) : ?>
                                                <button type="submit" class="btn btn-primary">Confirm</button>
                                            <?php else: ?>   
                                                <p class="text-danger">You cannot book this membership. You already booked.</p>
                                            <?php endif; ?>
                                            </form>
                                        <?php endif; }else{ ?>
                                            <p class="text-danger">Please login First.</p>
                                            <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                            <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }; ?>

          
                </div>
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