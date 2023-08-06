<?php
// Include the database connection file
require 'admin/db_connect.php';

if (isset($_POST["submit"])) {
  $name = $_POST["name"];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $contact = $_POST['contact'];
  $password = $_POST['password'];
  $confirmpassword = $_POST['confirmpassword'];

  // Check if the email is already taken
  $duplicate = mysqli_query($conn, "SELECT * FROM complainants WHERE email ='$email'");
  if (mysqli_num_rows($duplicate) > 0) {
    echo "<script>alert('Email is Already Taken');</script>";
  } else {
    if ($password == $confirmpassword) {
      // Encrypt the password for security
      $hashed_password = password_hash($password, PASSWORD_BCRYPT);

      // Insert user data into the database
      $query = "INSERT INTO complainants (name, address, contact, email, password) VALUES ('$name', '$address', '$contact', '$email', '$hashed_password')";
      if (mysqli_query($conn, $query)) {
        echo "<script>alert('Registration Successful');</script>";
      } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
      }
    } else {
      echo "<script>alert('Password does not match!');</script>";
    }
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <!-- Home -->
  <section class="home">
    <div class="form_container">
      <i class="uil uil-times form_close"></i>
      <!-- Login From -->
      <div class="form login_form">
        <form action="login_process.php" method="post">
          <h2>Login</h2>
          <div class="input_box">
            <input type="email" name="email" placeholder="Enter your email" required />
            <i class="uil uil-envelope-alt email"></i>
          </div>
          <div class="input_box">
            <input type="password" name="password" placeholder="Enter your password" required />
            <i class="uil uil-lock password"></i>
            <i class="uil uil-eye-slash pw_hide"></i>
          </div>
          <div class="option_field">
            <span class="checkbox">
              <input type="checkbox" id="check" />
              <label for="check">Remember me</label>
            </span>
            <a href="#" class="forgot_pw">Forgot password?</a>
          </div>
          <button class="button" name="login">Login Now</button>
          <div class="login_signup">Don't have an account? <a href="#" id="signup">Signup</a></div>
        </form>
      </div>
      <!-- Signup From -->
      <div class="form signup_form">
        <form action="#" method="post">
          <h2>Signup</h2>

          <div class="input_box">
            <i class="uil uil-user"></i>
            <input type="text" name="name" placeholder="Name" required />
          </div>
          <div class="input_box">
            <i class="uil uil-phone-alt"></i>
            <input type="text" name="contact" placeholder="Contact number" required />
          </div>
          <div class="input_box">
            <i class="uil uil-house-user"></i>
            <input type="text" name="address" placeholder="Address" required />
          </div>
          <div class="input_box">
            <input type="email" name="email" placeholder="Enter your email" required />
            <i class="uil uil-envelope-alt email"></i>
          </div>
          <div class="input_box">
            <input type="password" name="password" placeholder="Create password" required />
            <i class="uil uil-lock password"></i>
            <i class="uil uil-eye-slash pw_hide"></i>
          </div>
          <div class="input_box">
            <input type="password" name="confirmpassword" placeholder="Confirm password" required />
            <i class="uil uil-lock password"></i>
            <i class="uil uil-eye-slash pw_hide"></i>
          </div>
          <button class="button" name="submit">Signup Now</button>
          <div class="login_signup">Already have an account? <a href="signup.php" id="login">Login</a></div>
        </form>
      </div>
    </div>
  </section>
  <script src="script.js"></script>
</body>
<style>



</style>

</html>