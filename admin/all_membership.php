<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("location: index.php");
}
include('nav.php');
include('../db.php');

$query = "SELECT * FROM membership ";
$result = mysqli_query($conn, $query);

?>

<div class="content w-full">
    <div class="container pt-5">

        <div class="row">
            <div class="col-10 mx-auto">
            <?php include ('../functions/message.php');  ?>
                <table class="table table-bordered border-primary">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col"> Name</th>
                            <th scope="col">G-COINS</th>
                            <th scope="col">IMG</th>
                            <th scope="col">Additional Features</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php $c=1;
                        if  (isset($result) && mysqli_num_rows($result) > 0):
                            foreach ($result as $value):
                        ?>
                        <tr>
                            <th scope="row"><?php echo $c++; ?></th>
                            <td><?php echo $value['title'] ?></td>
                            <td><?php echo $value['amount'] ?></td>
                            <td><img src="../uploads/<?php echo $value['IMG']  ?>" width=100 alt=""></td>
                            <td><?php echo $value['features1'] . ",". $value['features2'] . ",".$value['features3'].",".$value['features4']. ",". $value['features5'];  ?></td>
                            <td>
                            <a href="view_membership.php?id=<?php echo $value['id']; ?>&membership=<?php echo $value['title'] ?>" class="btn btn-secondary">SHOW BOOKED</a>
                                <a href="editmembership.php?id=<?php echo $value['id']; ?>" class="btn btn-success">EDIT</a>
                                <a href="deletemembership.php?id=<?php echo $value['id']; ?>" class="btn btn-danger">DELETE</a>
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
                
        </div>
    </div>
</div>
