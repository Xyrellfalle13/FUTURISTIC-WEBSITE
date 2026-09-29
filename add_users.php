<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

require_once "db.php";

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $fullname = trim($_POST["fullname"] ?? "");
    $username = trim($_POST["username"] ?? "");
    $birthdate = $_POST["birthdate"] ?? "";
    $password = $_POST["password"] ?? "";

    if (
        $fullname === "" ||
        $username === "" ||
        $birthdate === "" ||
        $password === ""
    ) {

        $message = "PLEASE COMPLETE ALL FIELDS";
        $messageType = "error";

    } elseif (strlen($password) < 8) {

        $message = "PASSWORD MUST BE AT LEAST 8 CHARACTERS";
        $messageType = "error";

    } else {

        $check = $conn->prepare(
            "SELECT id FROM users WHERE username = ?"
        );

        $check->bind_param(
            "s",
            $username
        );

        $check->execute();

        $result = $check->get_result();

        if ($result->num_rows > 0) {

            $message = "USERNAME ALREADY EXISTS";
            $messageType = "error";

        } else {

            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $stmt = $conn->prepare(
                "INSERT INTO users
                (fullname, username, birthdate, password)
                VALUES (?, ?, ?, ?)"
            );

            $stmt->bind_param(
                "ssss",
                $fullname,
                $username,
                $birthdate,
                $hashedPassword
            );

            if ($stmt->execute()) {

                header("Location: users.php");
                exit();

            } else {

                $message =
                    "ERROR: " . $stmt->error;

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

    <title>Add User | XY Future</title>

    <link
        rel="stylesheet"
        href="style.css"
    >

</head>

<body>

<div class="grid"></div>

<div class="login-container">

    <div class="login-card">

        <div class="logo-container">

            <div class="xy-logo">
                XY
            </div>

            <div class="logo-text">
                FUTURE
            </div>

        </div>

        <h1>
            ADD USER
        </h1>

        <p class="subtitle">
            Create a new system account
        </p>


        <?php if ($message !== ""): ?>

            <div class="status-message <?= $messageType ?>">

                <?= htmlspecialchars($message) ?>

            </div>

        <?php endif; ?>


        <form method="POST">

            <div class="input-group">

                <input
                    type="text"
                    name="fullname"
                    required
                >

                <label>
                    FULL NAME
                </label>

            </div>


            <div class="input-group">

                <input
                    type="text"
                    name="username"
                    required
                >

                <label>
                    USERNAME
                </label>

            </div>


            <div class="input-group">

                <input
                    type="date"
                    name="birthdate"
                    required
                >

                <label>
                    DATE OF BIRTH
                </label>

            </div>


            <div class="input-group">

                <input
                    type="password"
                    name="password"
                    required
                >

                <label>
                    PASSWORD
                </label>

            </div>


            <button
                type="submit"
                class="login-btn"
            >
                ADD USER
            </button>

        </form>


        <p class="register-text">

            <a href="users.php">
                ← BACK TO USERS
            </a>

        </p>

    </div>

</div>

</body>

</html>