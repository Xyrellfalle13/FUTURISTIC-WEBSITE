<?php
session_start();
require_once "db.php";

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $fullname = trim($_POST["fullname"] ?? "");
    $username = trim($_POST["username"] ?? "");
    $birthdate = $_POST["birthdate"] ?? "";
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirmPassword"] ?? "";

    if (
        $fullname === "" ||
        $username === "" ||
        $birthdate === "" ||
        $password === "" ||
        $confirmPassword === ""
    ) {

        $message = "PLEASE COMPLETE ALL FIELDS";
        $messageType = "error";

    } elseif (strlen($username) < 4) {

        $message = "USERNAME MUST BE AT LEAST 4 CHARACTERS";
        $messageType = "error";

    } elseif (strlen($password) < 8) {

        $message = "PASSWORD MUST BE AT LEAST 8 CHARACTERS";
        $messageType = "error";

    } elseif ($password !== $confirmPassword) {

        $message = "PASSWORDS DO NOT MATCH";
        $messageType = "error";

    } elseif (!isset($_POST["terms"])) {

        $message = "PLEASE ACCEPT THE TERMS & CONDITIONS";
        $messageType = "error";

    } else {

        // Check if username already exists
        $check = $conn->prepare(
            "SELECT id FROM users WHERE username = ?"
        );

        if (!$check) {
            die("SQL Error: " . $conn->error);
        }

        $check->bind_param("s", $username);
        $check->execute();

        $result = $check->get_result();

        if ($result->num_rows > 0) {

            $message = "USERNAME ALREADY EXISTS";
            $messageType = "error";

        } else {

            // Hash password
            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            // Insert account
            $stmt = $conn->prepare(
                "INSERT INTO users
                (fullname, username, birthdate, password)
                VALUES (?, ?, ?, ?)"
            );

            if (!$stmt) {
                die("SQL Error: " . $conn->error);
            }

            $stmt->bind_param(
                "ssss",
                $fullname,
                $username,
                $birthdate,
                $hashedPassword
            );

            if ($stmt->execute()) {

                $_SESSION["registration_success"] =
                    "REGISTRATION SUCCESSFUL! YOU CAN NOW LOG IN.";

                // THIS IS THE IMPORTANT REDIRECT
                header("Location: index.php");
                exit();

            } else {

                $message =
                    "REGISTRATION FAILED: " . $stmt->error;

                $messageType = "error";
            }

            $stmt->close();
        }

        $check->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Create Account | Future System</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="grid"></div>

<div class="login-container">

    <div class="login-card">

        <div class="logo">

        <br>

        <br>

        <br>


            ✦ FUTURE
        </div>

        <h1>CREATE ACCOUNT</h1>

        <p class="subtitle">
            Join the future today
        </p>

        <?php if ($message !== ""): ?>

            <div class="status-message <?= $messageType ?>">
                <?= htmlspecialchars($message) ?>
            </div>

        <?php endif; ?>

        <form method="POST" action="register.php">

            <div class="input-group">

                <input
                    type="text"
                    name="fullname"
                    id="fullname"
                    required
                >

                <label for="fullname">
                    FULL NAME
                </label>

            </div>

            <div class="input-group">

                <input
                    type="text"
                    name="username"
                    id="username"
                    required
                >

                <label for="username">
                    USERNAME
                </label>

            </div>

            <div class="input-group">

                <input
                    type="date"
                    name="birthdate"
                    id="birthdate"
                    required
                >

                <label for="birthdate">
                    DATE OF BIRTH
                </label>

            </div>

            <div class="input-group">

                <input
                    type="password"
                    name="password"
                    id="password"
                    required
                >

                <label for="password">
                    PASSWORD
                </label>

            </div>

            <div class="input-group">

                <input
                    type="password"
                    name="confirmPassword"
                    id="confirmPassword"
                    required
                >

                <label for="confirmPassword">
                    CONFIRM PASSWORD
                </label>

            </div>

            <div class="terms">

                <input
                    type="checkbox"
                    name="terms"
                    id="terms"
                    required
                >

                <label for="terms">
                    I agree to the Terms & Conditions
                </label>

            </div>

            <button
                type="submit"
                class="login-btn"
            >
                CREATE ACCOUNT
            </button>

        </form>

        <p class="register-text">

            Already have an account?

            <a href="index.php">
                LOGIN
            </a>

        </p>

    </div>

</div>

<script src="script.js"></script>

</body>
</html>