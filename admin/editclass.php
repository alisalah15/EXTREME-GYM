<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("location: index.php");
}
include('nav.php');
include('../db.php');


    $id= $_GET['id'];
    $query = "SELECT * FROM class WHERE id=$id ";
    $result = mysqli_query($conn, $query);
    $coin = mysqli_fetch_assoc($result);




if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

        $sql = "UPDATE class SET tName = '$tName', cName = '$cName', from_hour = '$from_hour', 
        from_period = '$from_period', to_hour = '$to_hour', to_period = '$to_period', 
        amount = '$amount', day = '$day' WHERE id = $id";

        if (mysqli_query($conn, $sql)) {
        $_SESSION['Done'] = "Class Updated";
        header("Location: editclass.php?id=$id");
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
                <h1>Edit Class</h1>
                <?php include ('../functions/message.php');  ?>
                <div class="col-md-12">
                    <label for="inputPassword4" class="form-label">Trainer name</label>
                    <input type="text" value="<?php echo $coin['tName'] ?>"  class="form-control" name="tName" id="inputPassword4" required>
                </div>
                <div class="col-md-12">
                    <label for="inputPassword4" class="form-label">Class name</label>
                    <input type="text" value="<?php echo $coin['cName'] ?>" class="form-control" name="cName" id="inputPassword4" required>
                </div>
                <div class="col-md-6">
                    <label for="inputEmail4" class="form-label">From</label>
                    <input type="number" value="<?php echo $coin['from_hour'] ?>" class="form-control" name="from_hour" id="inputEmail4" placeholder="Hour" required>
                </div>
                <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">AM/PM</label>
                    <select class="form-select" name="from_period" required>
                    <option value="AM" <?php echo ($coin['from_period'] === 'AM') ? 'selected' : ''; ?>>AM</option>
                    <option value="PM" <?php echo ($coin['from_period'] === 'PM') ? 'selected' : ''; ?>>PM</option>
                </select>
                </div>
                <div class="col-md-6">
                    <label for="inputEmail4" class="form-label">To</label>
                    <input type="number"  value="<?php echo $coin['to_hour'] ?>"  class="form-control" name="to_hour" id="inputEmail4" placeholder="Hour" required>
                </div>
                <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">AM/PM</label>
                    <select class="form-select" name="to_period" required>
                    <option value="AM" <?php echo ($coin['to_period'] === 'AM') ? 'selected' : ''; ?>>AM</option>
                    <option value="PM" <?php echo ($coin['to_period'] === 'PM') ? 'selected' : ''; ?>>PM</option>
                </select>
                </div>
                <div class="col-md-12">
                    <label for="inputEmail4" class="form-label">Coin Amount</label>
                    <input type="number"  value="<?php echo $coin['amount'] ?>" class="form-control" name="amount" id="inputEmail4" required>
                </div>

                <div class="col-md-12">
                <label for="inputEmail4" name="day" class="form-label">Day</label>
                <select class="form-select" name="day" required>
                <option value="" disabled>Select a day</option>
                <option value="Monday" <?php echo ($coin['day'] === 'Monday') ? 'selected' : ''; ?>>Monday</option>
                <option value="Tuesday" <?php echo ($coin['day'] === 'Tuesday') ? 'selected' : ''; ?>>Tuesday</option>
                <option value="Wednesday" <?php echo ($coin['day'] === 'Wednesday') ? 'selected' : ''; ?>>Wednesday</option>
                <option value="Thursday" <?php echo ($coin['day'] === 'Thursday') ? 'selected' : ''; ?>>Thursday</option>
                <option value="Friday" <?php echo ($coin['day'] === 'Friday') ? 'selected' : ''; ?>>Friday</option>
                <option value="Saturday" <?php echo ($coin['day'] === 'Saturday') ? 'selected' : ''; ?>>Saturday</option>
                <option value="Sunday" <?php echo ($coin['day'] === 'Sunday') ? 'selected' : ''; ?>>Sunday</option>
            </select>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>

        </div>
        <a type="submit" href="all_class.php" class="btn btn-primary">View all Clases</a>
    </div>
</div>