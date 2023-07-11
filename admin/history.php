<?php
session_start();
include('nav.php');
include('../db.php');

$trainer_id= $_GET['id'];
$query2 = "SELECT * from pay_details where trainer_id=$trainer_id
ORDER BY created_at DESC";
$result2 = mysqli_query($conn, $query2);
?>


<div class="row">
    <div class="col-10 mx-auto">
        <?php include('../functions/message.php'); ?>
        <h1>Trainer: <?php echo $_GET['name']?></h1>
        <center>
            <a type="button" href="a_trainer.php" class="btn btn-info">View All TRAINERS</a>
        </center>

        <table class="table table-bordered border-primary">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col"> amount </th>
                                                <th scope="col">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-group-divider">
                                            <?php
                                                $c=1; while ($trainer = mysqli_fetch_assoc($result2)) { ?>
                                            <tr>
                                                <td><?php echo $c++; ?></td>
                                                <td><?php echo $trainer['amount']; ?></td>
                                                <td><?php echo $trainer['created_at']; ?></td>
                                            </tr>
                                            <?php }   ?>
                                        </tbody>
                                    </table>