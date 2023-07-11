<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("location: index.php");
}
include('nav.php');
include('../db.php');



// Pagination variables
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number
$recordsPerPage = 10; // Number of records to display per page
$offset = ($page - 1) * $recordsPerPage; // Offset for SQL query

$query = "SELECT *from users ";

// Search functionality
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $query .= "WHERE (users.name LIKE '%$searchTerm%' OR users.email LIKE '%$searchTerm%' OR users.phone LIKE '%$searchTerm%')";
}

$query .= " ORDER BY created_at DESC LIMIT $offset, $recordsPerPage";
$result = mysqli_query($conn, $query);

// Total records query
$totalRecordsQuery = "SELECT COUNT(*) AS total FROM users";

if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $totalRecordsQuery .= " WHERE (users.name LIKE '%$searchTerm%' OR users.email LIKE '%$searchTerm%' OR users.phone LIKE '%$searchTerm%')";
}

$totalRecordsResult = mysqli_query($conn, $totalRecordsQuery);
$totalRecords = mysqli_fetch_assoc($totalRecordsResult)['total'];

// Calculate total pages
$totalPages = ceil($totalRecords / $recordsPerPage);
?>

<div class="content w-full">
    <div class="container pt-5">


        <div class="row">
            <div class="col-10 mx-auto">
                <?php include('../functions/message.php'); ?>

                <!-- Search Bar -->
                <form class="mb-4" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Search by name, email, or phone" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>

                <table class="table table-bordered border-primary">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Balance</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php
                        $c = ($page - 1) * $recordsPerPage + 1; // Counter for record numbering
                        if (isset($result) && mysqli_num_rows($result) > 0):
                            foreach ($result as $value):
                                ?>
                                <tr>
                                    <th scope="row"><?php echo $c++; ?></th>
                                    <td><?php echo $value['name'] ?></td>
                                    <td><?php echo $value['email'] ?></td>
                                    <td><?php echo $value['phone'] ?></td>
                                    <td><?php echo $value['balance'] ?></td>
                                    <td><?php echo $value['created_at'] ?></td>
                                </tr>
                        <?php
                            endforeach;
                        else:
                            ?>
                            <tr>
                                <td colspan="8">No records found.</td>
                            </tr>
                        <?php
                        endif;
                        ?>
                    </tbody>
                </table>

                <!-- Pagination links -->
                <nav>
                    <ul class="pagination">
                        <?php
                        if ($totalPages > 1):
                            for ($i = 1; $i <= $totalPages; $i++):
                                ?>
                                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?><?php echo isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                        <?php
                            endfor;
                        endif;
                        ?>
                    </ul>
                </nav>

            </div>
        </div>
    </div>
</div>
