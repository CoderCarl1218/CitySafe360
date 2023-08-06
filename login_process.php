<?php
// Include the database connection file
require 'admin/db_connect.php';

session_start();

if (isset($_POST["login"])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Retrieve user data from the database based on the email
    $result = mysqli_query($conn, "SELECT * FROM complainants WHERE email = '$email'");
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];

        // Verify the password using password_verify()
        if (password_verify($password, $hashed_password)) {
            $_SESSION['login'] = true;
            $_SESSION['id'] = $row['id'];
            header("Location: home.php"); // Replace 'home.php' with your desired landing page after successful login
            exit();
        } else {
            echo "<script>alert('Invalid email or password'); window.location = 'index.php';</script>";
        }
    }
}
?>