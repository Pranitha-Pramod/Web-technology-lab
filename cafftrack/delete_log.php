<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    mysqli_query($conn, "DELETE FROM caffeine_logs WHERE id=$id");
}

header("Location: dashboard.php");
exit();
?>