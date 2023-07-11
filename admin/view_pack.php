<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("location: index.php");
}
include('nav.php');
include('../db.php');

$query = "SELECT * FROM coins";
$result = mysqli_query($conn, $query);

?>

<div class="content w-full">
            <div class="container pt-5">
                <div class="row">
                    <div class="col-10 mx-auto">
                        <table class="table table-bordered border-primary">
                            <thead>
                            <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Coin</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <?php $c=1; if(isset($result)): foreach($result as $value):?>
                                    <tr>
                                    <th scope="row"><?php echo $c++; ?></th>
                                    <td><?php echo $value['coin']?></td>
                                    <td><?php echo $value['price']?></td>
                                    <td>
                                        <a href="edit.php?id=<?php echo $value['id']; ?> "
                                            class="btn btn-success "> EDIT </a>
                                        <a href="delete.php?id=<?php echo $value['id']; ?> "
                                            class="btn btn-danger "> DELETE </a>
                                    </td>
                                </tr>
                                <?php endforeach;endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>