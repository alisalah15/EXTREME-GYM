<?php
include('nav.php');
if(!isset($_SESSION['user'])){
    header("location: index.php");
}
$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM coins";
$result = mysqli_query($conn, $query);

$query1 = "SELECT * FROM orders where user_id = $user_id
ORDER BY created_at DESC";
$result1 = mysqli_query($conn,$query1);

?>


<!-- Hero Start -->
<div class="container-fluid bg-primary p-5 bg-hero mb-5">
    <div class="row py-5">
        <div class="col-12 text-center">
            <h1 class="display-2 text-uppercase text-white mb-md-4">BUY G-Coins</h1>
            <a href="tcoin.php" class="btn btn-primary py-md-3 px-md-5 me-3">Transfer G-COINS</a>
            <a href="" class="btn btn-light py-md-3 px-md-5">BUY G-COINS</a>
        </div>
    </div>
</div>
<!-- Hero End -->
<center>
    <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary py-md-3 px-md-5 me-3"> Previous Transactions</button>
</center>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Previous Transactions</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <table class="table table-bordered border-primary">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"> Coins </th>
                        <th scope="col">Price</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                <?php $c=1; while ($order = mysqli_fetch_assoc($result1)) { ?>
                <tr>
            <td><?php echo $c++; ?></td>
                <td><?php echo $order['coin']; ?></td>
                <td><?php echo $order['price']; ?></td>
                <td><?php echo $order['created_at']; ?></td>
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
        </div>
        <?php include ('functions/message.php');  ?>
        <div class="row g-5">
        <?php while ($coins = mysqli_fetch_assoc($result)) { ?>
        <div class="col-lg-4 col-md-6">
            <!-- loop here -->
            <div class="team-item position-relative">
                <div class="position-relative overflow-hidden rounded">
                    <img class="img-fluid w-100" src="img/1p.JPG" alt="">
                    <div class="team-overlay">
                        <div class="d-flex align-items-center justify-content-start">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#Modal<?php echo $coins['id']?>">
                                Buy
                            </button>
                        </div>
                    </div>
                </div>
                <div class="position-absolute start-0 bottom-0 w-100 rounded-bottom text-center p-4"
                    style="background: rgba(34, 36, 41, .9);">
                    <h5 class="text-uppercase text-light">g-coins: <?php echo $coins['coin'] ?></h5>
                    <p class="text-uppercase text-secondary m-0">Price: <?php echo $coins['price'] ?> EGP</p>
                </div>
            </div>
        </div>

        <!-- Modal for buy -->
        <div class="modal fade" id="Modal<?php echo $coins['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Buy Now</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h1> G-Coins: <?php echo $coins['coin']?> </h1>
                        <h1> Price: <?php echo $coins['price']?> EGP</h1>

                        <form class="row" method="post" action="php/buy.php" >
                        <input type="text" hidden name="coinId" value="<?php echo $coins['id']?>">
                        <input type="text" hidden name="coin" value="<?php echo $coins['coin']?>">
                        <input type="text" hidden name="price" value="<?php echo $coins['price']?>">
                            <div class="col-md-12">
                                <label for="inputEmail4" class="form-label">Name on Card</label>
                                <input type="text" class="form-control" name="cardname" id="inputEmail4"
                                    placeholder="John More Doe">
                            </div>
                            <div class="col-md-12">
                                <label for="inputPassword4" class="form-label">Credit card number</label>
                                <input type="text" name="cardnumber" placeholder="1111-2222-3333-4444"
                                    class="form-control" id="inputPassword4">
                            </div>
                            <div class="col-md-12">
                                <label for="inputPassword4" class="form-label">Exp Year</label>
                                <input type="text" name="expyear" placeholder="2018" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label for="inputPassword4" class="form-label">CVV</label>
                                <input type="text" name="cvv" placeholder="352" class="form-control">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Buy Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End loop -->
        <?php } ?>
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

        </form>
    </div>
</div>
</div>
</div>
<div class="container-fluid py-4 py-lg-0 px-5" style="background: #111111;">
    <div class="row gx-5">
        <div class="col-lg-8">
            <div class="py-lg-4 text-center">
                <p class="text-secondary mb-0">&copy; <a class="text-light fw-bold" href="#">Extreme</a>. All Rights
                    Reserved.</p>
            </div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
</script>

<script src="js/main.js"></script>
</body>

</html>