<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("location: index.php");
}
include('nav.php');
include('../db.php');

$id=$_GET['id'];

$query = "SELECT c.*,u.*
FROM class AS c
JOIN class_details AS cd ON c.id = cd.class_id
JOIN users AS u ON u.id = cd.user_id
where c.id=$id";
$result = mysqli_query($conn, $query);


?>

<div class="content w-full">
            <div class="container pt-5">
            <center>
            <a type="submit" href="all_class.php" class="btn btn-primary m-2">View all Clases</a>
        </center>
        <?php include ('../functions/message.php');  ?>

                <h1> Class Name:<?php echo $_GET['classname'] ?> </h1>
                <div class="row">
                    <div class="col-10 mx-auto">
                        <table class="table table-bordered border-primary">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Attendee name</th>
                                <th scope="col">Attendee email</th>
                                <th scope="col">Attendee Phone</th>
                                <th scope="col">Attendee Gender</th>
                                <th scope="col">Action </th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <?php $c=1; if(isset($result)): foreach($result as $value):?>
                                    <tr>
                                    <th scope="row"><?php echo $c++; ?></th>
                                    <td><?php echo $value['name']?></td>
                                    <td><?php echo $value['email']?></td>
                                    <td><?php echo $value['phone']?></td>
                                    <td><?php echo $value['gender']?></td>
                                    <td>

                                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#model<?php echo $value['id']; ?>">
                                                REFUND
                                                </button>
                                        <a href="delete_from_class.php?id=<?php echo $id?>&user_id=<?php echo $value['id']; ?>&classname=<?php echo $value['cName']?> "
                                                class="btn btn-danger "> DELETE </a>
                                    </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="model<?php echo $value['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Refund </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        <h3> Do you sure to refund <?php echo $value['name']?> by <?php echo $value['amount']?>?  </h3>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <a href="refund.php?id=<?php echo $id?>&user_id=<?php echo $value['id']; ?>&classname=<?php echo $value['cName']?> "
                                                class="btn btn-info "> REFUND </a>                                        
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                <?php endforeach;endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
