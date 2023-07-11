<?php
include('nav.php');
?>
<!-- Hero Start -->
<div class="container-fluid bg-primary p-5 bg-hero mb-5">
    <div class="row py-5">
        <div class="col-12 text-center">
            <h1 class="display-2 text-uppercase text-white mb-md-4">Classes</h1>
            <a href="index.php" class="btn btn-primary py-md-3 px-md-5 me-3">Home</a>
            <a href="" class="btn btn-light py-md-3 px-md-5">Classes</a>
        </div>
    </div>
</div>
<!-- Hero End -->


<!-- Class Timetable Start -->
<div class="container-fluid p-5">
    <center>
       <?php if(isset($_SESSION['user'])){ ?>
        <a href="my_class.php" class="btn btn-primary py-md-3 px-md-5 me-3">MY Classes</a>
        <?php
       } 
       ?>
    </center>

    <div class="mb-5 text-center">
        <h5 class="text-primary text-uppercase">Class Schedule</h5>
        <h1 class="display-3 text-uppercase mb-0">Working Hours</h1>
    </div>
    <div class="tab-class text-center">
        <ul class="nav nav-pills d-inline-flex justify-content-center bg-dark text-uppercase rounded-pill mb-5">
            <li class="nav-item">
                <a class="nav-link rounded-pill text-white active" data-bs-toggle="pill" href="#tab-1">Monday</a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-pill text-white" data-bs-toggle="pill" href="#tab-2">Tuesday</a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-pill text-white" data-bs-toggle="pill" href="#tab-3">Wednesday</a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-pill text-white" data-bs-toggle="pill" href="#tab-4">Thursday</a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-pill text-white" data-bs-toggle="pill" href="#tab-5">Friday</a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-pill text-white" data-bs-toggle="pill" href="#tab-6">Saturday</a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-pill text-white" data-bs-toggle="pill" href="#tab-7">Sunday</a>
            </li>
        </ul>
        <div class="tab-content">

            <!-- Monday  -->
            <?php 
            $mondayQuery = "SELECT * FROM class where `day` = 'Monday'";
            $mondayResult = mysqli_query($conn, $mondayQuery);
            ?>
            <div id="tab-1" class="tab-pane fade show p-0 active">
                <div class="row g-5">
                    <?php $c=1; if(isset($mondayResult)): foreach($mondayResult as $value):?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="bg-dark rounded text-center py-5 px-3">
                            <h5 class="text-uppercase text-light mb-3">
                                <?php echo $value['from_hour'].$value['from_period']. "-" . $value['to_hour']. $value['to_period']   ?>
                            </h5>
                            <h4 class="text-uppercase text-primary"><?php echo $value['cName'] ?></h4>
                            <p class="text-uppercase text-secondary mb-0"><?php echo $value['tName'] ?></p>
                            <p class="text-uppercase text-secondary mb-0"> G-COINS: <?php echo $value['amount'] ?></p>
                            <?php if(isset($_SESSION['user'])): ?>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#exampleModal<?php echo $value['id'];?>">
                                Book NOW </button>
                            <?php endif;?>
                        </div>
                    </div>
                    <!-- Book Model -->
                    <div class="modal fade" id="exampleModal<?php echo $value['id'];?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Book NOW</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h3> Available balance: <?php echo $user['balance'] ?></h3>
                                    <h3> Class G-Coins: <?php echo $value['amount'] ?></h3>
                                    <?php  $balance=0; $balance =  $user['balance']-$value['amount']  ?>
                                    <h3> Balance After Book: <?php echo  $balance ?></h3>
                                    <?php if ($balance < 0) : ?>
                                    <p class="text-danger">Insufficient balance. Please add funds to your account.</p>
                                    <?php endif; ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                        <?php if ($balance >= 0) : 
                                            $userid = $_SESSION['user_id'];  
                                            $classid = $value['id'];      
                                            $query1 = "SELECT * FROM class_details WHERE user_id = $userid AND class_id = $classid";
                                            $result1 = mysqli_query($conn, $query1);
                                        ?>
                                        <form action="php/addclass.php" method="post">
                                            <input type="hidden" name="balance" value="<?php echo $balance?>">
                                            <input type="hidden" name="className" value="<?php echo $value['cName']?>">
                                            <input type="hidden" name="classId" value="<?php echo $value['id']?>">
                                            <?php if (mysqli_num_rows($result1) == 0) : ?>
                                                <button type="submit" class="btn btn-primary">Confirm</button>
                                            <?php else: ?>   
                                                <p class="text-danger">You cannot book this class. You already booked.</p>
                                            <?php endif; ?>
                                        </form>
                                        <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;endif ?>
                </div>
            </div>

            <!-- Tuesday-->
            <?php 
            $tuesdayQuery = "SELECT * FROM class where `day` = 'Tuesday'";
            $tuesdayResult = mysqli_query($conn, $tuesdayQuery);
            ?>
            <div id="tab-2" class="tab-pane fade show p-0 ">
                <div class="row g-5">
                    <?php $c=1; if(isset($tuesdayResult)): foreach($tuesdayResult as $value):?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="bg-dark rounded text-center py-5 px-3">
                            <h5 class="text-uppercase text-light mb-3">
                                <?php echo $value['from_hour'].$value['from_period']. "-" . $value['to_hour']. $value['to_period']   ?>
                            </h5>
                            <h4 class="text-uppercase text-primary"><?php echo $value['cName'] ?></h4>
                            <p class="text-uppercase text-secondary mb-0"><?php echo $value['tName'] ?></p>
                            <p class="text-uppercase text-secondary mb-0"> G-COINS: <?php echo $value['amount'] ?></p>
                            <?php if(isset($_SESSION['user'])): ?>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#exampleModal<?php echo $value['id'];?>">
                                Book NOW </button>
                            <?php endif;?>
                        </div>
                    </div>
                    <!-- Book Model -->
                    <div class="modal fade" id="exampleModal<?php echo $value['id'];?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h3> Available balance: <?php echo $user['balance'] ?></h3>
                                    <h3> Class G-Coins: <?php echo $value['amount'] ?></h3>
                                    <?php  $balance=0; $balance =  $user['balance']-$value['amount']  ?>
                                    <h3> Balance After Book: <?php echo  $balance ?></h3>
                                    <?php if ($balance < 0) : ?>
                                    <p class="text-danger">Insufficient balance. Please add funds to your account.</p>
                                    <?php endif; ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                        <?php if ($balance >= 0) : 
                                            $userid = $_SESSION['user_id'];  
                                            $classid = $value['id'];      
  
                                            $query1 = "SELECT * FROM class_details WHERE user_id = $userid AND class_id = $classid";
                                            $result1 = mysqli_query($conn, $query1);
                                        ?>
                                        <form action="php/addclass.php" method="post">
                                            <input type="hidden" name="balance" value="<?php echo $balance?>">
                                            <input type="hidden" name="className" value="<?php echo $value['cName']?>">
                                            <input type="hidden" name="classId" value="<?php echo $value['id']?>">

                                            <?php if (mysqli_num_rows($result1) == 0) : ?>
                                                <button type="submit" class="btn btn-primary">Confirm</button>
                                            <?php else: ?>   
                                                <p class="text-danger">You cannot book this class. You already booked.</p>
                                            <?php endif; ?>
                                        </form>
                                        <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;endif ?>
                </div>
            </div>

            <!-- Wednesday-->
            <?php 
            $wednesdayQuery = "SELECT * FROM class where `day` = 'Wednesday'";
            $wednesdayResult = mysqli_query($conn, $wednesdayQuery);
            ?>
            <div id="tab-3" class="tab-pane fade show p-0 ">
                <div class="row g-5">
                    <?php $c=1; if(isset($wednesdayResult)): foreach($wednesdayResult as $value):?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="bg-dark rounded text-center py-5 px-3">
                            <h5 class="text-uppercase text-light mb-3">
                                <?php echo $value['from_hour'].$value['from_period']. "-" . $value['to_hour']. $value['to_period']   ?>
                            </h5>
                            <h4 class="text-uppercase text-primary"><?php echo $value['cName'] ?></h4>
                            <p class="text-uppercase text-secondary mb-0"><?php echo $value['tName'] ?></p>
                            <p class="text-uppercase text-secondary mb-0"> G-COINS: <?php echo $value['amount'] ?></p>
                            <?php if(isset($_SESSION['user'])): ?>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#exampleModal<?php echo $value['id'];?>">
                                Book NOW </button>
                            <?php endif;?>
                        </div>
                    </div>
                    <!-- Book Model -->
                    <div class="modal fade" id="exampleModal<?php echo $value['id'];?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h3> Available balance: <?php echo $user['balance'] ?></h3>
                                    <h3> Class G-Coins: <?php echo $value['amount'] ?></h3>
                                    <?php  $balance=0; $balance =  $user['balance']-$value['amount']  ?>
                                    <h3> Balance After Book: <?php echo  $balance ?></h3>
                                    <?php if ($balance < 0) : ?>
                                    <p class="text-danger">Insufficient balance. Please add funds to your account.</p>
                                    <?php endif; ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                        <?php if ($balance >= 0) : 
                                            $userid = $_SESSION['user_id'];  
                                            $classid = $value['id'];      
  
                                            $query1 = "SELECT * FROM class_details WHERE user_id = $userid AND class_id = $classid";
                                            $result1 = mysqli_query($conn, $query1);
                                        ?>
                                        <form action="php/addclass.php" method="post">
                                            <input type="hidden" name="balance" value="<?php echo $balance?>">
                                            <input type="hidden" name="className" value="<?php echo $value['cName']?>">
                                            <input type="hidden" name="classId" value="<?php echo $value['id']?>">

                                            <?php if (mysqli_num_rows($result1) == 0) : ?>
                                                <button type="submit" class="btn btn-primary">Confirm</button>
                                            <?php else: ?>   
                                                <p class="text-danger">You cannot book this class. You already booked.</p>
                                            <?php endif; ?>
                                        </form>
                                        <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;endif ?>
                </div>
            </div>


            <!-- Thursday-->
            <?php 
            $thursdayQuery = "SELECT * FROM class where `day` = 'Thursday'";
            $thursdayResult = mysqli_query($conn, $thursdayQuery);
            ?>
            <div id="tab-4" class="tab-pane fade show p-0 ">
                <div class="row g-5">
                    <?php $c=1; if(isset($thursdayResult)): foreach($thursdayResult as $value):?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="bg-dark rounded text-center py-5 px-3">
                            <h5 class="text-uppercase text-light mb-3">
                                <?php echo $value['from_hour'].$value['from_period']. "-" . $value['to_hour']. $value['to_period']   ?>
                            </h5>
                            <h4 class="text-uppercase text-primary"><?php echo $value['cName'] ?></h4>
                            <p class="text-uppercase text-secondary mb-0"><?php echo $value['tName'] ?></p>
                            <p class="text-uppercase text-secondary mb-0"> G-COINS: <?php echo $value['amount'] ?></p>
                            <?php if(isset($_SESSION['user'])): ?>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#exampleModal<?php echo $value['id'];?>">
                                Book NOW </button>
                            <?php endif;?>
                        </div>
                    </div>
                    <!-- Book Model -->
                    <div class="modal fade" id="exampleModal<?php echo $value['id'];?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h3> Available balance: <?php echo $user['balance'] ?></h3>
                                    <h3> Class G-Coins: <?php echo $value['amount'] ?></h3>
                                    <?php  $balance=0; $balance =  $user['balance']-$value['amount']  ?>
                                    <h3> Balance After Book: <?php echo  $balance ?></h3>
                                    <?php if ($balance < 0) : ?>
                                    <p class="text-danger">Insufficient balance. Please add funds to your account.</p>
                                    <?php endif; ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                        <?php if ($balance >= 0) : 
                                            $userid = $_SESSION['user_id'];   
                                            $classid = $value['id'];      
 
                                            $query1 = "SELECT * FROM class_details WHERE user_id = $userid AND class_id = $classid";
                                            $result1 = mysqli_query($conn, $query1);
                                        ?>
                                        <form action="php/addclass.php" method="post">
                                            <input type="hidden" name="balance" value="<?php echo $balance?>">
                                            <input type="hidden" name="className" value="<?php echo $value['cName']?>">
                                            <input type="hidden" name="classId" value="<?php echo $value['id']?>">

                                            <?php if (mysqli_num_rows($result1) == 0) : ?>
                                                <button type="submit" class="btn btn-primary">Confirm</button>
                                            <?php else: ?>   
                                                <p class="text-danger">You cannot book this class. You already booked.</p>
                                            <?php endif; ?>
                                        </form>
                                        <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;endif ?>
                </div>
            </div>

            <!-- Friday-->
            <?php 
            $fridayQuery = "SELECT * FROM class where `day` = 'Friday'";
            $fridayResult = mysqli_query($conn, $fridayQuery);
            ?>
            <div id="tab-5" class="tab-pane fade show p-0 ">
                <div class="row g-5">
                    <?php $c=1; if(isset($fridayResult)): foreach($fridayResult as $value):?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="bg-dark rounded text-center py-5 px-3">
                            <h5 class="text-uppercase text-light mb-3">
                                <?php echo $value['from_hour'].$value['from_period']. "-" . $value['to_hour']. $value['to_period']   ?>
                            </h5>
                            <h4 class="text-uppercase text-primary"><?php echo $value['cName'] ?></h4>
                            <p class="text-uppercase text-secondary mb-0"><?php echo $value['tName'] ?></p>
                            <p class="text-uppercase text-secondary mb-0"> G-COINS: <?php echo $value['amount'] ?></p>
                            <?php if(isset($_SESSION['user'])): ?>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#exampleModal<?php echo $value['id'];?>">
                                Book NOW </button>
                            <?php endif;?>
                        </div>
                    </div>
                    <!-- Book Model -->
                    <div class="modal fade" id="exampleModal<?php echo $value['id'];?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h3> Available balance: <?php echo $user['balance'] ?></h3>
                                    <h3> Class G-Coins: <?php echo $value['amount'] ?></h3>
                                    <?php  $balance=0; $balance =  $user['balance']-$value['amount']  ?>
                                    <h3> Balance After Book: <?php echo  $balance ?></h3>
                                    <?php if ($balance < 0) : ?>
                                    <p class="text-danger">Insufficient balance. Please add funds to your account.</p>
                                    <?php endif; ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                        <?php if ($balance >= 0) : 
                                            $userid = $_SESSION['user_id'];   
                                            $classid = $value['id'];      
 
                                            $query1 = "SELECT * FROM class_details WHERE user_id = $userid AND class_id = $classid";
                                            $result1 = mysqli_query($conn, $query1);
                                        ?>
                                        <form action="php/addclass.php" method="post">
                                            <input type="hidden" name="balance" value="<?php echo $balance?>">
                                            <input type="hidden" name="className" value="<?php echo $value['cName']?>">
                                            <input type="hidden" name="classId" value="<?php echo $value['id']?>">

                                            <?php if (mysqli_num_rows($result1) == 0) : ?>
                                                <button type="submit" class="btn btn-primary">Confirm</button>
                                            <?php else: ?>   
                                                <p class="text-danger">You cannot book this class. You already booked.</p>
                                            <?php endif; ?>
                                        </form>
                                        <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;endif ?>
                </div>
            </div>


            <!-- Saturday-->
            <?php 
            $saturdayQuery = "SELECT * FROM class where `day` = 'Saturday'";
            $saturdayResult = mysqli_query($conn, $saturdayQuery);
            ?>
            <div id="tab-6" class="tab-pane fade show p-0 ">
                <div class="row g-5">
                    <?php $c=1; if(isset($saturdayResult)): foreach($saturdayResult as $value):?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="bg-dark rounded text-center py-5 px-3">
                            <h5 class="text-uppercase text-light mb-3">
                                <?php echo $value['from_hour'].$value['from_period']. "-" . $value['to_hour']. $value['to_period']   ?>
                            </h5>
                            <h4 class="text-uppercase text-primary"><?php echo $value['cName'] ?></h4>
                            <p class="text-uppercase text-secondary mb-0"><?php echo $value['tName'] ?></p>
                            <p class="text-uppercase text-secondary mb-0"> G-COINS: <?php echo $value['amount'] ?></p>
                            <?php if(isset($_SESSION['user'])): ?>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#exampleModal<?php echo $value['id'];?>">
                                Book NOW </button>
                            <?php endif;?>
                        </div>
                    </div>
                    <!-- Book Model -->
                    <div class="modal fade" id="exampleModal<?php echo $value['id'];?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h3> Available balance: <?php echo $user['balance'] ?></h3>
                                    <h3> Class G-Coins: <?php echo $value['amount'] ?></h3>
                                    <?php  $balance=0; $balance =  $user['balance']-$value['amount']  ?>
                                    <h3> Balance After Book: <?php echo  $balance ?></h3>
                                    <?php if ($balance < 0) : ?>
                                    <p class="text-danger">Insufficient balance. Please add funds to your account.</p>
                                    <?php endif; ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                        <?php if ($balance >= 0) : 
                                            $userid = $_SESSION['user_id'];   
                                            $classid = $value['id'];      
 
                                            $query1 = "SELECT * FROM class_details WHERE user_id = $userid AND class_id = $classid";
                                            $result1 = mysqli_query($conn, $query1);
                                        ?>
                                        <form action="php/addclass.php" method="post">
                                            <input type="hidden" name="balance" value="<?php echo $balance?>">
                                            <input type="hidden" name="className" value="<?php echo $value['cName']?>">
                                            <input type="hidden" name="classId" value="<?php echo $value['id']?>">

                                            <?php if (mysqli_num_rows($result1) == 0) : ?>
                                                <button type="submit" class="btn btn-primary">Confirm</button>
                                            <?php else: ?>   
                                                <p class="text-danger">You cannot book this class. You already booked.</p>
                                            <?php endif; ?>
                                        </form>
                                        <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;endif ?>
                </div>
            </div>

            <!-- Sunday-->
            <?php 
            $sundayQuery = "SELECT * FROM class where `day` = 'Sunday'";
            $sundayResult = mysqli_query($conn, $sundayQuery);
            ?>
            <div id="tab-7" class="tab-pane fade show p-0 ">
                <div class="row g-5">
                    <?php $c=1; if(isset($sundayResult)): foreach($sundayResult as $value):?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="bg-dark rounded text-center py-5 px-3">
                            <h5 class="text-uppercase text-light mb-3">
                                <?php echo $value['from_hour'].$value['from_period']. "-" . $value['to_hour']. $value['to_period']   ?>
                            </h5>
                            <h4 class="text-uppercase text-primary"><?php echo $value['cName'] ?></h4>
                            <p class="text-uppercase text-secondary mb-0"><?php echo $value['tName'] ?></p>
                            <p class="text-uppercase text-secondary mb-0"> G-COINS: <?php echo $value['amount'] ?></p>
                            <?php if(isset($_SESSION['user'])): ?>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#exampleModal<?php echo $value['id'];?>">
                                Book NOW </button>
                            <?php endif;?>
                        </div>
                    </div>
                    <!-- Book Model -->
                    <div class="modal fade" id="exampleModal<?php echo $value['id'];?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h3> Available balance: <?php echo $user['balance'] ?></h3>
                                    <h3> Class G-Coins: <?php echo $value['amount'] ?></h3>
                                    <?php  $balance=0; $balance =  $user['balance']-$value['amount']  ?>
                                    <h3> Balance After Book: <?php echo  $balance ?></h3>
                                    <?php if ($balance < 0) : ?>
                                    <p class="text-danger">Insufficient balance. Please add funds to your account.</p>
                                    <?php endif; ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                        <?php if ($balance >= 0) : 
                                            $userid = $_SESSION['user_id'];  
                                            $classid = $value['id'];      
  
                                            $query1 = "SELECT * FROM class_details WHERE user_id = $userid AND class_id = $classid";
                                            $result1 = mysqli_query($conn, $query1);
                                        ?>
                                        <form action="php/addclass.php" method="post">
                                            <input type="hidden" name="balance" value="<?php echo $balance?>">
                                            <input type="hidden" name="className" value="<?php echo $value['cName']?>">
                                            <input type="hidden" name="classId" value="<?php echo $value['id']?>">

                                            <?php if (mysqli_num_rows($result1) == 0) : ?>
                                                <button type="submit" class="btn btn-primary">Confirm</button>
                                            <?php else: ?>   
                                                <p class="text-danger">You cannot book this class. You already booked.</p>
                                            <?php endif; ?>
                                        </form>
                                        <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;endif ?>
                </div>
            </div>


        </div>
    </div>
</div>
<!-- Class Timetable Start -->


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
    </div>
</div>
<div class="container-fluid py-4 py-lg-0 px-5" style="background: #111111;">
    <div class="row gx-5">
        <div class="col-lg-8">
            <div class="py-lg-4 text-center">
                <p class="text-secondary mb-0">&copy; <a class="text-light fw-bold" href="#">Your Site Name</a>. All
                    Rights Reserved.</p>
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
<script src="js/main.js"></script>
</body>

</html>