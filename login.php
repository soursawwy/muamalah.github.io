<?php
session_start();

// Create a database connection
$conn = new mysqli('localhost', 'root', '', 'muamalah_repository');

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $captcha_response = $_POST['g-recaptcha-response'];

    // Verify reCAPTCHA
    $secret_key = '6LcdGGYqAAAAADcw1_-cw2TZkx7GXRcN7u7V27yd'; // Replace with your real secret key
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=$captcha_response");
    $response_data = json_decode($response);

    if ($response_data->success) {
        $stmt = $conn->prepare("SELECT name FROM students WHERE student_id = ?");
        $stmt->bind_param('s', $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['student_id'] = $student_id;
            $_SESSION['name'] = $row['name']; // Store the name in the session
            header('Location: index.php');
            exit();
        } else {
            $error = "Student ID not found.";
        }
    } else {
        $error = "Invalid captcha. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Muamalah Repository</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script> <!-- Load reCAPTCHA -->
    <style>
        /* Additional styles for the login page */
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .login-container h2 {
            text-align: center;
            color: #004b8d;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            border-color: #004b8d;
            outline: none;
        }

        .login-button {
            width: 100%;
            padding: 10px;
            background-color: #004b8d;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-button:hover {
            background-color: #00376b;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h2>Login</h2>
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="student_id">Student ID:</label>
                    <input type="text" id="student_id" name="student_id" required>
                </div>

                <!-- Google reCAPTCHA widget -->
                <div class="form-group">
                    <div class="g-recaptcha" data-sitekey="6LcdGGYqAAAAAMQomN63ZxHq86vAlVqrEatAAyEV"></div> <!-- Replace with your real site key -->
                </div>

                <button type="submit" class="login-button">Login</button>
            </form>

            <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
        </div>
    </div>
</body>
</html>
