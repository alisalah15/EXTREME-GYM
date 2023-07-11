<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("location: index.php");
}
include('nav.php');
include('../db.php');

$query = "SELECT * FROM trainer WHERE `status` != 0 AND `status` != 2";

// Search functionality
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $query .= " AND (name LIKE '%$searchTerm%' OR email LIKE '%$searchTerm%' OR phone LIKE '%$searchTerm%')";
}

$result = mysqli_query($conn, $query);

// Pagination variables
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number
$recordsPerPage = 10; // Number of records to display per page
$offset = ($page - 1) * $recordsPerPage; // Offset for SQL query

// Query to retrieve a limited number of records based on the current page
$queryWithPagination = $query . " LIMIT $offset, $recordsPerPage";
$resultWithPagination = mysqli_query($conn, $queryWithPagination);

// Query to count the total number of records
$totalRecordsQuery = "SELECT COUNT(*) as total FROM trainer WHERE `status` != 0 AND `status` != 2";
$totalRecordsResult = mysqli_query($conn, $totalRecordsQuery);
$totalRecords = mysqli_fetch_assoc($totalRecordsResult)['total'];

// Calculate total pages
$totalPages = ceil($totalRecords / $recordsPerPage);
?>

<div class="row">
    <div class="col-10 mx-auto">
        <?php include('../functions/message.php'); ?>
        <h1>Accepted Trainers</h1>
        <center>
            <a type="button" href="a_trainer.php" class="btn btn-info">View All TRAINERS</a>
        </center>

        <!-- Search Bar -->
        <form class="mb-4" method="GET">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search by name, email, or phone"
                    value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>

        <table class="table table-bordered border-primary">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Description</th>
                    <th scope="col">Experience</th>
                    <th scope="col">G-Coins</th>
                    <th scope="col">Amount to paid</th>
                    <th scope="col">IMG</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php
                $c = ($page - 1) * $recordsPerPage + 1; // Counter for record numbering
                if (isset($resultWithPagination)) :
                    foreach ($resultWithPagination as $value) : ?>
                <tr>
                    <th scope="row"><?php echo $c++; ?></th>
                    <td><?php echo $value['name'] ?></td>
                    <td><?php echo $value['email'] ?></td>
                    <td><?php echo $value['phone'] ?></td>
                    <td><?php echo $value['gender'] ?></td>
                    <td><?php echo $value['description'] ?></td>
                    <td><?php echo $value['exp'] ?></td>
                    <td><?php echo $value['gcoins'] ?></td>
                    <td><?php echo $value['balance'] ?></td>
                    <td><img src="../uploads/<?php echo $value['IMG'] ?>" width="100" alt=""></td>
                    <td>
                        <?php
                                $status = $value['status'];
                                if ($status == 1) { ?>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#Modal<?php echo $value['id'] ?>">
                            Edit G-Coins
                        </button>
                        <button type="button" class="btn btn-info" data-bs-toggle="modal"
                            data-bs-target="#Modal1<?php echo $value['id'] ?>">
                            Pay
                        </button>
                        <a type="button" href="history.php?id=<?php echo $value['id'] ?>&name=<?php echo $value['name'] ?>" class="btn btn-info" >
                            Pay History
                                </a>
                        <a href="trainer_booked.php?id=<?php echo $value['id'] ?>&name=<?php echo $value['name'] ?>"
                            class="btn btn-danger">Show Booked</a>
                        <a href="block.php?id=<?php echo $value['id'] ?>" class="btn btn-danger">Block</a>
                        <?php }
                                if ($status == 3) { ?>
                        <a href="unblock.php?id=<?php echo $value['id'] ?>" class="btn btn-secondary">Unblock</a>
                        <?php } ?>
                    </td>
                    <!--  Edit Modal -->
                    <div class="modal fade" id="Modal<?php echo $value['id'] ?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="edit_trainer.php" method="post">
                                        <input type="hidden" name="trainerId" value="<?php echo $value['id'] ?>">
                                        <label for="">Edit G-Coins for <?php echo $value['name'] ?></label>
                                        <input type="number" name="price" value="<?php echo $value['gcoins'] ?>"
                                            required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="sub" class="btn btn-primary">Accept</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                                   
                    <!-- pay Modal -->
                    <div class="modal fade" id="Modal1<?php echo $value['id'] ?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Pay</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="pay.php" method="post">
                                        <input type="hidden" name="trainerId" value="<?php echo $value['id'] ?>">
                                        <input type="hidden" name="name" value="<?php echo $value['name'] ?>">
                                        <input type="hidden" name="balance" value="<?php echo $value['balance'] ?>">
                                        <h3> Name: <?php echo $value['name'] ?> </h3>
                                        <label for="">The amount will be paid <?php echo $value['balance'] ?>
                                            EGP</label>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="sub" class="btn btn-primary">Pay</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                </tr>
                <?php endforeach;
                endif ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php if ($totalPages > 1) :
                    for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
                <?php endfor;
                endif; ?>
            </ul>
        </nav>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
</script>