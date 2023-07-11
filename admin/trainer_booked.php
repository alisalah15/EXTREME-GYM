<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("location: index.php");
}
include('nav.php');
include('../db.php');

$id=$_GET['id'];

$query = "SELECT trainer_details.*, users.*, trainer.gcoins,users.id as userid
FROM trainer_details
JOIN users ON trainer_details.user_id = users.id
JOIN trainer ON trainer_details.trainer_id = trainer.id
WHERE trainer_details.trainer_id = $id";




// Search functionality
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $query .= " AND (users.name LIKE '%$searchTerm%' OR users.email LIKE '%$searchTerm%' OR users.phone LIKE '%$searchTerm%')";
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
$totalRecordsQuery = "SELECT COUNT(*) as total
FROM trainer_details
JOIN users ON trainer_details.user_id = users.id
JOIN trainer ON trainer_details.trainer_id = trainer.id
WHERE trainer_details.trainer_id = $id";
$totalRecordsResult = mysqli_query($conn, $totalRecordsQuery);
$totalRecords = mysqli_fetch_assoc($totalRecordsResult)['total'];

// Calculate total pages
$totalPages = ceil($totalRecords / $recordsPerPage);
?>

<div class="row">
    <div class="col-10 mx-auto">
        <?php include('../functions/message.php'); ?>
        <h1>Trainer: <?php echo $_GET['name']?></h1>
        <center>
            <a type="button" href="a_trainer.php" class="btn btn-info">View All TRAINERS</a>
        </center>
        <!-- Search Bar -->
            <!-- Search Bar -->
            <form class="mb-4" method="GET">
                <div class="input-group">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="name" value="<?php echo $_GET['name']; ?>">
                    <input type="text" class="form-control" name="search" placeholder="Search by name, email, or phone" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
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
                            <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#Modal<?php echo $value['id']?>">
                                Refund
                            </button>
                            <a href="delete_from_trainer.php?id=<?php echo $id?>&user_id=<?php echo $value['userid']; ?>&name=<?php echo $_GET['name']?> "
                                                class="btn btn-danger "> DELETE </a>
                            </td>
                            </tr>
                            <!-- Modal -->
                                    <!-- Modal -->
                                    <div class="modal fade" id="Modal<?php echo $value['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Refund </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        <h3> Do you sure to refund <?php echo $value['name']?> by <?php echo $value['gcoins']?>?  </h3>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <a href="refund_trainer.php?id=<?php echo $id?>&user_id=<?php echo $value['id']; ?>&name=<?php echo $_GET['name']?>"
                                                class="btn btn-info "> REFUND </a>                                        
                                            </div>
                                        </div>
                            </div>
                            </div>

                      
                <?php endforeach;
                endif ?>
            </tbody>
        </table>

<!-- Pagination -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php if ($totalPages > 1) :
            // Preserve existing $_GET parameters
            $params = $_GET;
            unset($params['page']);
            $queryString = http_build_query($params);

            for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?php echo $i . '&' . $queryString; ?>"><?php echo $i; ?></a>
                </li>
        <?php endfor;
        endif; ?>
    </ul>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
