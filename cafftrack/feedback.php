<?php
session_start();
include 'includes/db.php';

$message_status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    if (!empty($name) && !empty($email) && !empty($message)) {
        $sql = "INSERT INTO feedback (name, email, message) VALUES ('$name', '$email', '$message')";

        if (mysqli_query($conn, $sql)) {
            $message_status = "Thank you! Feedback submitted successfully ✅";
        } else {
            $message_status = "Error: " . mysqli_error($conn);
        }
    } else {
        $message_status = "Please fill all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - CaffTrack</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <nav>
        <h1>CaffTrack</h1>
        <ul>
            <li><a href="about.php">About</a></li>
            <li><a href="features.php">Features</a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="feedback.php">Feedback</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<section class="form-section">
    <div class="form-box">
        <h2>Feedback</h2>
        <p>Share your feedback about CaffTrack.</p>

        <?php if (!empty($message_status)) { ?>
            <p class="message"><?php echo $message_status; ?></p>
        <?php } ?>

        <form method="POST" action="">
            <input type="text" name="name" placeholder="Enter your name" required>
            <input type="email" name="email" placeholder="Enter your email" required>
            <textarea name="message" rows="5" placeholder="Enter your feedback" required></textarea>
            <button type="submit" class="btn">Submit Feedback</button>
        </form>
    </div>
</section>

<footer>
    <p>© 2026 CaffTrack | Web Technologies Project</p>
</footer>

</body>
</html>