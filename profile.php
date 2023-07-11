<?php
include('nav.php');
if (!isset($_SESSION['user'])) {
    header("location: index.php");
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

?>
<head>
<link rel="stylesheet" type="text/css" href="form/registration.css">

</head>

<div class="background-image"></div>
<form action="php/profile.php" class="form" method="post">
    <?php include('functions/message.php');  ?>
    <h2>Profile</h2>
    <input type="text" name="name" class="box" placeholder="Enter your name"
        value="<?php echo $user['name'] ?>" required>
    <input type="text" name="email" class="box" placeholder="Enter your email"
        value="<?php echo $user['email'] ?>" required>
    <input type="text" name="phone" class="box" placeholder="Phone number"
        value="<?php echo $user['phone'] ?>" required>
    <select name="gender" class="box" required>
        <option value="" disabled selected>Select Gender</option>
        <option value="male" <?php echo ($user['gender'] === 'male') ? 'selected' : ''; ?>>Male</option>
        <option value="female" <?php echo ($user['gender'] === 'female') ? 'selected' : ''; ?>>Female</option>
    </select>

    <input type="date" name="dob" class="box" placeholder="Date of birth"
        value="<?php echo $user['date_of_birth'] ?>" required>
    <input type="text" name="weight" class="box" placeholder="Your weight"
        value="<?php echo $user['weight'] ?>" required>
    <input type="text" name="height" class="box" placeholder="Your height"
        value="<?php echo $user['height'] ?>" required>
        <button type="submit" class="btn btn-primary m-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Update
    </button>    
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Change Password
    </button>
</form>

<!-- Modal Password -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="php/changepassword.php" method="post">
      <input type="password" name="current_password" class="box" placeholder="Enter a Current password" required>
      <input type="password" name="new_password" class="box" placeholder="Enter a New password" required>
        <input type="password" name="confirm_password" class="box" placeholder="Confirm password" required>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </form>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>

</html>
