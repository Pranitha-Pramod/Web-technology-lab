<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_SESSION['user_name'];
    $drink_name = mysqli_real_escape_string($conn, $_POST['drink_name']);
    $quantity_ml = (int)$_POST['quantity_ml'];
    $caffeine_mg = (int)$_POST['caffeine_mg'];

    $sql = "INSERT INTO caffeine_logs (user_name, drink_name, quantity_ml, caffeine_mg)
            VALUES ('$user_name', '$drink_name', '$quantity_ml', '$caffeine_mg')";

    if (mysqli_query($conn, $sql)) {
        $message = "Caffeine intake saved successfully.";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracker - CaffTrack</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <nav>
        <h1>CaffTrack</h1>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="features.php">Features</a></li>
            <li><a href="tracker.php">Tracker</a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<section class="form-section">
    <div class="form-box">
        <h2>Caffeine Tracker</h2>
        <p>Welcome, <?php echo $_SESSION['user_name']; ?>. Track your daily caffeine intake here.</p>

        <?php if (!empty($message)) { ?>
            <p class="message"><?php echo $message; ?></p>
        <?php } ?>

        <form method="POST" action="">
            <select name="drink_name" id="drink_name" required onchange="calculateCaffeine()">
                <option value="">Select Drink</option>
                <option value="Coffee">Coffee</option>
                <option value="Tea">Tea</option>
                <option value="Energy Drink">Energy Drink</option>
                <option value="Soft Drink">Soft Drink</option>
            </select>

            <input type="number" name="quantity_ml" id="quantity_ml" placeholder="Enter quantity in ml" required oninput="calculateCaffeine()">

            <input type="number" name="caffeine_mg" id="caffeine_mg" placeholder="Caffeine in mg" readonly>

            <button type="submit" class="btn">Save Intake</button>
        </form>
    </div>
</section>

<script src="js/script.js"></script>

<footer>
    <p>© 2026 CaffTrack | Web Technologies Project</p>
</footer>

</body>
</html>