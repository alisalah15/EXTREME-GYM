<?php
include('nav.php');

// Pagination
$recordsPerPage = 9;
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($currentPage - 1) * $recordsPerPage;

// Query to fetch trainers with pagination
$query = "SELECT * FROM trainer WHERE `status` = 1 LIMIT $offset, $recordsPerPage";
$result = mysqli_query($conn, $query);

// Query to count total trainers
$totalRecordsQuery = "SELECT COUNT(*) as total FROM trainer WHERE `status` = 1";
$totalRecordsResult = mysqli_query($conn, $totalRecordsQuery);
$totalRecords = mysqli_fetch_assoc($totalRecordsResult)['total'];
$totalPages = ceil($totalRecords / $recordsPerPage);

// Search functionality
if (isset($_GET['search'])) {
    $searchKeyword = $_GET['search'];
    $query = "SELECT * FROM trainer WHERE `status` = 1 AND name LIKE '%$searchKeyword%' LIMIT $offset, $recordsPerPage";
    $result = mysqli_query($conn, $query);
    $totalRecords = mysqli_num_rows($result);
    $totalPages = ceil($totalRecords / $recordsPerPage);
}
?>


    <!-- Hero Start -->
    <div class="container-fluid bg-primary p-5 bg-hero mb-5">
        <div class="row py-5">
            <div class="col-12 text-center">
                <h1 class="display-2 text-uppercase text-white mb-md-4">Trainers</h1>
                <a href="index.php" class="btn btn-primary py-md-3 px-md-5 me-3">Home</a>
                <a href="team.php" class="btn btn-light py-md-3 px-md-5">All Trainers</a>
            </div>
        </div>
    </div>
    <!-- Hero End -->

<!-- Search Form -->
<div class="container mt-4">
    <div class="row justify-content-center">
        <form class="form-inline" method="GET" action="">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search Trainers" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
    </div>
</div>

    <!-- Team Start -->
    <div class="container-fluid p-5">
    <center>
       <?php if(isset($_SESSION['user'])){ ?>
        <a href="my_trainer.php" class="btn btn-primary py-md-3 px-md-5 me-3">MY Trainers</a>
        <?php
       } 
       ?>
    </center>
        <div class="mb-5 text-center">
            <h5 class="text-primary text-uppercase">The Team</h5>
            <h1 class="display-3 text-uppercase mb-0">Expert Trainers</h1>
        </div>
        
        <div class="row g-5">
        <?php while ($trainer = mysqli_fetch_assoc($result)) { ?>
            <div class="col-lg-4 col-md-6">
                <div class="team-item position-relative">
                    <div class="position-relative overflow-hidden rounded">
                        <img class="img-fluid w-100" src="uploads/<?php echo $trainer['IMG']?>" alt="">
                        <div class="team-overlay">
                            <div class="d-flex align-items-center justify-content-start">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal<?php echo $trainer['id'];?>">
                                TRAIN </button> 
                            </div>
                        </div>
                    </div>
                    <div class="position-absolute start-0 bottom-0 w-100 rounded-bottom text-center p-4" style="background: rgba(34, 36, 41, .9);">
                        <h5 class="text-uppercase text-light"><?php echo $trainer['name']?></h5>
                        <h4 class="text-uppercase text-light"> g-coins: <?php echo $trainer['gcoins']?></h4>
                        <p class="text-uppercase text-secondary m-0"><?php echo $trainer['description']?></p>
                    </div>
                      <!-- Book Model -->
                      <div class="modal fade" id="exampleModal<?php echo $trainer['id'];?>" tabindex="-1"
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
                                    <h3>Trainer G-Coins: <?php echo $trainer['gcoins'] ?></h3>
                                    <?php  $balance=0; $balance =  $user['balance']-$trainer['gcoins']  ?>
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
                                        $trainer_id = $trainer['id'];      
                                        $query1 = "SELECT * FROM trainer_details WHERE user_id = $userid AND trainer_id = $trainer_id";
                                        $result1 = mysqli_query($conn, $query1);
                                        ?>
                                        <form action="php/addtrainer.php" method="post">
                                        <input type="hidden" name="amount" value="<?php echo $trainer['gcoins'];?>">
                                        <input type="hidden" name="nameTrainer" value="<?php echo $trainer['name'];?>">
                                        <input type="hidden" name="trainer_id" value="<?php echo $trainer['id'];?>">
                                        <input type="hidden" name="balance" value="<?php echo $balance?>">
                                        <?php if (mysqli_num_rows($result1) == 0) : ?>
                                                <button type="submit" class="btn btn-primary">Confirm</button>
                                            <?php else: ?>   
                                                <p class="text-danger">You cannot book this trainer. You already booked.</p>
                                            
                                            <?php endif; ?>
                                            </form>
                                        <?php endif; 
                                            }else{ ?>
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
            <?php } ?>
        </div>
    </div>
    <!-- Pagination -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <nav aria-label="Trainers Pagination">
            <ul class="pagination">
                <?php if ($currentPage > 1) : ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $currentPage - 1; ?><?php echo isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="visually-hidden">Previous</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                    <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?><?php echo isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages) : ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $currentPage + 1; ?><?php echo isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="visually-hidden">Next</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>