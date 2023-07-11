<?php
session_start();
if(isset($_SESSION['user'])){
  header("location: ../index.php");
}
if(isset($_SESSION['trainer'])){
  header("location: ../index.php");
}
  include ('nav.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include ('../db.php');
  $errors = array();
  $data = array();
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['pass'];
  $confirmPassword = $_POST['con_pass'];
  $phone = $_POST['phone'];
  $gender = $_POST['gender'];
  $dateOfBirth = $_POST['dob'];
  $weight = $_POST['weight'];
  $height = $_POST['height'];

  $inputDate = new DateTime($dateOfBirth);
  $currentDate = new DateTime();
  $minBirthDate = $currentDate->modify('-16 years');

  if ($inputDate > $minBirthDate) {
    $errors[] = "Invalid date of birth. You must be at least 16 years old.";
  }

  if ($password !== $confirmPassword) {
    $errors[] = "Password and confirm password do not match";
  }
  if (strlen($password) < 6) {
    $errors[] = " password should be at least 6 characters long";
}
  if (!is_numeric($height) || !is_numeric($weight)) {
    $errors[] = "Height and weight must be numeric values";
  }
  if (!preg_match('/^(?:\+?20|0)?1[0-9]\d{8}$/', $phone)) {
    $errors[] = "Please enter a valid Egyptian phone number";
  }
  
  $emailQuery = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
  $emailResult = mysqli_query($conn, $emailQuery);
  if (mysqli_num_rows($emailResult) > 0) {
    $errors[] = "Email already exists";
  }
  
  // Check if phone number already exists
  $phoneQuery = "SELECT * FROM users WHERE phone = '$phone' LIMIT 1";
  $phoneResult = mysqli_query($conn, $phoneQuery);
  if (mysqli_num_rows($phoneResult) > 0) {
    $errors[] = "Phone number already exists";
  }
  
  $emailQuery1 = "SELECT * FROM trainer WHERE email = '$email' LIMIT 1";
  $emailResult1 = mysqli_query($conn, $emailQuery1);
  if (mysqli_num_rows($emailResult1) > 0) {
    $errors[] = "Email already exists";
  }
  
  // Check if phone number already exists
  $phoneQuery1 = "SELECT * FROM trainer WHERE phone = '$phone' LIMIT 1";
  $phoneResult1 = mysqli_query($conn, $phoneQuery1);
  if (mysqli_num_rows($phoneResult1) > 0) {
    $errors[] = "Phone number already exists";
  }
  
  
  
  // Store the entered data in the $data array
  $data['name'] = $name;
  $data['email'] = $email;
  $data['phone'] = $phone;
  $data['gender'] = $gender;
  $data['dob'] = $dateOfBirth;
  $data['weight'] = $weight;
  $data['height'] = $height;
  
  if (empty($errors)) {
    // Form data is valid
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password, phone, gender, date_of_birth, weight, height, balance) 
            VALUES ('$name', '$email', '$hashedPassword', '$phone', '$gender', '$dateOfBirth', '$weight', '$height', 0)";

    if (mysqli_query($conn, $sql)) {
      unset($_SESSION['data']);
      $_SESSION['Done'] = "Registration is done.";
      header("Location: registration.php");
      exit();
    }

  } else {
    $_SESSION['errors'] = $errors;
    $_SESSION['data'] = $data;
  }
} else {
  unset($_SESSION['data']);
}

?>

    <div class="background-image"></div>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" class="form" method="post">
        <?php include ('../functions/message.php');  ?>

        <h2>SIGN UP</h2>
        <input type="text" name="name" class="box" placeholder="Enter your name"
            value="<?php echo isset($data['name']) ? $data['name'] : ''; ?>" required>
        <input type="text" name="email" class="box" placeholder="Enter your email"
            value="<?php echo isset($data['email']) ? $data['email'] : ''; ?>" required>
        <input type="password" name="pass" class="box" placeholder="Enter a password" required>
        <input type="password" name="con_pass" class="box" placeholder="Confirm password" required>
        <input type="text" name="phone" class="box" placeholder="Phone number"
            value="<?php echo isset($data['phone']) ? $data['phone'] : ''; ?>" required>
            
            <select name="gender" class="box" required>
            <option value="" disabled selected>Select Gender</option>
            <option value="male"<?php echo isset($data['gender']) && $data['gender'] === 'male' ? ' selected' : ''; ?>>Male</option>
            <option value="female"<?php echo isset($data['gender']) && $data['gender'] === 'female' ? ' selected' : ''; ?>>Female</option>
          </select>

        <input type="date" name="dob" class="box" placeholder="Date of birth"
            value="<?php echo isset($data['dob']) ? $data['dob'] : ''; ?>" required>
        <input type="text" name="weight" class="box" placeholder="Your weight"
            value="<?php echo isset($data['weight']) ? $data['weight'] : ''; ?>" required>
        <input type="text" name="height" class="box" placeholder="Your height"
            value="<?php echo isset($data['height']) ? $data['height'] : ''; ?>" required>
        <input type="submit" value="Register Now">
        <p>Already have an account? <a href="login.php">Login now</a></p>
    </form>
</body>

</html>