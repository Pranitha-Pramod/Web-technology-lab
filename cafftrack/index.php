<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CaffTrack - Login</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .auth-container {
            width: 90%;
            max-width: 420px;
            margin: 60px auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            text-align: center;
        }

        .auth-container h2 {
            margin-bottom: 20px;
            color: #123;
        }

        .auth-container input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        .auth-container button {
            width: 100%;
            padding: 12px;
            background: #ff7a3d;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 17px;
            cursor: pointer;
            margin-top: 10px;
        }

        .auth-container button:hover {
            background: #e5662c;
        }

        .toggle-link {
            margin-top: 15px;
            display: inline-block;
            color: #0f5c6e;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
        }

        .toggle-link:hover {
            text-decoration: underline;
        }

        #registerForm {
            display: none;
        }

        .hero-text {
            text-align: center;
            margin-top: 40px;
            color: #123;
        }

        .hero-text h2 {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .hero-text p {
            font-size: 22px;
            max-width: 800px;
            margin: auto;
            line-height: 1.6;
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
            </ul>
        </nav>
    </header>

    <section class="hero-text">
        <h2>Monitor Your Daily Caffeine Intake Smartly</h2>
        <p>Track coffee, tea, and energy drinks while staying within healthy caffeine limits.</p>
    </section>

    <div class="auth-container">
        <!-- Login Form -->
    <div id="loginForm">
    <h2>Login</h2>

    <?php
    if (isset($_SESSION['login_error'])) {
        echo "<p class='message'>" . $_SESSION['login_error'] . "</p>";
        unset($_SESSION['login_error']);
    }
    ?>

    <form action="login_process.php" method="POST">
        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <button type="submit">Login</button>
    </form>

    <p>
        Don't have an account?
        <span class="toggle-link" onclick="showRegister()">Register here</span>
    </p>
    </div>
        <!-- Register Form -->
        <div id="registerForm">
    <h2>Register</h2>

    <?php
    if (isset($_SESSION['register_error'])) {
        echo "<p class='message'>" . $_SESSION['register_error'] . "</p>";
        unset($_SESSION['register_error']);
    }

    if (isset($_SESSION['register_success'])) {
        echo "<p class='message success'>" . $_SESSION['register_success'] . "</p>";
        unset($_SESSION['register_success']);
    }
    ?>

    <form action="register_process.php" method="POST">
        <input type="text" name="name" placeholder="Enter Name" required>
        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit">Register</button>
    </form>

    <p>
        Already have an account?
        <span class="toggle-link" onclick="showLogin()">Back to Login</span>
    </p>
</div>

    <footer>
        <p>© 2026 CaffTrack | Web Technologies Project</p>
    </footer>

    <script>
    function showRegister() {
        document.getElementById("loginForm").style.display = "none";
        document.getElementById("registerForm").style.display = "block";
    }

    function showLogin() {
        document.getElementById("registerForm").style.display = "none";
        document.getElementById("loginForm").style.display = "block";
    }

    window.onload = function() {
        const params = new URLSearchParams(window.location.search);
        if (params.get("form") === "register") {
            showRegister();
        }
    };
</script>

</body>
</html>