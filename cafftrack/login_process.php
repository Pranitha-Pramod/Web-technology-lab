<?php
session_start();
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_name'] = $user['name'];
            setcookie("user_name", $user['name'], time() + (86400 * 7), "/");

            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['login_error'] = "Incorrect password.";
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "Email not found.";
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>