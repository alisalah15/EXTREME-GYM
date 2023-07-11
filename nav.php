<?php
session_start();
include('db.php');
if(isset($_SESSION['user'])){
    $id=$_SESSION['user_id'] ;
    $query = "SELECT * FROM users WHERE id = $id ";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

}
if(isset($_SESSION['trainer'])){
    $id=$_SESSION['trainer_id'] ;
    $query = "SELECT * FROM trainer WHERE id = $id ";
    $result = mysqli_query($conn, $query);
    $trainer = mysqli_fetch_assoc($result);

}

?>
<!DOCTYPE html>
<html>
<head>
	<title>EXTREME</title>
	        <!-- Favicon -->
			<link href="img/favicon.ico" rel="icon">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

			<!-- Google Web Fonts -->
			<link rel="preconnect" href="https://fonts.gstatic.com">
			<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Rubik&display=swap" rel="stylesheet"> 
			
			<!-- Icon Font Stylesheet -->
			<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
			<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
			<link href="../lib/flaticon/font/flaticon.css" rel="stylesheet">
			
			<!-- Libraries Stylesheet -->
			<link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
			
			<!-- Customized Bootstrap Stylesheet -->
			<link href="css/bootstrap.min.css" rel="stylesheet">
			
			<!-- Template Stylesheet -->
			<link href="css/style.css" rel="stylesheet">
</head>
<body>
	 <!-- Header Start -->
	 <div class="container-fluid bg-dark px-0">
        <div class="row gx-0">
            <div class="col-lg-3 bg-dark d-none d-lg-block">
                <a href="index.html" class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
                    <h1 class="m-0 display-4 text-primary text-uppercase">EXTREME</h1>
                </a>
            </div>
            <div class="col-lg-9">
                <div class="row gx-0 bg-secondary d-none d-lg-flex">
                    <div class="col-lg-7 px-5 text-start">
                    </div>
                    <div class="col-lg-5 px-5 text-end">
                     
                    </div>
                </div>
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark p-3 p-lg-0 px-lg-5">
                    <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="index.php" class="nav-item nav-link active">Home</a>
                            <?php if (isset($_SESSION['trainer'])){ ?>
                            <a href="my_members.php" class="nav-item nav-link">My Members</a>
                            <a href="transactions.php" class="nav-item nav-link">Transactions</a>
                            <?php } ?>
                            <?php if (!isset($_SESSION['trainer'])){ ?>
                            <a href="membership.php" class="nav-item nav-link">Memberships</a>
                            <a href="class.php" class="nav-item nav-link">Classes</a>
                            <a href="team.php" class="nav-item nav-link">Trainers</a>
                            <a href="profile.php" class="nav-item nav-link">Profile</a>
                            <?php } ?>

                            <?php if (isset($_SESSION['user'])){ ?>

                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">G-COINS</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="bcoin.php" class="dropdown-item">BUY G-COINS</a>
                                    <a href="tcoin.php" class="dropdown-item">TRANSFER G-COINS</a>
                                </div>
                            </div>
                            <?php } ?>

                            <a href="contact.php" class="nav-item nav-link">Contact</a>
                            <a href="about.php" class="nav-item nav-link">About</a>
                            <?php if (isset($_SESSION['user'])){ ?>
                            <a href="logout.php" class="nav-item nav-link">Logout</a>
                            <?php } ?>
                            <?php if (isset($_SESSION['trainer'])){ ?>
                            <a href="logout_t.php" class="nav-item nav-link">Logout</a>
                            <?php } ?>
                        </div>
                        <?php if (isset($_SESSION['user'])){ ?>
                            <a href="bcoin.php" class="btn btn-primary py-md-3 px-md-3 d-none d-lg-block">Balance: <?php echo $user['balance']; ?> </a>
                            <?php
                        } elseif(isset($_SESSION['trainer'])) { ?>
                         <a href="#" class="btn btn-primary py-md-3 px-md-3 d-none d-lg-block">Balance: <?php echo $trainer['balance']; ?> EGP </a>
                         <?php
                        }else{?>
                        <a href="form/options.php" class="btn btn-primary py-md-3 px-md-5 d-none d-lg-block">Join Us</a>
                        <a href="form/login.php" class="btn btn-primary py-md-3 px-md-5 d-none d-lg-block">Login</a>
                        <?php
                        }
                        ?>
                        

                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Header End -->