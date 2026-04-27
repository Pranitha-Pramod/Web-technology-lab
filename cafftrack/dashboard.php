<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_name'])) {
    header("Location: index.php");
    exit();
}

$user_name = $_SESSION['user_name'];

// Handle intake form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_intake'])) {
    $drink_name = mysqli_real_escape_string($conn, $_POST['drink_name']);
    $quantity_ml = (int) $_POST['quantity_ml'];
    $caffeine_mg = (int) $_POST['caffeine_mg'];

    $insertQuery = "INSERT INTO caffeine_logs (user_name, drink_name, quantity_ml, caffeine_mg, intake_time)
                    VALUES ('$user_name', '$drink_name', '$quantity_ml', '$caffeine_mg', NOW())";

    mysqli_query($conn, $insertQuery);

    header("Location: dashboard.php");
    exit();
}

// Fetch all logs
$sql = "SELECT * FROM caffeine_logs WHERE user_name='$user_name' ORDER BY intake_time DESC";
$result = mysqli_query($conn, $sql);

// Total for today
$total_today = 0;
$totalQuery = "SELECT SUM(caffeine_mg) AS total 
               FROM caffeine_logs 
               WHERE user_name='$user_name' AND DATE(intake_time)=CURDATE()";
$totalResult = mysqli_query($conn, $totalQuery);

if ($row = mysqli_fetch_assoc($totalResult)) {
    $total_today = $row['total'];
    if ($total_today == null) {
        $total_today = 0;
    }
}

$limit = 400;
$progress = ($total_today / $limit) * 100;

if ($progress > 100) {
    $progress = 100;
}

$status_text = "";
$status_class = "";
$bar_color = "#4caf50";

if ($total_today <= 200) {
    $status_text = "Safe intake level ✅";
    $status_class = "safe-msg";
    $bar_color = "#4caf50";
} elseif ($total_today <= 400) {
    $status_text = "Moderate intake level ⚠️";
    $status_class = "moderate-msg";
    $bar_color = "#ff9800";
} else {
    $status_text = "High caffeine intake! ❌";
    $status_class = "danger-msg";
    $bar_color = "#f44336";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CaffTrack</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .tracking-form {
            margin: 25px 0;
            padding: 20px;
            background: #f8f8f8;
            border-radius: 12px;
        }

        .tracking-form h3 {
            margin-bottom: 15px;
        }

       

        .tracking-form button {
            padding: 12px 22px;
            background: #ff7a3d;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }

        .tracking-form button:hover {
            background: #e5672e;
        }

        .progress-bar-wrapper {
            width: 350px;
            height: 22px;
            background-color: #d9d9d9;
            border: 1px solid #bfbfbf;
            border-radius: 20px;
            overflow: hidden;
            margin: 15px 0 8px 0;
        }

        .progress-bar-fill {
            height: 100%;
            border-radius: 20px;
        }
        .tracking-form select,
.tracking-form input {
    width: 100%;
    max-width: 350px;
    padding: 10px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 8px;
    display: block;
    font-size: 16px;
    background: white;
}
    </style>
</head>
<body>

<header>
    <nav>
        <h1>CaffTrack</h1>
        <ul>
            <li><a href="about.php">About</a></li>
            <li><a href="features.php">Features</a></li>
            <li><a href="feedback.php">Feedback</a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<section class="dashboard-section">
    <div class="dashboard-box">

        <h2>Welcome, <?php echo $_SESSION['user_name']; ?></h2>

        <?php if (isset($_COOKIE['user_name'])) { ?>
            <p class="summary">Welcome back, <?php echo $_COOKIE['user_name']; ?> 👋</p>
        <?php } ?>

        <div class="dashboard-cards">
            <div class="card">
                <h4>Today's Intake</h4>
                <p><?php echo $total_today; ?> mg</p>
            </div>

            <div class="card">
                <h4>Daily Limit</h4>
                <p><?php echo $limit; ?> mg</p>
            </div>

            <div class="card">
                <h4>Status</h4>
                <p>
                    <?php
                    if ($total_today <= 200) {
                        echo "Safe ✅";
                    } elseif ($total_today <= 400) {
                        echo "Moderate ⚠️";
                    } else {
                        echo "High ❌";
                    }
                    ?>
                </p>
            </div>
        </div>

       <div class="tracking-form">
    <h3>Add Caffeine Intake</h3>
    <form method="POST" action="">
        <select name="drink_name" id="drink_name" onchange="calculateCaffeine()" required>
            <option value="">Select Drink</option>
            <option value="Coffee" data-base-ml="240" data-caffeine="95">Coffee</option>
            <option value="Tea" data-base-ml="240" data-caffeine="40">Tea</option>
            <option value="Green Tea" data-base-ml="240" data-caffeine="30">Green Tea</option>
            <option value="Espresso" data-base-ml="30" data-caffeine="63">Espresso</option>
            <option value="Energy Drink" data-base-ml="250" data-caffeine="80">Energy Drink</option>
            <option value="Coca Cola" data-base-ml="330" data-caffeine="34">Coca Cola</option>
            <option value="Cold Coffee" data-base-ml="250" data-caffeine="100">Cold Coffee</option>
            <option value="Black Tea" data-base-ml="240" data-caffeine="47">Black Tea</option>
            <option value="Milk Tea" data-base-ml="240" data-caffeine="35">Milk Tea</option>
            <option value="Chocolate Drink" data-base-ml="200" data-caffeine="20">Chocolate Drink</option>
        </select>

        <input type="number" name="quantity_ml" id="quantity_ml" placeholder="Enter quantity in ml" oninput="calculateCaffeine()" required>

        <input type="number" name="caffeine_mg" id="caffeine_mg" placeholder="Caffeine in mg" readonly required>

        <button type="submit" name="add_intake">Add Intake</button>
        <p style="margin-top:10px; color:#666; font-size:14px;">
    * Caffeine is calculated automatically based on selected drink and quantity.
</p>
    </form>
</div>

        <p class="summary">Today's Total Caffeine Intake: <strong><?php echo $total_today; ?> mg</strong></p>

        <p class="<?php echo $status_class; ?>"><?php echo $status_text; ?></p>
        <?php if ($total_today > 400) { ?>
    <p style="color:red; font-weight:bold;">
        Warning: You have exceeded healthy daily caffeine intake!
    </p>
<?php } ?>

        <div class="progress-bar-wrapper">
            <div class="progress-bar-fill" style="width: <?php echo $progress; ?>%; background-color: <?php echo $bar_color; ?>;"></div>
        </div>

        <p class="progress-text"><?php echo $total_today; ?> / <?php echo $limit; ?> mg</p>

        <h3>Your Caffeine History</h3>

        <table>
            <tr>
                <th>ID</th>
                <th>Drink</th>
                <th>Quantity (ml)</th>
                <th>Caffeine (mg)</th>
                <th>Date & Time</th>
                <th>Action</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['drink_name']; ?></td>
                    <td><?php echo $row['quantity_ml']; ?></td>
                    <td><?php echo $row['caffeine_mg']; ?></td>
                    <td><?php echo $row['intake_time']; ?></td>
                    <td>
                        <a href="delete_log.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this record?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>

    </div>
</section>

<footer>
    <p>© 2026 CaffTrack | Web Technologies Project</p>
</footer>
<script>
function calculateCaffeine() {
    const drinkSelect = document.getElementById("drink_name");
    const quantityInput = document.getElementById("quantity_ml");
    const caffeineInput = document.getElementById("caffeine_mg");

    const selectedOption = drinkSelect.options[drinkSelect.selectedIndex];

    const baseMl = parseFloat(selectedOption.getAttribute("data-base-ml"));
    const baseCaffeine = parseFloat(selectedOption.getAttribute("data-caffeine"));
    const quantity = parseFloat(quantityInput.value);

    if (!isNaN(baseMl) && !isNaN(baseCaffeine) && !isNaN(quantity) && quantity > 0) {
        const calculatedCaffeine = (quantity / baseMl) * baseCaffeine;
        caffeineInput.value = Math.round(calculatedCaffeine);
    } else {
        caffeineInput.value = "";
    }
}
</script>
</body>
</html>