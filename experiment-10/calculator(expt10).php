<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background: #f4f4f4;
            border-radius: 10px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #5cb85c;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        button:hover {
            background-color: #4cae4c;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            background-color: #d9edf7;
            color: #31708f;
            border-radius: 4px;
            text-align: center;
            font-size: 18px;
        }
        .error {
            background-color: #f2dede;
            color: #a94442;
        }
    </style>
</head>
<body>
    <h1>PHP Calculator</h1>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label for="num1">Number 1:</label>
        <input type="number" name="num1" id="num1" step="any" required>

        <label for="num2">Number 2:</label>
        <input type="number" name="num2" id="num2" step="any" required>

        <label for="operation">Operation:</label>
        <select name="operation" id="operation" required>
            <option value="add">+ Addition</option>
            <option value="subtract">- Subtraction</option>
            <option value="multiply">* Multiplication</option>
            <option value="divide">/ Division</option>
            <option value="modulus">% Modulus (remainder)</option>
        </select>

        <button type="submit" name="submit">Calculate</button>
    </form>

    <?php
    // Check if form was submitted
    if (isset($_POST['submit'])) {
        // Get input values
        $num1 = $_POST['num1'];
        $num2 = $_POST['num2'];
        $operation = $_POST['operation'];
        $result = "";
        $error = "";

        // Validate that both inputs are numeric
        if (is_numeric($num1) && is_numeric($num2)) {
            // Perform calculation based on operation
            switch ($operation) {
                case 'add':
                    $result = $num1 + $num2;
                    $op_symbol = "+";
                    break;
                case 'subtract':
                    $result = $num1 - $num2;
                    $op_symbol = "-";
                    break;
                case 'multiply':
                    $result = $num1 * $num2;
                    $op_symbol = "*";
                    break;
                case 'divide':
                    if ($num2 == 0) {
                        $error = "Division by zero is not allowed!";
                    } else {
                        $result = $num1 / $num2;
                        $op_symbol = "/";
                    }
                    break;
                case 'modulus':
                    if ($num2 == 0) {
                        $error = "Modulus by zero is not allowed!";
                    } else {
                        $result = $num1 % $num2;
                        $op_symbol = "%";
                    }
                    break;
                default:
                    $error = "Invalid operation selected.";
            }

            // Display result or error
            if ($error) {
                echo "<div class='result error'>❌ $error</div>";
            } else {
                echo "<div class='result'>✅ $num1 $op_symbol $num2 = $result</div>";
            }
        } else {
            echo "<div class='result error'>❌ Please enter valid numbers.</div>";
        }
    }
    ?>
</body>
</html>