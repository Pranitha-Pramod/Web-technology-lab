<?php
session_start();
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['register_error'] = "Please fill all fields.";
        header("Location: index.php?form=register");
        exit();
    }

    if ($password !== $confirm_password) {
        $_SESSION['register_error'] = "Passwords do not match.";
        header("Location: index.php?form=register");
        exit();
    }

    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $checkEmail);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['register_error'] = "Email already registered.";
        header("Location: index.php?form=register");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashedPassword')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['register_success'] = "Registration successful. You can now login.";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['register_error'] = "Error: " . mysqli_error($conn);
        header("Location: index.php?form=register");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>