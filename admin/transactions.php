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

$query = "SELECT u.name AS username, u.email AS useremail, u.phone AS userphone, c.*, m.*, t.*, md.*, td.*, cd.*, c.amount AS classamount
          FROM users u
          LEFT JOIN class_details cd ON u.id = cd.user_id
          LEFT JOIN class c ON cd.class_id = c.id
          LEFT JOIN membership_details md ON u.id = md.user_id
          LEFT JOIN membership m ON md.membership_id = m.id
          LEFT JOIN trainer_details td ON u.id = td.user_id
          LEFT JOIN trainer t ON td.trainer_id = t.id
          ORDER BY 
              GREATEST(
                  COALESCE(td.created_at, '0000-00-00'),
                  COALESCE(c.created_at, '0000-00-00'),
                  COALESCE(m.created_at, '0000-00-00')
              ) DESC
          LIMIT $offset, $recordsPerPage";


$result = mysqli_query($conn, $query);

// Total records query
$totalRecordsQuery = "SELECT COUNT(*) as total FROM users u
          LEFT JOIN class_details cd ON u.id = cd.user_id
          LEFT JOIN class c ON cd.class_id = c.id
          LEFT JOIN membership_details md ON u.id = md.user_id
          LEFT JOIN membership m ON md.membership_id = m.id
          LEFT JOIN trainer_details td ON u.id = td.user_id
          LEFT JOIN trainer t ON td.trainer_id = t.id";

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


                <table class="table table-bordered border-primary">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php
                        $c = ($page - 1) * $recordsPerPage + 1; // Counter for record numbering
                        if (isset($result) && mysqli_num_rows($result) > 0):
                            foreach ($result as $value):
                                ?>
                                <?php if (!empty($value['trainer_id']) || !empty($value['class_id']) || !empty($value['membership_id'])): ?>
                                    <tr><?php
                                    if (!empty($value['trainer_id'])) { ?>
                                        <th scope="row"><?php echo $c++; ?></th>
                                        <td><?php echo $value['username'] ?></td>
                                        <td><?php echo $value['useremail'] ?></td>
                                        <td><?php echo $value['userphone'] ?></td>
                                        <td>
                                            <?php

                                                echo "Trainer Name: " . $value['name'] . " (G-Coins: " . $value['gcoins'] . ")";
                                            }
                                            ?>
                                            </td>
                                            </tr>
                                         <?php
                                            if (!empty($value['class_id'])) { ?>
                                        <th scope="row"><?php echo $c++; ?></th>
                                        <td><?php echo $value['username'] ?></td>
                                        <td><?php echo $value['useremail'] ?></td>
                                        <td><?php echo $value['userphone'] ?></td>
                                        <td>
                                            <?php

                                                echo "Class Name: " . $value['cName'] . " (G-Coins: " . $value['classamount'] . ")";
                                            }
                                            ?>
                                            </td>
                                            
                                            </td>
                                            </tr>
                                             <?php
                                            if (!empty($value['membership_id'])) { ?>
                                        <th scope="row"><?php echo $c++; ?></th>
                                        <td><?php echo $value['username'] ?></td>
                                        <td><?php echo $value['useremail'] ?></td>
                                        <td><?php echo $value['userphone'] ?></td>
                                        <td>
                                            <?php

                                                echo "Membership: " . $value['title'] . " (Amount: " . $value['amount'] . ")";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php
                            endforeach;
                        else:
                            ?>
                            <tr>
                                <td colspan="5">No records found.</td>
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
                                    <a class="page-link"
                                        href="?page=<?php echo $i; ?>">
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
