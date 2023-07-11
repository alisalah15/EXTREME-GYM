<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("location: index.php");
}
include('nav.php');
include('../db.php');

// Pagination
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 10;
$offset = ($page - 1) * $records_per_page;

// Search
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Filter by day
$filter_day = isset($_GET['filter_day']) ? $_GET['filter_day'] : '';

// Query with pagination, search, and filter
$query = "SELECT * FROM class where 1";

// Add search condition
if (!empty($search)) {
    $query .= " AND cName LIKE '%$search%' OR tName LIKE '%$search%'";
}

// Add filter condition
if (!empty($filter_day)) {
    $query .= " AND `day` = '$filter_day'";
}

// Get total number of records
$total_records_query = "SELECT COUNT(*) AS count FROM class";
$total_records_result = mysqli_query($conn, $total_records_query);
$total_records = mysqli_fetch_assoc($total_records_result)['count'];

// Calculate total number of pages
$total_pages = ceil($total_records / $records_per_page);

// Add pagination limit and offset
$query .= " LIMIT $offset, $records_per_page";

$result = mysqli_query($conn, $query);
?>

<div class="content w-full">
    <div class="container pt-5">
        <center>
            <a type="submit" href="all_class.php" class="btn btn-primary m-2">View all Clases</a>
        </center>

        <div class="row">
            <div class="col-10 mx-auto">
            <?php include ('../functions/message.php');  ?>

                <form action="" method="GET" class="mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search"  placeholder="Serach by Class name or Trainer name"
                                    value="<?php echo $search; ?>">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" name="filter_day">
                                <option value="">Filter by Day</option>
                                <option value="Monday" <?php echo $filter_day === 'Monday' ? 'selected' : ''; ?>>
                                    Monday
                                </option>
                                <option value="Tuesday" <?php echo $filter_day === 'Tuesday' ? 'selected' : ''; ?>>
                                    Tuesday
                                </option>
                                <option value="Wednesday" <?php echo $filter_day === 'Wednesday' ? 'selected' : ''; ?>>
                                    Wednesday
                                </option>
                                <option value="Thursday" <?php echo $filter_day === 'Thursday' ? 'selected' : ''; ?>>
                                    Thursday
                                </option>
                                <option value="Friday" <?php echo $filter_day === 'Friday' ? 'selected' : ''; ?>>
                                    Friday
                                </option>
                                <option value="Saturday" <?php echo $filter_day === 'Saturday' ? 'selected' : ''; ?>>
                                    Saturday
                                </option>
                                <option value="Sunday" <?php echo $filter_day === 'Sunday' ? 'selected' : ''; ?>>
                                    Sunday
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Apply Filter</button>
                        </div>
                    </div>
                </form>
                <table class="table table-bordered border-primary">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Class Name</th>
                            <th scope="col">Trainer Name</th>
                            <th scope="col">From</th>
                            <th scope="col">To</th>
                            <th scope="col">G-COINS</th>
                            <th scope="col">Day</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php
                        $c = ($page - 1) * $records_per_page + 1;
                        if (isset($result) && mysqli_num_rows($result) > 0):
                            foreach ($result as $value):
                        ?>
                        <tr>
                            <th scope="row"><?php echo $c++; ?></th>
                            <td><?php echo $value['cName'] ?></td>
                            <td><?php echo $value['tName'] ?></td>
                            <td><?php echo $value['from_hour'] . $value['from_period'] ?></td>
                            <td><?php echo $value['to_hour'] . $value['to_period'] ?></td>
                            <td><?php echo $value['amount'] ?></td>
                            <td><?php echo $value['day'] ?></td>
                            <td>
                            <a href="view_class.php?id=<?php echo $value['id']; ?>&classname=<?php echo $value['cName'];?>" class="btn btn-secondary">SHOW BOOKED</a>
                                <a href="editclass.php?id=<?php echo $value['id']; ?>" class="btn btn-success">EDIT</a>
                                <a href="deleteclass.php?id=<?php echo $value['id']; ?>" class="btn btn-danger">DELETE</a>
                            </td>
                        </tr>
                        <?php endforeach;
                        else: ?>
                        <tr>
                            <td colspan="8">No records found.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <!-- Pagenation -->
                <?php if ($total_pages > 1): ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <!-- Previous -->
                        <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo $search; ?>&filter_day=<?php echo $filter_day; ?>"
                                aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>"><a class="page-link"
                                href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>&filter_day=<?php echo $filter_day; ?>"><?php echo $i; ?></a>
                        </li>
                        <?php endfor; ?>
                        <!-- Next -->
                        <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo $search; ?>&filter_day=<?php echo $filter_day; ?>"
                                aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
