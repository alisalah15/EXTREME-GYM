<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("location: index.php");
}
include('nav.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include ('../db.php');
    $errors = array();
    $tName = $_POST['tName'];
    $cName = $_POST['cName'];
    $from_hour = $_POST['from_hour'];
    $from_period = $_POST['from_period'];
    $to_hour = $_POST['to_hour'];
    $to_period = $_POST['to_period'];
    $amount = $_POST['amount'];
    $day = $_POST['day'];
    
    if ($amount <= 0) {
        $errors[] = "Amount must be greater than 0";
    }


    if (empty($errors)) {

        $sql = "INSERT INTO class (tName, cName, from_hour, from_period, to_hour, to_period, amount, day) 
        VALUES ('$tName', '$cName', '$from_hour', '$from_period', '$to_hour', '$to_period', '$amount', '$day')";
        if (mysqli_query($conn, $sql)) {
        $_SESSION['Done'] = "Class Added";
        header("Location: class.php");
        exit();
        }

    }else{
        $_SESSION['errors'] = $errors;
    }


}
?>
<div class="container pt-5">
    <div class="row">
        <div class="col-8 mx-auto">
            <form class="row g-3 border p-4" method="post">
                <h1>Add New Class</h1>
                <?php include ('../functions/message.php');  ?>
                <div class="col-md-12">
                    <label for="inputPassword4" class="form-label">Trainer name</label>
                    <input type="text" class="form-control" name="tName" id="inputPassword4" required>
                </div>
                <div class="col-md-12">
                    <label for="inputPassword4" class="form-label">Class name</label>
                    <input type="text" class="form-control" name="cName" id="inputPassword4" required>
                </div>
                <div class="col-md-6">
                    <label for="inputEmail4" class="form-label">From</label>
                    <input type="number" class="form-control" name="from_hour" id="inputEmail4" placeholder="Hour" required>
                </div>
                <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">AM/PM</label>
                    <select class="form-select" name="from_period" required>
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="inputEmail4" class="form-label">To</label>
                    <input type="number" class="form-control" name="to_hour" id="inputEmail4" placeholder="Hour" required>
                </div>
                <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">AM/PM</label>
                    <select class="form-select" name="to_period" required>
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="inputEmail4" class="form-label">Coin Amount</label>
                    <input type="number" class="form-control" name="amount" id="inputEmail4" required>
                </div>

                <div class="col-md-12">
                <label for="inputEmail4" name="day" class="form-label">Day</label>
                <select class="form-select" name="day" required>
                <option selected>Select a day</option>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
                </select>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>

        </div>
        <a type="submit" href="all_class.php" class="btn btn-primary">View all Clases</a>
    </div>
</div>